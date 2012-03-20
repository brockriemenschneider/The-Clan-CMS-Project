<?php
/**
 * Clan CMS
 *
 * An open source application for gaming clans
 *
 * @package		Clan CMS
 * @author		Xcel Gaming Development Team
 * @copyright	Copyright (c) 2010 - 2011, Xcel Gaming, Inc.
 * @license		http://www.xcelgaming.com/about/license/
 * @link		http://www.xcelgaming.com
 * @since		Version 0.6.2
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Events Controller
 *
 * @package		Clan CMS
 * @subpackage	Controllers
 * @category		Controllers
 * @author		co[dezyne]
 * @link			http://www.codezyne.me
 */
class Events extends CI_Controller {
	
	/**
	 * Constructor
	 *
	 */	
	function __construct()
	{
		// Call the Controller constructor
		parent::__construct();
		
		// Load Calendar Library
		$this->load->library('Calendar', 'calendar');
		
		// Load the Events Model
		$this->load->model( 'Events_model', 'events');
		
		// Load the Matches Model
		$this->load->model('Matches_model', 'matches');	
		
		// Load the Tournament Model
		$this->load->model('Tournaments_model', 'tourneys');	
		
	}
	
	// --------------------------------------------------------------------
	/**
	 * Events
	 *
	 * Display's the monthly events calendar
	 *
	 * @access	public
	 * @return	void
	 */
	function _remap($month)
	{
		// Sort routing
		if($this->uri->segment(3)): $this->single_event($this->uri->segment(3)); endif;
		if($add_event = $this->input->post('add_event')): $this->add_event($add_event); endif;
		

		// Convert arguments and create time elements
		$data = explode('-', $month);
		$month = $data[0];
		$year = '20'.$data[1];
		$time = time();
		$today = date('j', $time);
		$months = array(1=>'jan', 2=>'feb', 3=>'mar', 4=>'apr', 5=>'may', 6=>'jun', 7=>'jul', 8=>'aug', 9=>'sep', 10=>'oct', 11=>'nov', 12=>'dec');
		$month = array_search($month, $months);
		$this_month = date('F', mktime(0,0,0, $month, 1, $year));

		// Retrieve this months events
		if($events = $this->events->get_events(array('event_month' => $month, 'event_year' => $year)))
		{
			$event = array();
			foreach($events as $entry)
			{
				// Create array for calendar
				$event[$entry->event_day] = array( lcfirst(date("M-y", mktime(0, 0, 0, $entry->event_month))) . '/' . $entry->event_slug, 'calendar-event', 'Event: ' . $entry->event_title);
				
				// Check event against current time
				($entry->event_day == $today ? $current_events[] = $entry : ($entry->event_day < $today ? $past_events[] = $entry : $future_events[] = $entry));
	
			}
		}
		
		// Retrieve this month's matches
		if($matches = $this->matches->get_matches_like($year . '-' . ($month < 10 ? $month = '0'.$month : $month)))
		{
			if( !isset($event)) $event = array();
			foreach($matches as $match)
			{
				// Reformat match date
				$data = explode('-', $match->match_date);
				$match->year = $data[0];
				$match->month = $data[1];
				$match->day = explode(' ', $data[2]);
				$match->day = $match->day[0];
				$match->title = str_replace('-', ' ', $match->match_slug);
				$match->title = preg_replace("/[0-9]/", 'Match: ', $match->title);

				// Create array for calendar
				$event[$match->day] = array($match->match_slug, 'calendar-match', $match->title );
				
			}
		}

		// Create previous and next month anchors
		$prev_next = array(
				'&lt;&lt;'	=> lcfirst(date('M-y', mktime(0,0,0, $month-1, 1, $year))),
		 		'&gt;&gt;'	=> lcfirst(date('M-y', mktime(0,0,0, $month+1, 1, $year))),
		 		);
		
		 // Create the calendar
		$calendar = $this->calendar->clancms_calendar($time, $year,  $month, (isset($event) ? $event : ''), 2, lcfirst(date('M-y', mktime(0,0,0, $month, 1, $year))), 0, $prev_next);
			

		
		// Reference objects
		$this->data->this_month = $this_month;
		$this->data->current_events =& $current_events;
		$this->data->past_events =& $past_events;
		$this->data->future_events =& $future_events;
		$this->data->events =& $events;
		$this->data->time = $time;
		$this->data->calendar = $calendar;
		
	
		// Load the articles view
		$this->load->view(THEME . 'events', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Add
	 *
	 * Adds an event
	 *
	 * @access	public
	 * @return	void
	 */
	function add_event()
	{
		
		// Check to see if user is an administrator
		if(!$this->user->is_administrator())
		{
			// Alert the user
			$this->session->flashdata('message', 'You do not have permission to do that!');
			
			// User is not an administrator, redirect them
			redirect('account/login');
			
		}
		
		
		// Check if the administrator has permission
		if(!$this->user->has_permission('settings'))
		{
			// Administrator doesn't have permission, show error, and exit
			$error =& load_class('Exceptions', 'core');
			echo $error->show_error('Access Denied!', 'You do not have permission to create events!');
			exit;
		}
		
		
		$event = $this->input->post('add_event');
		
		if($event)
		{
			// Set form validation rules
			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('summary', 'Summary', 'trim|required');
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{
				// Chunk date
				$date = explode('/', $this->input->post('date'));
				$month = $date[0];
				$day = $date[1];
				$year = $date[2];
				$time = $this->input->post('hour') . ':' . $this->input->post('mins');
				
				
				$data = array(
					'event_year'	=>	$year,
					'event_month'	=>	$month,
					'event_day'	=>	$day,
					'event_time'	=>	$time,
					'event_owner_id'	=>	$this->session->userdata('user_id'),
					'event_title'	=>	$this->input->post('title'),
					'event_summary'	=>	$this->input->post('summary'),
					'signups_enabled'	=>	$this->input->post('singups'),
					);
					
				$this->events->insert_event($data);
				
				// Retrieve the event id
				$event_id = $this->db->insert_id();
				
				// Set up the data
				$data = array (
					'event_slug'		=> $event_id . '-' . url_title($this->input->post('title'))
				);
				
				// Update the article in the database
				$this->events->update_event($event_id, $data);
				
				// Alert the user
				$this->session->flashdata('events', $this->input->post('title') . 'has been added to the calendar');
				
				// Redirect
				redirect($this->session->userdata('previous'));
			}
		}
		
	}
	
	
	function single_event($event)
	{
		($this->data->event = $this->events->get_event(array('event_slug' => $event)) or redirect($this->session->userdata('previous')));
		
		$this->load->view(THEME . 'event', $this->data);
	}
	
}

/* End of file events.php */
/* Location: ./clancms/controllers/events.php */
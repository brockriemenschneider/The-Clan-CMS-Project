<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * Clan CMS
 *
 * An open source application for gaming clans
 *
 * @package		Clan CMS
 * @author		Xcel Gaming Development Team
 * @copyright		Copyright (c) 2010 - 2011, Xcel Gaming, Inc.
 * @license		http://www.xcelgaming.com/about/license/
 * @link			http://www.xcelgaming.com
 * @since			Version 0.6.0
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Calendar Widget
 *
 * @package		Clan CMS
 * @subpackage	Widgets
 * @category		Widgets
 * @author		co[dezyne]
 * @link			http://codezyne.me
 */
class Calendar_widget extends Widget {

	// Widget information
	public $title = 'Calendar';
	public $description = "Calendar for scheduling and tracking of events.";
	public $author = 'co[dezyne]';
	public $link = 'http://codezyne.me';
	public $version = '0.6';
	public $requires = '0.6.2';
	public $compatible = '0.6.2';
	
	/**
	 * Constructor
	 *
	 */
	function __construct()
	{
		// Call the Widget constructor
		parent::__construct();
		
		// Create a instance to CI
		$CI =& get_instance();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the calendar
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Load Calendar Library
		$this->CI->load->library('Calendar', 'calendar');
		
		// Load Events model
		$this->CI->load->model('Events_model', 'events');
		
		// Load Matches model
		$this->CI->load->model('Matches_model', 'matches');
		
		$time = time();
		$today = date('j', $time);
		
		// Retrieve this months events & matches
		$events = $this->CI->events->get_events(array('event_month' => date('n', $time)));
		$events_count = $this->CI->events->count_events(array('event_month' => date('n', $time)));
		$matches = $this->CI->matches->get_matches_like((date('Y-n', $time)));
		$matches_count = $this->CI->matches->count_matches(array('match_date' => date('Y-n', $time)));
		$event = array();
		
		// Retrieve this month's events
		if($events)
		{
			foreach($events as $entry)
			{
				// Create array for calendar
				$event[$entry->event_day] = array( lcfirst(date("M-y", mktime(0, 0, 0, $entry->event_month))) . '/' . $entry->event_slug, 'calendar-event', 'Event: ' .$entry->event_title);
			}
		}
		
		// Retrieve this month's matches
		if($matches)
		{
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
		 	'&lt;&lt;'	=> lcfirst(date('M-y', strtotime('-1 Month'))),
		 	'&gt;&gt;'	=> lcfirst(date('M-y', strtotime('+1 Month'))),
		 );
		 
		 // Create the calendar
		$calendar = $this->CI->calendar->clancms_calendar($time, date('y', $time),  date('n', $time), (isset($event) ? $event : ''), 1, lcfirst(date('M-y', $time)), 0, $prev_next);
		
		// Reference objects
		$this->data->calendar = $calendar;
		$this->data->events_count = $events_count;
		$this->data->matches_count = $matches_count;
		
		
		// Assign the widget info
		$widget->title = 'Calendar'; // This left intentionally blank
		$widget->content = $this->CI->load->view('widgets/calendar', $this->data, TRUE);
		$widget->tabs = array();
			
		// Load the widget view
		$this->CI->load->view(WIDGET . 'widget', $widget);
	}
	
	
	// --------------------------------------------------------------------
	/**
	 * Uninstall
	 *
	 * Uninstall's the widget
	 *
	 * @access	public
	 * @return	void
	 */
	function uninstall()
	{
		// Assign files
		$files = array(
			APPPATH . 'views/widgets/calendar.php'
		);
		
		// Loop through the files
		foreach($files as $file)
		{
			// Check if the file exists
			if(file_exists($file))
			{
				// Delete the file
				unlink($file);
			}
		}
		
		// Delete the widget
		unlink(__FILE__);
	}
}
	
/* End of file calendar_widget.php */
/* Location: ./clancms/widgets/calendar_widget.php */
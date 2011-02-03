<?php
/**
 * Clan CMS
 *
 * An open source application for gaming clans
 *
 * @package		Clan CMS
 * @author		Xcel Gaming Development Team
 * @copyright	Copyright (c) 2010, Xcel Gaming, Inc.
 * @license		http://www.xcelgaming.com/about/license/
 * @link		http://www.xcelgaming.com
 * @since		Version 0.5.6
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Opponents Controller
 *
 * @package		Clan CMS
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Opponents extends Controller {

	/**
	 * Constructor
	 *
	 */	
	function Opponents()
	{
		// Call the Controller constructor
		parent::Controller();
		
		// Load the matches model
		$this->load->model('Matches_model', 'matches');
		
		// Load the squads model
		$this->load->model('Squads_model', 'squads');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the opponents
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Retrieve the current page
		$page = $this->uri->segment(3, '');
	
		// Check if page exists
		if($page == '')
		{
			// Page doesn't exist, assign it
			$page = 1;
		}
	
		//Set up the variables
		$per_page = 10;
		$total_results = $this->matches->count_opponents();
		$offset = ($page - 1) * $per_page;
		$pages->total_pages = 0;
		
		// Create the pages
		for($i = 1; $i < ($total_results / $per_page) + 1; $i++)
		{
			// Itterate pages
			$pages->total_pages++;
		}
				
		// Check if there are no results
		if($total_results == 0)
		{
			// Assign total pages
			$pages->total_pages = 1;
		}
		
		// Set up pages
		$pages->current_page = $page;
		$pages->pages_left = 9;
		$pages->first = (bool) ($pages->current_page > 5);
		$pages->previous = (bool) ($pages->current_page > '1');
		$pages->next = (bool) ($pages->current_page != $pages->total_pages);
		$pages->before = array();
		$pages->after = array();
		
		// Check if the current page is towards the end
		if(($pages->current_page + 5) < $pages->total_pages)
		{
			// Current page is not towards the end, assign start
			$start = $pages->current_page - 4;
		}
		else
		{
			// Current page is towards the end, assign start
			$start = $pages->current_page - $pages->pages_left + ($pages->total_pages - $pages->current_page);
		}
		
		// Assign end
		$end = $pages->current_page + 1;
		
		// Loop through pages before the current page
		for($page = $start; ($page < $pages->current_page); $page++)
		{
			// Check if the page is vaild
			if($page > 0)
			{
				// Page is valid, add it the pages before, increment pages left
				$pages->before = array_merge($pages->before, array($page));
				$pages->pages_left--;
			}
		}
		
		// Loop through pages after the current page
		for($page = $end; ($pages->pages_left > 0 && $page <= $pages->total_pages); $page++)
		{
			// Add the page to pages after, increment pages left
			$pages->after = array_merge($pages->after, array($page));
			$pages->pages_left--;
		}
		
		// Set up pages
		$pages->last = (bool) (($pages->total_pages - 5) > $pages->current_page);
		
		// Retrieve the opponents
		$opponents = $this->matches->get_opponents($per_page, $offset);
		
		// Check if opponents exist
		if($opponents)
		{
			// Opponensts exist, loop through each opponent
			foreach($opponents as $opponent)
			{
				// Count the opponent's total matches
				$opponent->total_matches = $this->matches->count_matches(array('opponent_id' => $opponent->opponent_id));
			}
		}
		
		// Create a reference to opponents & pages
		$this->data->opponents =& $opponents;
		$this->data->pages =& $pages;
		
		// Load the opponents view
		$this->load->view(THEME . 'opponents', $this->data);
	}

	// --------------------------------------------------------------------
	
	/**
	 * View
	 *
	 * Display's a opponent
	 *
	 * @access	public
	 * @return	void
	 */
	function view()
	{
		// Retrieve the opponent
		if(!$opponent = $this->matches->get_opponent(array('opponent_slug' => $this->uri->segment(3, ''))))
		{
			// Opponent doesn't exist, redirect the user
			redirect('opponents');
		}

		// Retrieve the matches
		$matches = $this->matches->get_matches('', '', array('opponent_id' => $opponent->opponent_id));
		
		// Check if matches exist
		if($matches)
		{
			// Matches exist, loop through each match
			foreach($matches as $match)
			{
				// Retrieve the squad
				$squad = $this->squads->get_squad(array('squad_id' => $match->squad_id));
				
				// Check if squad exists
				if($squad)
				{
					// Squad exists, assign squad & squad slug
					$match->squad = $squad->squad_title;
					$match->squad_slug = $squad->squad_slug;
				}
				else
				{
					// Squad doesn't exist, don't assign it
					$match->squad = "";
					$match->squad_slug = "";
				}
		
				// Format each match date
				$match->date = $this->ClanCMS->timezone($match->match_date);
			}
		}
		
		// Create a reference to opponent & matches
		$this->data->opponent =& $opponent;
		$this->data->matches =& $matches;
		
		// Load the opponent view
		$this->load->view(THEME . 'opponent', $this->data);
	}
	
}

/* End of file opponents.php */
/* Location: ./clancms/controllers/opponents.php */
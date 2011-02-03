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
 * @since		Version 0.5.0
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Matches Controller
 *
 * @package		Clan CMS
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Matches extends Controller {

	/**
	 * Constructor
	 *
	 */	
	function Matches()
	{
		// Call the Controller constructor
		parent::Controller();
		
		// Load the matches model
		$this->load->model('Matches_model', 'matches');
		
		// Load the squads model
		$this->load->model('Squads_model', 'squads');
		
		// Load the typography library
		$this->load->library('typography');
		
		// Load the bbcode library
		$this->load->library('BBCode');
		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the latest matches
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
		$total_results = $this->matches->count_matches(array('match_date <' => mdate('%Y-%m-%d %H:%i:%s', local_to_gmt(time()))));
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
		
		// Retrieve the latest matches
		$matches = $this->matches->get_matches($per_page, $offset, array('match_date <' => mdate('%Y-%m-%d %H:%i:%s', local_to_gmt(time()))));
		
		// Check if matches exist
		if($matches)
		{
			// Matches exist, loop through each match
			foreach($matches as $match)
			{
				// Retrieve the opponent
				$opponent = $this->matches->get_opponent(array('opponent_id' => $match->opponent_id));
				
				// Check if opponent exists
				if($opponent)
				{
					// Opponent exists, assign opponent & opponent slug
					$match->opponent = $opponent->opponent_title;
					$match->opponent_slug = $opponent->opponent_slug;
				}
				else
				{
					// Opponent doesn't exist, don't assign it
					$match->opponent = "";
					$match->opponent_slug = "";
				}
				
				// Format each matches date
				$match->date = $this->ClanCMS->timezone($match->match_date);
				
				// Retrieve the squad
				$squad = $this->squads->get_squad(array('squad_id' => $match->squad_id));
				
				// Check if squad exists
				if($squad)
				{
					// Squad exists, assign the matches squad
					$match->squad = anchor('roster/squad/' . $squad->squad_slug, $squad->squad_title);
				}
				else
				{
					// Squad doesn't exist, don't assign it
					$match->squad = "";
				}
			}
		}
		
		// Create a reference to matches & pages
		$this->data->matches =& $matches;
		$this->data->pages =& $pages;
		
		// Load the matches view
		$this->load->view(THEME . 'matches', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Upcoming
	 *
	 * Display's the upcoming matches
	 *
	 * @access	public
	 * @return	void
	 */
	function upcoming()
	{
		// Retrieve the current page
		$page = $this->uri->segment(4, '');
	
		// Check if page exists
		if($page == '')
		{
			// Page doesn't exist, assign it
			$page = 1;
		}
	
		//Set up the variables
		$per_page = 10;
		$total_results = $this->matches->count_matches(array('match_date >' => mdate('%Y-%m-%d %H:%i:%s', local_to_gmt(time()))));
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
		
		// Retrieve the latest matches
		$matches = $this->matches->get_matches($per_page, $offset, array('match_date >' => mdate('%Y-%m-%d %H:%i:%s', local_to_gmt(time()))));
		
		// Check if matches exist
		if($matches)
		{
			// Matches exist, loop through each match
			foreach($matches as $match)
			{
				// Retrieve the opponent
				$opponent = $this->matches->get_opponent(array('opponent_id' => $match->opponent_id));
				
				// Check if opponent exists
				if($opponent)
				{
					// Opponent exists, assign opponent & opponent slug
					$match->opponent = $opponent->opponent_title;
					$match->opponent_slug = $opponent->opponent_slug;
				}
				else
				{
					// Opponent doesn't exist, don't assign it
					$match->opponent = "";
					$match->opponent_slug = "";
				}
				
				// Format each matches date
				$match->date = $this->ClanCMS->timezone($match->match_date);
				
				// Retrieve the squad
				$squad = $this->squads->get_squad(array('squad_id' => $match->squad_id));
				
				// Check if squad exists
				if($squad)
				{
					// Squad exists, assign the matches squad
					$match->squad = anchor('roster/squad/' . $squad->squad_slug, $squad->squad_title);
				}
				else
				{
					// Squad doesn't exist, don't assign it
					$match->squad = "";
				}
			}
		}
		
		// Create a reference to matches & pages
		$this->data->matches =& $matches;
		$this->data->pages =& $pages;
		
		// Load the matches view
		$this->load->view(THEME . 'matches', $this->data);
	}

	// --------------------------------------------------------------------
	
	/**
	 * View
	 *
	 * Display's a match
	 *
	 * @access	public
	 * @return	void
	 */
	function view()
	{
		// Retrieve the match
		if(!$match = $this->matches->get_match(array('match_slug' => $this->uri->segment(3, ''))))
		{
			// Match doesn't exist, redirect the user
			redirect('matches');
		}
		
		// Retrieve the opponent
		$opponent = $this->matches->get_opponent(array('opponent_id' => $match->opponent_id));
				
		// Check if opponent exists
		if($opponent)
		{
			// Opponent exists, assign opponent & opponent slug
			$match->opponent = $opponent->opponent_title;
			$match->opponent_slug = $opponent->opponent_slug;
		}
		else
		{
			// Opponent doesn't exist, don't assign it
			$match->opponent = "";
			$match->opponent_slug = "";
		}
				
		// Configure match date
		$match->date = $this->ClanCMS->timezone($match->match_date);
		
		// Retrieve our forms
		$add_comment = $this->input->post('add_comment');
		
		// Check it add comment has been posted and check if the user is logged in
		if($add_comment && $this->user->logged_in())
		{
			// Set form validation rules
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required');
			
			// Form validation passed & checked if article allows comments, so continue
			if (!$this->form_validation->run() == FALSE && (bool) $match->match_comments)
			{	
				// Set up our data
				$data = array (
					'match_id'			=> $match->match_id,
					'user_id'			=> $this->session->userdata('user_id'),
					'comment_title'		=> $this->input->post('comment'),
					'comment_date'		=> mdate('%Y-%m-%d %H:%i:%s', now())
				);
			
				// Insert the comment into the database
				$this->matches->insert_comment($data);
				
				// Alert the user
				$this->session->set_flashdata('message', 'Your comment has been posted!');
				
				// Redirect the user
				redirect('matches/view/' . $match->match_slug);
			}
		}
		
		// Retrieve the current page
		$page = $this->uri->segment(5, '');
	
		// Check if page exists
		if($page == '')
		{
			// Page doesn't exist, assign it
			$page = 1;
		}
	
		//Set up the variables
		$per_page = 10;
		$total_results = $this->matches->count_comments(array('match_id' => $match->match_id));
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
		
		// Retrieve the squad
		$squad = $this->squads->get_squad(array('squad_id' => $match->squad_id));
	
		// Check if squad exists
		if($squad)
		{
			// Squad exosts, assign match squad & match squad slug
			$match->squad = $squad->squad_title;
			$match->squad_slug = $squad->squad_slug;
		}
		else
		{
			// Squad doesn't exist, assign match squad & match squad slug
			$match->squad = '';
			$match->squad_slug = '';
		}
		
		// Format the text, create links, and assign match report
		$match->report = auto_link($this->typography->auto_typography($this->bbcode->to_html($match->match_report)), 'url');
		
		// Retrieve the players
		$players = $this->matches->get_players(array('match_id' => $match->match_id));
		
		// Check if players exist
		if($players)
		{
			// Players exist, loop through each player
			foreach($players as $player)
			{	
				// Retrieve the member
				$member = $this->squads->get_member(array('member_id' => $player->member_id));
				
				// Assign member title
				$player->member_title = $member->member_title;
				
				// Retrieve the user
				$user = $this->users->get_user(array('user_id' => $member->user_id));
				
				// Check if user exists
				if($user)
				{
					// User exists, assign it to player user name
					$player->user_name = $user->user_name;
				}
				else
				{
					// User doesn't exist, assign it to player user name
					$player->user_name = "";
				}
					
				// Retrieve the user's online status
				$player->online = $this->user->is_online($user->user_id);
				
				// Retrieve the number of player kills
				$player->kills = $this->squads->count_kills(array('match_id' => $match->match_id, 'member_id' => $member->member_id));
						
				// Retrieve the number of player deaths
				$player->deaths = $this->squads->count_deaths(array('match_id' => $match->match_id, 'member_id' => $member->member_id));
					
				// Check if player deaths equals 0
				if($player->deaths == 0)
				{
					// Player deaths equals 0, format kills & deaths, assign player kd
					$player->kd = number_format(($player->kills / 1), 2, '.', '');
				}
				else
				{
					// Player deaths doesn't equal 0, format kills & deaths, assign player kd
					$player->kd = number_format(($player->kills / $player->deaths), 2, '.', '');
				}
			}
		}
		
		// Check if match allows comments
		if((bool) $match->match_comments)
		{
			// Match allows comments, retrieve the articles comments
			$comments = $this->matches->get_comments($per_page, $offset, array('match_id' => $match->match_id));
				
			// Check if comments exist
			if($comments)
			{
				// Comments exist, loop through each comment
				foreach($comments as $comment)
				{
					// Retrieve the user
					if($user = $this->users->get_user(array('user_id' => $comment->user_id)))
					{
						// User exists, assign comment author & comment avatar
						$comment->author = $user->user_name;
						$comment->avatar = $user->user_avatar;
					}
					else
					{
						// User doesn't exist, assign comment author & comment avatar
						$comment->author = '';
						$comment->avatar = '';
					}
					
					// Format and assign the comment date
					$comment->date = $this->ClanCMS->timezone($comment->comment_date);
				}
			}
		}
		
		// Create a reference to match, players, comments & pages
		$this->data->match =& $match;
		$this->data->players =& $players;
		$this->data->comments =& $comments;
		$this->data->pages =& $pages;
		
		// Load the match view
		$this->load->view(THEME . 'match', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete Comment
	 *
	 * Delete's a match comment from the databse
	 *
	 * @access	public
	 * @return	void
	 */
	function delete_comment()
	{
		// Set up our data
		$data = array(
			'comment_id'	=>	$this->uri->segment(3)
		);
		
		// Retrieve the match comment
		if(!$comment = $this->matches->get_comment($data))
		{
			// Comment doesn't exist, alert the administrator
			$this->session->set_flashdata('message', 'The comment was not found!');
		
			// Redirect the user
			redirect($this->session->userdata('previous'));
		}
		
		// Check if the user is an administrator
		if(!$this->user->is_administrator() && $this->session->userdata('user_id') != $comment->user_id)
		{
			// User isn't an administrator or the comment user, alert the user
			$this->session->set_flashdata('message', 'You are not allowed to delete this comment!');
			
			// Redirect the user
			redirect($this->session->userdata('previous'));
		}
				
		// Delete the match comment from the database
		$this->matches->delete_comment($comment->comment_id, $data);
		
		// Alert the administrator
		$this->session->set_flashdata('message', 'The comment was successfully deleted!');
				
		// Redirect the administrator
		redirect($this->session->userdata('previous'));
	}
	
}

/* End of file matches.php */
/* Location: ./clancms/controllers/matches.php */
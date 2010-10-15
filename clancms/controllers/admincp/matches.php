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
 * Clan CMS Admin CP Matches Controller
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
	
		// Check to see if user is an administrator
		if(!$this->user->is_administrator())
		{
			// User is not an admin, redirect them
			redirect('account/login');
		}
		
		// Check if the administrator has permission
		if(!$this->user->has_permission('matches'))
		{
			// Administrator doesn't have permission, show error & exit
			$error =& load_class('Exceptions');
			echo $error->show_error('Access Denied!', 'You do not have permission to view this page!');
			exit;
		}
		
		// Load the Matches model
		$this->load->model('Matches_model', 'matches');
		
		// Load the Squads model
		$this->load->model('Squads_model', 'squads');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's Admin CP matches
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Retrieve the page
		$page = $this->uri->segment(4, '');
	
		// Check if page exists
		if($page == '')
		{
			// Page doesn't exist, assign page
			$page = 1;
		}
	
		//Set up the variables
		$per_page = 10;
		$total_results = $this->matches->count_matches();
		$offset = ($page - 1) * $per_page;
		$pages = '';
		
		// Create the pages
		for($i = 1; $i < ($total_results / $per_page) + 1; $i++)
		{
			// Check current page
			if($page == $i)
			{
				// Create current page link
				$pages.= '[' . $i . '] ';
			}
			else
			{
				// Create other pages links
				$pages.= anchor(ADMINCP . 'matches/page/' . $i, $i) . ' ';
			}
		}
		
		// Retrieve the matches
		$matches = $this->matches->get_matches($per_page, $offset);
		
		// Check if matches exist
		if($matches)
		{
			// Matches exist, loop through each match
			foreach($matches as $match)
			{
				// Format each matches date
				$match->date = $this->ClanCMS->timezone($match->match_date);
				
				// Retrieve the squad
				$squad = $this->squads->get_squad(array('squad_id' => $match->squad_id));
				
				// Check if squad exists
				if($squad)
				{
					// Squad exists, assign match squad
					$match->squad = $squad->squad_title;
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
		$this->load->view(ADMINCP . 'matches', $this->data);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Add
	 *
	 * Displays a form to add matches
	 *
	 * @access	public
	 * @return	void
	 */
	function add()
	{
		// Retrieve our forms
		$add_match = $this->input->post('add_match');
		
		// Check if add match has been posted
		if($add_match)
		{
			// Set form validation rules
			$this->form_validation->set_rules('squad', 'Squad', 'trim|required');
			$this->form_validation->set_rules('opponent', 'Opponent', 'trim|required');
			$this->form_validation->set_rules('opponent_link', 'Opponent Link', 'trim|prep_url');
			$this->form_validation->set_rules('type', 'Type', 'trim');
			$this->form_validation->set_rules('players', 'Players', 'trim');
			$this->form_validation->set_rules('score', 'Score', 'trim|required');
			$this->form_validation->set_rules('opponent_score', 'Opponent Score', 'trim|required');
			$this->form_validation->set_rules('date', 'Date', 'trim|required');
			$this->form_validation->set_rules('hour', 'Hour', 'trim|required');
			$this->form_validation->set_rules('minutes', 'Minutes', 'trim|required');
			$this->form_validation->set_rules('ampm', 'ampm', 'trim|required');
			$this->form_validation->set_rules('report', 'Report', 'trim');
			$this->form_validation->set_rules('comments', 'Comments', 'trim|required');
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{
				// Assign match date
				$match_date = mdate('%Y-%m-%d %H:%i:%s' , local_to_gmt(human_to_unix($this->input->post('date') . ' ' . $this->input->post('hour') . ':' . $this->input->post('minutes') . ':00 ' . $this->input->post('ampm'))));
	
				// Set up our data
				$data = array (
					'squad_id'				=> $this->input->post('squad'),
					'match_opponent'		=> $this->input->post('opponent'),
					'match_opponent_link'	=> $this->input->post('opponent_link'),
					'match_type'			=> $this->input->post('type'),
					'match_players'			=> $this->input->post('players'),
					'match_score'			=> $this->input->post('score'),
					'match_opponent_score'	=> $this->input->post('opponent_score'),
					'match_report'			=> $this->input->post('report'),
					'match_date'			=> $match_date,
					'match_comments'		=> $this->input->post('comments')
				);
			
				// Insert the match into the database
				$this->matches->insert_match($data);
				
				// Retrieve the squad
				$squad = $this->squads->get_squad(array('squad_id' => $this->input->post('squad')));
				
				// Retrieve the match id
				$match_id = $this->db->insert_id();
				
				// Set up our data
				$data = array (
					'match_slug'		=> $match_id . '-' . url_title($squad->squad_title) . '-vs-' . url_title($this->input->post('opponent'))
				);
				
				// Update the match into the database
				$this->matches->update_match($match_id, $data);
				
				// Alert the adminstrator
				$this->session->set_flashdata('message', 'The match was successfully added!');
				
				// Redirect the adminstrator
				redirect(ADMINCP . 'matches/edit/' . $match_id);
			}
		}
		
		// Retrieve the squads
		$squads = $this->squads->get_squads();
		
		// Check if squads exist
		if($squads)
		{
			// Squads exist, loop through each squad
			foreach($squads as $squad)
			{
				// Retrieve the squad's members
				$squad->members = $this->squads->get_members(array('squad_id' => $squad->squad_id));
		
				// Check if members exist
				if($squad->members)
				{
					// Members exist, loop through each member
					foreach($squad->members as $member)
					{
						// Retrieve the user
						$user = $this->users->get_user(array('user_id' => $member->user_id));
				
						// Check if user exists
						if($user) 
						{
							// User exists, assign the member's user name
							$member->user_name = $user->user_name;
						}
					}
				}
			}
		}
		
		// Create a reference to squads
		$this->data->squads =& $squads;
		
		// Load the squads add view
		$this->load->view(ADMINCP . 'matches_add', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Edit
	 *
	 * Display's a form to edit matches
	 *
	 * @access	public
	 * @return	void
	 */
	function edit()
	{
		// Set up our data
		$data = array(
			'match_id'	=>	$this->uri->segment(4)
		);
		
		// Get the match
		if(!$match = $this->matches->get_match($data))
		{
			redirect(ADMINCP . 'matches');
		}
		
		// Assign match date
		$match->date = $this->ClanCMS->timezone($match->match_date);
		
		// Retrieve the current page
		$page = $this->uri->segment(6, '');
	
		// Check if page exists
		if($page == '')
		{
			// Page doesn't exist, assign it
			$page = 1;
		}
	
		//Set up the variables
		$per_page = 10;
		$total_results = $this->matches->count_comments(array('match_id' => $match->match_id ));
		$offset = ($page - 1) * $per_page;
		$pages = '';
		
		// Create the pages
		for($i = 1; $i < ($total_results / $per_page) + 1; $i++)
		{
			// Check current page
			if($page == $i)
			{
				// Create current page link
				$pages.= '[' . $i . '] ';
			}
			else
			{
				// Create other pages links
				$pages.= anchor(ADMINCP . 'matches/edit/' . $match->match_id . '/page/' . $i, $i) . ' ';
			}
		}
		
		// Retrieve our forms
		$update_match = $this->input->post('update_match');
		$kills = $this->input->post('kills');
		$deaths = $this->input->post('deaths');
		
		// Check it update match has been posted
		if($update_match)
		{
			// Set form validation rules
			$this->form_validation->set_rules('opponent', 'Opponent', 'trim|required');
			$this->form_validation->set_rules('opponent_link', 'Opponent Link', 'trim|prep_url');
			$this->form_validation->set_rules('type', 'Type', 'trim');
			$this->form_validation->set_rules('players', 'Players', 'trim');
			$this->form_validation->set_rules('score', 'Score', 'trim|required');
			$this->form_validation->set_rules('opponent_score', 'Opponent Score', 'trim|required');
			$this->form_validation->set_rules('date', 'Date', 'trim|required');
			$this->form_validation->set_rules('hour', 'Hour', 'trim|required');
			$this->form_validation->set_rules('minutes', 'Minutes', 'trim|required');
			$this->form_validation->set_rules('ampm', 'ampm', 'trim|required');
			$this->form_validation->set_rules('report', 'Report', 'trim');
			$this->form_validation->set_rules('comments', 'Comments', 'trim|required');
			
			// Check if kills exist
			if($kills)
			{
				// Kills exist, loop through each player
				foreach($kills as $player_id => $value)
				{
					// Set form validation rules for each member
					$this->form_validation->set_rules('kills[' . $player_id . ']', 'Kills', 'trim');
					$this->form_validation->set_rules('deaths[' . $player_id . ']', 'Deaths', 'trim');
				}
			}
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{
				// Assign match date
				$match_date = mdate('%Y-%m-%d %H:%i:%s' , local_to_gmt(human_to_unix($this->input->post('date') . ' ' . $this->input->post('hour') . ':' . $this->input->post('minutes') . ':00 ' . $this->input->post('ampm'))));
	
				// Set up our data
				$data = array (
					'match_opponent'		=> $this->input->post('opponent'),
					'match_opponent_link'	=> $this->input->post('opponent_link'),
					'match_type'			=> $this->input->post('type'),
					'match_players'			=> $this->input->post('players'),
					'match_score'			=> $this->input->post('score'),
					'match_opponent_score'	=> $this->input->post('opponent_score'),
					'match_report'			=> $this->input->post('report'),
					'match_date'			=> $match_date,
					'match_comments'		=> $this->input->post('comments')
				);
		
				// Update the match into the database
				$this->matches->update_match($match->match_id, $data);
				
				// Check if kills exist
				if($kills)
				{
					// Kills exist, loop through each player
					foreach($kills as $player_id => $value)
					{
						// Set up the data
						$data = array (
							'player_kills'	=> $kills[$player_id],
							'player_deaths'	=> $deaths[$player_id]
						);
			
						// Update the match player in the database
						$this->matches->update_player($player_id, $data);
					}
				}
				
				// Alert the user
				$this->session->set_flashdata('message', 'The match was successfully updated!');
				
				// Redirect the user
				redirect(ADMINCP . 'matches/edit/' . $match->match_id);
			}
		}
		
		// Retrieve the squads
		if($squad = $this->squads->get_squad(array('squad_id' => $match->squad_id)))
		{
			// Squad exists, assign match squad
			$match->squad = $squad->squad_title;
		}
		else
		{
			// Squad doesn't exist, assign match squad
			$match->squad = '';
		}
		
		// Retrieve the players
		$players = $this->matches->get_players(array('match_id' => $match->match_id));
		
		// Check if players exist
		if($players)
		{
			// Players exist, loop through each player
			foreach($players as $player)
			{
				// Retrive the member
				$member = $this->squads->get_member(array('member_id' => $player->member_id));
				
				// Assign member title
				$player->member_title = $member->member_title;
				
				// Retrieve the user
				$user = $this->users->get_user(array('user_id' => $member->user_id));
				
				// Check if user exists
				if($user)
				{
					// User exists, assign user id & user name
					$player->user_id = $user->user_id;
					$player->user_name = $user->user_name;
				}
				else
				{
					// User doesn't exist, assign user id & user name
					$player->user_id = '';
					$player->user_name = '';
				}
				
				// Check if player deaths equals 0
				if($player->player_deaths == 0)
				{
					// Player deaths equals 0, format kills & deaths, assign player kd
					$player->kd = number_format(($player->player_kills / 1), 2, '.', '');
				}
				else
				{
					// Player deaths doesn't equal 0, format kills & deaths, assign player kd
					$player->kd = number_format(($player->player_kills / $player->player_deaths), 2, '.', '');
				}
			}
		}
		
		// Retrieve the members
		$members = $this->squads->get_members(array('squad_id' => $squad->squad_id));
		
		// Check if members exist
		if($members)
		{
			// Assign available members
			$available_members = array();
			
			// Members exist, loop through each member
			foreach($members as $member)
			{
				// Retrieve the user
				$user = $this->users->get_user(array('user_id' => $member->user_id));
				
				// Check if user exists
				if($user)
				{
					// User exists, assign member user name
					$member->user_name = $user->user_name;
				}
				else
				{
					// User doesn't exist, assign member user name
					$member->user_name = '';
				}
				
				// Check if player exists
				if(!$player = $this->matches->get_player(array('match_id' => $match->match_id, 'member_id' => $member->member_id)))
				{
					// Player doesn't exist, merge the member with the available members
					$available_members = array_merge(array($member), $available_members);
				}
			}
		}
		
		// Check if match allows comments
		if((bool) $match->match_comments)
		{
			// Match allows comments, retrieve the comments
			$comments = $this->matches->get_comments($per_page, $offset, array('match_id' => $match->match_id));
				
			// Check if comments exist
			if($comments)
			{
				// Comments exist, loop through each comment
				foreach($comments as $comment)
				{
					$comment->author = $this->users->get_user(array('user_id' => $comment->user_id))->user_name;
					$comment->date = $this->ClanCMS->timezone($comment->comment_date);
				}
			}
		}
		
		// Create a reference to match, players, members, comments & pages
		$this->data->match =& $match;
		$this->data->players =& $players;
		$this->data->members =& $available_members;
		$this->data->comments =& $comments;
		$this->data->pages =& $pages;
		
		// Load the admincp matches edit view
		$this->load->view(ADMINCP . 'matches_edit', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete
	 *
	 * Deletes a match
	 *
	 * @access	public
	 * @return	void
	 */
	function delete()
	{
		// Set up the data
		$data = array(
			'match_id'	=>	$this->uri->segment(4)
		);
		
		// Retrieve the match
		if(!$match = $this->matches->get_match($data))
		{
			// Match doesn't exist, redirect the administrator
			redirect(ADMINCP . 'matches');
		}
		
		// Retrieve all of this match's players
		$players = $this->matches->get_players(array('match_id' => $match->match_id));
		
		// Check if players exist
		if($players)
		{
			// Players exist, loop through each player
			foreach($players as $player)
			{
				// Delete each player from the database
				$this->matches->delete_player($player->player_id);
			}
		}
		
		// Retrieve the comments
		$comments = $this->matches->get_comments('', '', array('match_id' => $match->match_id));
				
		// Check if comments exist
		if($comments)
		{
			// Comments exist, loop through each comment
			foreach($comments as $comment)
			{
				// Delete the comment from the database
				$this->matches->delete_comment($comment->comment_id);
			}
		}
		
		// Delete the match from the database
		$this->matches->delete_match($match->match_id);
		
		// Alert the adminstrator
		$this->session->set_flashdata('message', 'The match was successfully deleted!');
				
		// Redirect the adminstrator
		redirect(ADMINCP . 'matches');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Add Player
	 *
	 * Adds a player to a match
	 *
	 * @access	public
	 * @return	void
	 */
	function add_player()
	{	
		// Retrieve the forms
		$match_id = $this->input->post('match_id');
		$member_id = $this->input->post('member_id');
		$kills = $this->input->post('member_kills');
		$deaths = $this->input->post('member_deaths');
		
		// Retrieve the match
		if(!$match = $this->matches->get_match(array('match_id' => $match_id)))
		{
			// Match doesn't exist, redirect the administrator
			redirect(ADMINCP . 'matches');
		}
		
		// Retrieve the member
		if(!$member = $this->squads->get_member(array('member_id' => $member_id)))
		{
			// Member doesn't exist, redirect the administrator
			redirect(ADMINCP . 'matches/edit/' . $match->match_id);
		}
		
		// Set up the data
		$data = array (
			'match_id'		=> $match->match_id,
			'member_id'		=> $member->member_id,
			'player_kills'	=> $kills[$member_id],
			'player_deaths'	=> $deaths[$member_id]
		);
			
		// Insert the match player into the database
		$this->matches->insert_player($data);
		
		// Alert the adminstrator
		$this->session->set_flashdata('message', 'The player was successfully added!');
		
		// Redirect the adminstrator
		redirect(ADMINCP . 'matches/edit/' . $match->match_id);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete Player
	 *
	 * Deletes a player from a match
	 *
	 * @access	public
	 * @return	void
	 */
	function delete_player()
	{	
		// Retrieve the player id
		$player_id = $this->uri->segment(4, '');
		
		// Retrieve the player
		if(!$player = $this->matches->get_player(array('player_id' => $player_id)))
		{
			// Player doesn't exist, redirect the administrator
			redirect(ADMINCP . 'matches');
		}
		
		// Delete the match player from the database
		$this->matches->delete_player($player_id);
		
		// Alert the adminstrator
		$this->session->set_flashdata('message', 'The player was successfully deleted!');
		
		// Redirect the adminstrator
		redirect(ADMINCP . 'matches/edit/' . $player->match_id);
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
		// Set up the data
		$data = array(
			'comment_id'	=>	$this->uri->segment(4, '')
		);
		
		// Retrieve the article comment
		if(!$comment = $this->matches->get_comment($data))
		{
			// Comment doesn't exist, alert the administrator
			$this->session->set_flashdata('message', 'The comment was not found!');
		
			// Redirect the administrator
			redirect($this->session->userdata('previous'));
		}
				
		// Delete the match comment from the database
		$this->matches->delete_comment($comment->comment_id, $data);
		
		// Alert the administrator
		$this->session->set_flashdata('message', 'The comment was successfully deleted!');
				
		// Redirect the administrator
		redirect(ADMINCP . 'matches/edit/' . $comment->match_id . '#comments');
	}
	
	
}

/* End of filematchesphp */
/* Location: ./clancms/controllers/admincp/matches.php */
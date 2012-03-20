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
 * @since		Version 0.5.0
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Admin CP Squads Controller
 *
 * @package		Clan CMS
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Squads extends CI_Controller {
	
	/**
	 * Constructor
	 *
	 */	
	function __construct()
	{
		// Call the Controller constructor
		parent::__construct();
		
		// Check to see if user is an administrator
		if(!$this->user->is_administrator())
		{
			// User is not an administrator, redirect them
			redirect('account/login');
		}
		
		// Check if the administrator has permission
		if(!$this->user->has_permission('squads'))
		{
			// Administrator doesn't have permission, show error, and exit
			$error =& load_class('Exceptions', 'core');
			echo $error->show_error('Access Denied!', 'You do not have permission to view this page!');
			exit;
		}
		
		// Load the Squads model
		$this->load->model('Squads_model', 'squads');
		
		// Load the Articles model
		$this->load->model('Articles_model', 'articles');
		
		// Load the Matches model
		$this->load->model('Matches_model', 'matches');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the Admin CP Squads
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Retrieve all squads
		$squads = $this->squads->get_squads();
		
		// Check if squads exist
		if($squads)
		{
			// Squads exist, loop through each squad
			foreach($squads as $squad)
			{
				// Retrieve the total number of articles for this squad
				$squad->article_total = $this->articles->count_articles(array('squad_id' => $squad->squad_id));
				
				// Retrieve the total number of matches for this squad
				$squad->match_total = $this->matches->count_matches(array('squad_id' => $squad->squad_id));
				
				// Retrieve the total number of members in this squad
				$squad->member_total = $this->squads->count_members(array('squad_id' => $squad->squad_id));
			}
		}
		
		// Create a reference to squads & squad
		$this->data->squads =& $squads;
		$this->data->squad =& $squad;
		
		// Load the admincp squads view
		$this->load->view(ADMINCP . 'squads', $this->data);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Add
	 *
	 * Display's a form to add squads
	 *
	 * @access	public
	 * @return	void
	 */
	function add()
	{
				
		// Retrieve our forms
		$add_squad = $this->input->post('add_squad');
		
		// Check it add squad has been posted
		if($add_squad)
		{ 
			// Set form validation rules
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('icon', 'Icon');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('priority', 'Priority', 'trim|required|integer');
		
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{ 
				// Set up our data
				$data = array (
					'squad_title'			=> $this->input->post('title'),
					'squad_icon'				=> $this->input->post('icon'),
					'squad_status'			=> $this->input->post('status'),
					'squad_priority'		=> $this->input->post('priority')
				);
			
				// Insert the squad into the database
				$this->squads->insert_squad($data);
				
				// Retrieve the suqad id
				$squad_id = $this->db->insert_id();
				
				// Set up our data
				$data = array (
					'squad_slug'		=> $squad_id. '-' . url_title($this->input->post('title'))
				);
				
				// Update the squad in the database
				$this->squads->update_squad($squad_id, $data);
				
				// Alert the adminstrator
				$this->session->set_flashdata('message', 'The squad was successfully added!');
				
				// Redirect the adminstrator
				redirect(ADMINCP . 'squads/edit/' . $squad_id);
			}
			
			
		}
		// Load the games method
		$icons = $this->squads->get_icons();
		 // Reference games
		 $this->data->icons =& $icons;
		
		
		
		// Load the admincp squads add view
		$this->load->view(ADMINCP . 'squads_add', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Edit
	 *
	 * Display's a form to edit squads
	 *
	 * @access	public
	 * @return	void
	 */
	function edit()
	{
		// Set up our data
		$data = array(
			'squad_id'	=>	$this->uri->segment(4)
		);
	
		// Retrieve the squad
		if(!$squad = $this->squads->get_squad($data))
		{
			// Squad doesn't exist, redirect the administrator
			redirect(ADMINCP . 'squads');
		}
		
		// Retrieve our forms
		$update_squad = $this->input->post('update_squad');
		$titles = $this->input->post('titles');
		$roles = $this->input->post('roles');
		
		// Check it update squad has been posted
		if($update_squad)
		{
			// Set form validation rules
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('priority', 'Priority', 'trim|required|integer');
			$this->form_validation->set_rules('icon', 'Icon');
			
			// Loop through each member
			foreach($titles as $member_id => $title)
			{
				// Set form validation rules for each member
				$this->form_validation->set_rules('titles[' . $member_id . ']', 'Titles', 'trim');
				$this->form_validation->set_rules('roles[' . $member_id . ']', 'Roles', 'trim');
			}
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{
				// Set up our data
				$data = array (
					'squad_title'			=> $this->input->post('title'),
					'squad_slug'			=> $squad->squad_id . '-' . url_title($this->input->post('title')),
					'squad_icon'				=> $this->input->post('icon'),
					'squad_status'			=> $this->input->post('status'),
					'squad_priority'		=> $this->input->post('priority')
				);
			
				// Update the squad into the database
				$this->squads->update_squad($squad->squad_id, $data);
				
				// Loop through each member
				foreach($titles as $member_id => $member_title)
				{
					// Set up the data
					$data = array(
						'member_title'		=> $titles[$member_id],
						'member_role'		=> $roles[$member_id]
					);
					
					// Update the squad member in the database
					$this->squads->update_member($member_id, $data);				
				}
				
				// Alert the adminstrator
				$this->session->set_flashdata('message', 'The squad was successfully updated!');
				
				// Redirect the adminstrator
				redirect(ADMINCP . 'squads/edit/' . $squad->squad_id);
			}
		}
		
		// Retrieve the members
		$members = $this->squads->get_members(array('squad_id' => $squad->squad_id));
		
		// Check if members exist
		if($members)
		{
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
			}
		}
		
		// Retrieve the usergroups
		$usergroups = $this->users->get_groups(array('group_clan' => 1));
		
		// Check if usergroups exist
		if($usergroups)
		{
			// Assign available users
			$available_users = array();
			
			// Usergroups exist, loop through each usergroup
			foreach($usergroups as $usergroup)
			{
				// Retrieve the users
				$users = $this->users->get_users('', '', array('group_id' => $usergroup->group_id));
				
				// Check if users exist
				if($users)
				{
					// Users exist, loop through each user
					foreach($users as $user)
					{
						// Check if member exists
						if(!$member = $this->squads->get_member(array('squad_id' => $squad->squad_id, 'user_id' => $user->user_id)))
						{
							// Member doesn't exist, merge the users with the available users
							$available_users = array_merge(array($user), $available_users);
						}
					}
				}
			}
		}
		// Display all icons
		$icons = $this->squads->get_icons();
		// Create a reference to squad, members & users
		$this->data->squad =& $squad;
		$this->data->members =& $members;
		$this->data->users =& $available_users;
		$this->data->icons =& $icons;
		
		// Load the admincp squads edit view
		$this->load->view(ADMINCP . 'squads_edit', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete
	 *
	 * Deletes a squad
	 *
	 * @access	public
	 * @return	void
	 */
	function delete()
	{
		// Set up our data
		$data = array(
			'squad_id'	=>	$this->uri->segment(4)
		);
		
		// Retrieve the squad
		if(!$squad = $this->squads->get_squad($data))
		{
			// Squad doesn't exist, redirect the administrator
			redirect(ADMINCP . 'squads');
		}
		
		// Retrieve all of this squad's members
		$members = $this->squads->get_members(array('squad_id' => $squad->squad_id));
		
		// Check if members exist
		if($members)
		{
			// Members exist, loop through the squad members
			foreach($members as $member)
			{
				// Delete each member from the database
				$this->squads->delete_member($member->member_id);
			}
		}
		
		// Retrieve all of the squad's matches
		$matches = $this->matches->get_matches('', '', array('squad_id' => $squad->squad_id));
		
		// Check if matches exist
		if($matches)
		{
			// Matches exist, loop through the squad matches
			foreach($matches as $match)
			{
				// Retrieve the match players
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
				
				// Delete each match from the database
				$this->matches->delete_match($match->match_id);
			}
		}
		
		// Retrieve all of the squad's articles
		$articles = $this->articles->get_articles('', '', array('squad_id' => $squad->squad_id));
		
		// Check if articles exist
		if($articles)
		{
			// Articles exist, loop through the squad articles
			foreach($articles as $article)
			{
				// Retrieve the comments
				$comments = $this->articles->get_comments('', '', array('article_id' => $article->article_id));
				
				// Check if comments exist
				if($comments)
				{
					// Comments exist, loop through each comment
					foreach($comments as $comment)
					{
						// Delete the comment from the database
						$this->articles->delete_comment($comment->comment_id);
					}
				}
				
				// Delete each article from the database
				$this->articles->delete_article($article->article_id);
			}
		}
		
		// Delete the squad from the database
		$this->squads->delete_squad($squad->squad_id);
		
		// Alert the adminstrator
		$this->session->set_flashdata('message', 'The squad was successfully deleted!');
				
		// Redirect the adminstrator
		redirect(ADMINCP . 'squads');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Order
	 *
	 * Updates the order of the squads
	 *
	 * @access	public
	 * @return	void
	 */
	function order()
	{	
		// Retrieve the squads
		$squads = $this->input->post('squad');

		// Loop through each squad
		foreach($squads as $squad_priority => $squad_id)
		{
			// Set up our data
			$data = array(
				'squad_priority' =>	$squad_priority 
			);
	
			// Update the squad's order in the database
			$this->squads->update_squad($squad_id, $data);
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Add Member
	 *
	 * Adds a member to a squad
	 *
	 * @access	public
	 * @return	void
	 */
	function add_member()
	{	
		// Retrieve the forms
		$squad_id = $this->input->post('squad_id');
		$user_id = $this->input->post('user_id');
		$titles = $this->input->post('titles');
		$roles = $this->input->post('roles');
		
		// Retrieve the squad
		if(!$squad = $this->squads->get_squad(array('squad_id' => $squad_id)))
		{
			// Squad doesn't exist, redirect the administrator
			redirect(ADMINCP . 'squads');
		}
		
		// Retrieve the user
		if(!$user = $this->users->get_user(array('user_id' => $user_id)))
		{
			// User doesn't exist, redirect the administrator
			redirect(ADMINCP . 'squads/edit/' . $squad->squad_id);
		}
		
		// Retrieve the member
		if($member = $this->squads->get_member(array('user_id' => $user_id, 'squad_id' => $squad_id)))
		{
			// Member already exists, redirect the administrator
			redirect(ADMINCP . 'squads/edit/' . $squad->squad_id);
		}
		
		// Set up our data
		$data = array (
			'squad_id'		=> $squad->squad_id,
			'user_id'		=> $user->user_id,
			'member_title'	=> $titles[$user->user_id],
			'member_role'	=> $roles[$user->user_id]
		);
			
		// Insert the squad member into the database
		$this->squads->insert_member($data);
		
		// Retrieve the member id
		$member_id = $this->db->insert_id();
				
		// Set up our data
		$data = array (
			'member_priority'	=> $member_id
		);
				
		// Update the squad member in the database
		$this->squads->update_member($member_id, $data);
				
		// Alert the adminstrator
		$this->session->set_flashdata('message', 'The member was successfully added!');
		
		// Redirect the adminstrator
		redirect(ADMINCP . 'squads/edit/' . $squad->squad_id);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete Member
	 *
	 * Deletes a member from a squad
	 *
	 * @access	public
	 * @return	void
	 */
	function delete_member()
	{	
		// Retrieve the member id
		$member_id = $this->uri->segment(4, '');
		
		// Retrieve the member
		if(!$member = $this->squads->get_member(array('member_id' => $member_id)))
		{
			// Member doesn't exist, redirect the administrator
			redirect(ADMINCP . 'squads');
		}
		
		// Retrieve the squad
		if(!$squad = $this->squads->get_squad(array('squad_id' => $member->squad_id)))
		{
			// Squad doesn't exist, redirect the administrator
			redirect(ADMINCP . 'squads');
		}
		
		// Retrieve the matches
		$matches = $this->matches->get_matches('', '', array('squad_id' => $squad->squad_id));
		
		// Check if matches exist
		if($matches)
		{
			// Matches exist, loop through each match
			foreach($matches as $match)
			{
				// Retrieve the players
				if($player = $this->matches->get_player(array('match_id' => $match->match_id, 'member_id' => $member->member_id)))
				{
					// Player exists, delete the player from the database
					$this->matches->delete_player($player->player_id);
				}
			}
		}
		
		// Delete the squad member in the database
		$this->squads->delete_member($member_id);
		
		// Alert the adminstrator
		$this->session->set_flashdata('message', 'The member was successfully deleted!');
		
		// Redirect the adminstrator
		redirect(ADMINCP . 'squads/edit/' . $squad->squad_id);
		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Order Members
	 *
	 * Updates the order of the squad members
	 *
	 * @access	public
	 * @return	void
	 */
	function order_members()
	{	
		// Retrieve the squad id
		$squad_id = $this->uri->segment(4, '');
		
		// Retrieve the squad
		if(!$squad = $this->squads->get_squad(array('squad_id' => $squad_id)))
		{
			// Squad doesn't exist, redirect the administrator
			redirect(ADMINCP . 'squads');
		}
		
		// Retrieve the squads
		$members = $this->input->post('member');

		// Loop through each member
		foreach($members as $member_priority => $member_id)
		{
			// Set up our data
			$data = array(
				'member_priority' =>	$member_priority 
			);
	
			// Update the member's order in the database
			$this->squads->update_member($member_id, $data);
		}
	}
	
// --------------------------------------------------------------------
	/** Squad Icons
	 * 
	 *  Adds squad icons
	 *
	 * @access	public
	 * @return	void
	 */
	 function icons() {
		
		// Display all Game headers
		$data['icons'] = $this->squads->get_icons();
		
		//  on submit -> to model
		if ($this->input->post('upload')) {
			$this->squads->add_icon();
			}
		
		
		$this->load->view(ADMINCP . 'squads_icons', $data);
	 }
	// --------------------------------------------------------------------
	/**
	 * Delete Icon
	 *
	 *  Removes uploaded icon
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */	
	function del_icon()
	{
		// Set up the data
		$data = array(
			'id'	=>	$this->uri->segment(4, '')
		);

		// Retrieve the header by file_name
		if(!$icon = $this->squads->get_icon($data))
		{
			// Comment doesn't exist, alert the administrator
			$this->session->set_flashdata('message', 'The icon was not found!');
		
			// Redirect the administrator
			redirect($this->session->userdata('previous'));
		}

		// Delete the article comment from the database
		unlink(UPLOAD . 'squad_icons/' .$icon->image);
		$this->squads->delete_icon($icon->id, $data);
		
		// Alert the administrator
		$this->session->set_flashdata('message', 'The squad\'s icon was successfully deleted!');
				
		// Redirect the administrator
		redirect(ADMINCP . 'squads/icons/');
	
	} 


}

/* End of file squads.php */
/* Location: ./clancms/controllers/admincp/squads.php */
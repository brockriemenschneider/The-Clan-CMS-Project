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
 * Clan CMS Admin CP Sponsors Controller
 *
 * @package		Clan CMS
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Usergroups extends CI_Controller {
	
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
		if(!$this->user->has_permission('usergroups'))
		{
			// Administrator doesn't have permission, show error, and exit
			$error =& load_class('Exceptions', 'core');
			echo $error->show_error('Access Denied!', 'You do not have permission to view this page!');
			exit;
		}
		
		// Load the Squads model
		$this->load->model('Squads_model', 'squads');
		
		// Load the matches model
		$this->load->model('Matches_model', 'matches');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the Admin CP Usergroups
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Retrieve all default user groups
		$default_groups = $this->users->get_groups(array('group_default' => 1));
		
		// Check if default groups exist
		if($default_groups)
		{
			// Default groups exist, loop through each default group
			foreach($default_groups as $default_group)
			{
				// Retrieve the total users in each default group
				$default_group->total_users = $this->users->count_users(array('group_id' => $default_group->group_id));
			}
		}
		
		// Retrieve all custom user groups
		$custom_groups = $this->users->get_groups(array('group_default' => 0));
		
		// Check if custom groups exist
		if($custom_groups)
		{
			// Custom groups exist, loop through each custom group
			foreach($custom_groups as $custom_group)
			{
				// Retrieve the total users in each custom group
				$custom_group->total_users = $this->users->count_users(array('group_id' => $custom_group->group_id));
			}
		}
		
		// Create a reference to default groups & custom groups
		$this->data->default_groups =& $default_groups;
		$this->data->custom_groups =& $custom_groups;
		
		// Load the admincp usergroups view
		$this->load->view(ADMINCP . 'usergroups', $this->data);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Add
	 *
	 * Add's a usergroup to the database
	 *
	 * @access	public
	 * @return	void
	 */
	function add()
	{
		// Retrieve our forms
		$add_group = $this->input->post('add_group');
		
		// Retrieve the permissions
		$permissions = $this->users->get_permissions();
		
		// Check it add group has been posted
		if($add_group)
		{
			// Set form validation rules
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('user_title', 'User Title', 'trim|required');
			$this->form_validation->set_rules('administrator', 'Administrator', 'trim|required');
			$this->form_validation->set_rules('clan', 'Clan Member', 'trim|required');
			$this->form_validation->set_rules('banned', 'Banned', 'trim|required');
			
			// Check if permissions exist
			if($permissions)
			{
				// Permissions exist, loop through each permission
				foreach($permissions as $permission)
				{
					// Set form validation rules for each permission
					$this->form_validation->set_rules('permission[' . $permission->permission_id . ']', $permission->permission_title, 'trim|required');
				}
			}
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{	
				// Retrieve the permissions
				$permissions = $this->input->post('permission');
				
				// Assign permission total
				$permission_total = 0;
				
				// Loop through each permission
				foreach($permissions as $permission_id => $value)
				{
					// Check if the user group has the permission and is an administrator
					if($value && $this->input->post('administrator'))
					{
						// Retrieve the permission
						if($permission = $this->users->get_permission(array('permission_id' => $permission_id)))
						{
							// Add the permission's value to the permission total
							$permission_total += $permission->permission_value;
						}
					}
				}
				
				// Set up our data
				$data = array (
					'group_title'			=> $this->input->post('title'),
					'group_user_title'		=> $this->input->post('user_title'),
					'group_default'			=> 0,
					'group_administrator'	=> $this->input->post('administrator'),
					'group_clan'			=> $this->input->post('clan'),
					'group_banned'			=> $this->input->post('banned'),
					'group_permissions'		=> $permission_total,
				);
			
				// Insert the usergroup into the database
				$this->users->insert_group($data);
				
				// Retrieve the group id
				$group_id = $this->db->insert_id();
				
				// Alert the adminstrator
				$this->session->set_flashdata('message', 'The user group was successfully added!');
				
				// Redirect the adminstrator
				redirect(ADMINCP . 'usergroups/edit/' . $group_id);
			}
		}
	
		// Create a reference to permissions
		$this->data->permissions =& $permissions;
		
		// Load the admincp usergroups add view
		$this->load->view(ADMINCP . 'usergroups_add', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Edit
	 *
	 * Edit's a usergroup in the database
	 *
	 * @access	public
	 * @return	void
	 */
	function edit()
	{
		// Set up the data
		$data = array(
			'group_id'	=>	$this->uri->segment(4)
		);
		
		// Retrieve the user group
		if(!$group = $this->users->get_group($data))
		{
			// Group doesn't exist, redirect the administrator
			redirect(ADMINCP . 'usergroups');
		}
		
		// Retrieve the forms
		$update_group = $this->input->post('update_group');
		
		// Retrieve the permissions
		$permissions = $this->users->get_permissions();
		
		// Check it update group has been posted
		if($update_group)
		{
			// Set form validation rules
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('user_title', 'User Title', 'trim|required');
			
			// Check if the group is default
			if(!$group->group_default)
			{
				// Group isn't a default group, set some extra form validation rules
				$this->form_validation->set_rules('administrator', 'Administrator', 'trim|required');
				$this->form_validation->set_rules('clan', 'Clan Member', 'trim|required');
				$this->form_validation->set_rules('banned', 'Banned', 'trim|required');
			
				// Check if permissions exist
				if($permissions)
				{
					// Permissions exist, loop through each one
					foreach($permissions as $permission)
					{
						// Set form validation rules for each permission
						$this->form_validation->set_rules('permission[' . $permission->permission_id . ']', $permission->permission_title, 'trim|required');
					}
				}
			}
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{	
			
				// Retrieve the permissions
				$permissions = $this->input->post('permission');
		
				// Assign permission total
				$permission_total = 0;
				
				// Loop through each permission
				foreach($permissions as $permission_id => $value)
				{
					// Check if the user group is administrators
					if(($group->group_default && $group->group_administrator) OR $this->input->post('administrator'))
					{
						// User group is administrators, check if the user group has the permission
						if($value)
						{
							// User group has permission, retrieve the permission
							if($permission = $this->users->get_permission(array('permission_id' => $permission_id)))
							{
								// Add the permission's value to the permission total
								$permission_total += $permission->permission_value;
							}
						}
					}
				}
				
				
				// Check if the group is default
				if($group->group_default)
				{
					// Group is a default group, set up our data
					$data = array (
						'group_title'			=> $this->input->post('title'),
						'group_user_title'		=> $this->input->post('user_title')
					);
				}
				else
				{
					// Group isn't a default group, set up our data
					$data = array (
						'group_title'			=> $this->input->post('title'),
						'group_user_title'		=> $this->input->post('user_title'),
						'group_administrator'	=> $this->input->post('administrator'),
						'group_clan'			=> $this->input->post('clan'),
						'group_banned'			=> $this->input->post('banned'),
						'group_permissions'		=> $permission_total,
					);
				}
			
				// Update the user group into the database
				$this->users->update_group($group->group_id, $data);
				
				// Check if clan equals 0
				if($this->input->post('clan') == 0)
				{
					// Clan equals 0, retrieve users
					$users = $this->users->get_users(array('group_id' => $group->group_id));
					
					// Check if users exist
					if($users)
					{
						// Users exist, loop through each user
						foreach($users as $user)
						{
							// Retrieve the squad members
							$members = $this->squads->get_members(array('user_id' => $user->user_id));
							
							// Check if members exist
							if($members)
							{
								// Members exist, loop through each member
								foreach($members as $member)
								{
									// Retrive the match players
									$players = $this->matches->get_players(array('member_id' => $member->member_id));
									
									// Check if players exist
									if($players)
									{
										// Players exist loop throug each player
										foreach($players as $player)
										{
											// Delete each match player
											$this->matches->delete_player($player->player_id);
										}
									}
									
									// Delete each squad member
									$this->squads->delete_member($member->member_id);
								}
							}
						}
					}
				}
				
				// Alert the adminstrator
				$this->session->set_flashdata('message', 'The user group was successfully updated!');
				
				// Redirect the adminstrator
				redirect(ADMINCP . 'usergroups/edit/' . $group->group_id);
			}
		}
		
		// Assign permission total
		$permission_total = $group->group_permissions;
		
		// Check if permissions exist
		if($permissions)
		{
			// Permissions exist, loop through each permission
			foreach($permissions as $permission)
			{
				// Check if the permision has a value less then the permission total
				if($permission->permission_value <= $permission_total)
				{
					// The permission value is less then the permission total, set permision
					$permission->permission[$permission->permission_id] = 1;
					
					// Calculate the new permission total
					$permission_total -= $permission->permission_value;
				}
				else
				{
					// The permission value is greater then the permission total, set permision
					$permission->permission[$permission->permission_id] = 0;
				}
			}
		}
		
		// Create a reference to group & permissions
		$this->data->group =& $group;
		$this->data->permissions =& $permissions;
		
		// Load the admincp usergroups edit view
		$this->load->view(ADMINCP . 'usergroups_edit', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete
	 *
	 * Delete's a user group from the databse
	 *
	 * @access	public
	 * @return	void
	 */
	function delete()
	{
		// Set up our data
		$data = array(
			'group_id'	=>	$this->uri->segment(4)
		);
		
		// Retrieve the user group
		if(!$group = $this->users->get_group($data))
		{
			// Group doesn't exist, redirect the administrator
			redirect(ADMINCP . 'usergroups');
		}
		
		// Check if the user group is a default group
		if($group->group_default)
		{
			// User group is a default group, alert the adminstrator
			$this->session->set_flashdata('message', 'You can not delete default user groups!');
			
			// redirect the administrator
			redirect(ADMINCP . 'usergroups');
		}
		
		// Retrieve users
		$users = $this->users->get_users('', '', array('group_id' => $group->group_id));
		
		// Check if users exist
		if($users)
		{
			// Users exist, loop through each user
			foreach($users as $user)
			{
				// Retrieve the squad members
				$members = $this->squads->get_members(array('user_id' => $user->user_id));
							
				// Check if members exist
				if($members)
				{
					// Members exist, loop through each member
					foreach($members as $member)
					{
						// Retrive the match players
						$players = $this->matches->get_players(array('member_id' => $member->member_id));
									
						// Check if players exist
						if($players)
						{
							// Players exist loop throug each player
							foreach($players as $player)
							{
								// Delete each match player
								$this->matches->delete_player($player->player_id);
							}
						}
									
						// Delete each squad member
						$this->squads->delete_member($member->member_id);
					}
				}
						
				// Update each user to the default user group
				$this->users->update_user($user->user_id, array('group_id' => 1));
			}
		}
				
		// Delete the user group from the database
		$this->users->delete_group($group->group_id, $data);
		
		// Alert the adminstrator
		$this->session->set_flashdata('message', 'The user group was successfully deleted!');
				
		// Redirect the adminstrator
		redirect(ADMINCP . 'usergroups');
	}
	
}

/* End of file usergroups.php */
/* Location: ./clancms/controllers/admincp/usergroups.php */
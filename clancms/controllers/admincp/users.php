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
 * Clan CMS Admin CP Users Controller
 *
 * @package		Clan CMS
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Users extends CI_Controller {
	
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
		if(!$this->user->has_permission('users'))
		{
			// Administrator doesn't have permission, show error & exit
			$error =& load_class('Exceptions', 'core');
			echo $error->show_error('Access Denied!', 'You do not have permission to view this page!');
			exit;
		}
		
		// Load the Articles model
		$this->load->model('Articles_model', 'articles');
		
		// Load the Squads model
		$this->load->model('Squads_model', 'squads');
		
		// Load the Matches model
		$this->load->model('Matches_model', 'matches');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the Admin CP users
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
			// Page doesn't exist, assign it
			$page = 1;
		}
	
		//Set up the variables
		$per_page = 10;
		$total_results = $this->users->count_users();
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
		
		// Retrieve all users
		$users = $this->users->get_users($per_page, $offset);
		
		// Check to see if users exist
		if($users)
		{
			// Users exist, loop through each user
			foreach($users as $user)
			{
				// Retrieve the group
				if($group = $this->users->get_group(array('group_id' => $user->group_id)))
				{
					// Group exists, assign user group
					$user->group = $group->group_title;
				}
				else
				{
					// Group doesn't exist, assign user group
					$user->group = '';
				}
			}
		}
					
		// Create a reference to users & pages
		$this->data->users =& $users;
		$this->data->pages =& $pages;
		
		// Load the admincp users view
		$this->load->view(ADMINCP . 'users', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Add
	 *
	 * Add's a user
	 *
	 * @access	public
	 * @return	void
	 */
	function add()
	{
		// Retrieve the forms
		$add_user = $this->input->post('add_user');
		
		// Check it add user has been posted
		if($add_user)
		{
			// Set form validation rules
			$this->form_validation->set_rules('usergroup', 'Usergroup', 'trim|required');
			$this->form_validation->set_rules('activation', 'Activated', 'trim|required');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|callback__alpha_dash_space|callback__check_username');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback__check_email');
			$this->form_validation->set_rules('email_confirmation', 'Email Confirmation', 'trim|required|matches[email]');
			$this->form_validation->set_rules('password_generate', 'Generate Password', 'trim|required');
			
			// Check if password generate exists
			if((bool) !$this->input->post('password_generate'))
			{
				// Password generate doesn't exist, set form validation rules
				$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
				$this->form_validation->set_rules('password_confirmation', 'Password Confirmation', 'trim|required|matches[password]');
			}
			
			// Set form validation rules
			$this->form_validation->set_rules('avatar', 'Avatar', 'trim');
			$this->form_validation->set_rules('timezone', 'Timezone', 'trim|required');
			$this->form_validation->set_rules('daylight_savings', 'Daylight Savings', 'trim|required');
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{
				// Check if avatar exists
				if($_FILES['avatar']['name'])
				{
					// Set up upload config
					$config['upload_path'] = UPLOAD . 'avatars';
					$config['allowed_types'] = 'gif|jpg|png|bmp';
					$config['encrypt_name'] = TRUE;
				
					// Avatar exists, load the upload library
					$this->load->library('upload', $config);
			
					// Check to see if the avatar was uploaded
					if(!$this->upload->do_upload('avatar'))
					{
						// Avatar wasn't uploaded, display errors
						$upload->errors = $this->upload->display_errors();
					}
					else
					{
						// Upload was successful, retrieve the data
						$data = array('upload_data' => $this->upload->data());
					}
				
					// Assign avatar
					$avatar = $data['upload_data']['file_name'];
				}
				else
				{
					// Assign avatar
					$avatar = '';
				}
					
				// Retrieve salt
				$salt = $this->user->_salt();
			
				// Check if the we need to generate a password
				if((bool) $this->input->post('password_generate'))
				{
					// Generate a password, assign password
					$generated_password = $this->user->_salt(8);
					$password = $this->encrypt->sha1($salt . $this->encrypt->sha1($generated_password));
				}
				else
				{
					// Don't generate a password, assign generated password & password
					$generated_password = $this->input->post('password');
					$password = $this->encrypt->sha1($salt . $this->encrypt->sha1($this->input->post('password')));
				}
				
				// Check if the user is activated
				if((bool) $this->input->post('activation'))
				{
					// User is activated, assign activation
					$activation = 1;
					
					// Load the email library
					$this->load->library('email');
			
					// Set up the email
					$this->email->from($this->ClanCMS->get_setting('site_email'), CLAN_NAME);
					$this->email->to($this->input->post('email'));
					$this->email->subject('Account Info for your account on ' . CLAN_NAME);
					$this->email->message("Hello " . $this->input->post('username') . ",\n\nWelcome to " . CLAN_NAME . "! Here are your login details for your account:\n\nUsername: " . $this->input->post('username') . "\nPassword: " . $generated_password . "\n\nThanks for Registering!\n" . CLAN_NAME . "\n" . site_url());	

					// Email the user
					$this->email->send();
				}
				else
				{
					// User is not activated, assign activation
					$activation = $this->encrypt->sha1($salt . $this->session->userdata('session_id'));
					
					// Load the email library
					$this->load->library('email');
			
					// Set up the email
					$this->email->from($this->ClanCMS->get_setting('site_email'), CLAN_NAME);
					$this->email->to($this->input->post('email'));
					$this->email->subject('Activation link for your account on ' . CLAN_NAME);
					$this->email->message("Hello " . $this->input->post('username') . ",\n\nWelcome to " . CLAN_NAME . "! Here are your login details for your account:\n\nUsername: " . $this->input->post('username') . "\nPassword: " . $generated_password . "\n\nHowever, before you can login you need to activate your account. Please click on the link below to activate your account.\n\n" . site_url() . "account/activate/" . $activation . "\n\nThanks for Registering!\n" . CLAN_NAME . "\n" . site_url());	

					// Email the user
					$this->email->send();
				}
				
				// Set up the data
				$data = array(
					'group_id'					=> $this->input->post('usergroup'),
					'user_name'					=> $this->input->post('username'),
					'user_password'				=> $password,
					'user_salt'					=> $salt,
					'user_email'				=> $this->input->post('email'),
					'user_timezone'				=> $this->input->post('timezone'),
					'user_daylight_savings'		=> $this->input->post('daylight_savings'),
					'user_ipaddress'			=> $this->input->ip_address(),
					'user_avatar'				=> $avatar,
					'user_activation'			=> $activation
				);
			
				// Insert the user in the database
				$this->users->insert_user($data);
				
				// Retrieve the user id
				$user_id = $this->db->insert_id();
				
				// Alert the adminstrator
				$this->session->set_flashdata('message', 'The user was successfully added!');
				
				// Redirect the adminstrator
				redirect(ADMINCP . 'users/edit/' . $user_id);
			}
		}
		
		// Retrieve the user groups
		$groups = $this->users->get_groups();
		
		// Create a reference to groups
		$this->data->groups =& $groups;
	
		// Load the admincp users add view
		$this->load->view(ADMINCP . 'users_add', $this->data);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Edit
	 *
	 * Edit's a user
	 *
	 * @access	public
	 * @return	void
	 */
	function edit()
	{
		// Set up the data
		$data = array(
			'user_id'	=>	$this->uri->segment(4)
		);
		
		// Retrieve the user
		if(!$user = $this->users->get_user($data))
		{
			// Users doesn't exist, redirect the administrator
			redirect(ADMINCP . 'users');
		}
		
		// Check if the user is a Super Administrator
		if(($user->user_id == SUPERADMINISTRATOR && $user->user_id != $this->session->userdata('user_id')))
		{
			// Alert the adminstrator
			$this->session->set_flashdata('message', 'This user is protected!');
				
			// User is a Super Administrator, redirect the administrator
			redirect(ADMINCP . 'users');
		}
		
		// Retrieve the forms
		$update_user = $this->input->post('update_user');
		
		// Check it update user has been posted
		if($update_user)
		{
			// Set form validation rules
			$this->form_validation->set_rules('usergroup', 'Usergroup', 'trim|required');
			$this->form_validation->set_rules('activation', 'Activated', 'trim|required');
			$this->form_validation->set_rules('new_username', 'Username', 'trim|callback__alpha_dash_space|callback__check_username');
			$this->form_validation->set_rules('new_email', 'Email', 'trim|valid_email|callback__check_email');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
			
			// Check if new password equals 1
			if($this->input->post('new_password') == 1)
			{
				// New password equals 1, set form validation rules
				$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
				$this->form_validation->set_rules('password_confirmation', 'Password Confirmation', 'trim|required|matches[password]');
			}
			
			// Set form validation rules
			$this->form_validation->set_rules('avatar', 'Avatar', 'trim');
			$this->form_validation->set_rules('timezone', 'Timezone', 'trim|required');
			$this->form_validation->set_rules('daylight_savings', 'Daylight Savings', 'trim|required');
			$this->form_validation->set_rules('ipaddress', 'IP Address', 'trim|required|valid_ip');
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{
				// Check if avatar exists
				if($_FILES['avatar']['name'])
				{
					// Set up upload config
					$config['upload_path'] = UPLOAD . 'avatars';
					$config['allowed_types'] = 'gif|jpg|png|bmp';
					$config['encrypt_name'] = TRUE;
				
					// Avatar exists, load the upload library
					$this->load->library('upload', $config);
			
					// Check to see if the avatar was uploaded
					if(!$this->upload->do_upload('avatar'))
					{
						// Avatar wasn't uploaded, display errors
						$upload->errors = $this->upload->display_errors();
					}
					else
					{
						// Upload was successful, retrieve the data
						$data = array('upload_data' => $this->upload->data());
					}
				
					// Change the avatar
					$avatar = $data['upload_data']['file_name'];

					// Check if avatar exists
					if(file_exists(UPLOAD . 'avatars/' . $user->user_avatar))
					{
						// Avatar eixsts, remove the avatar
						unlink(UPLOAD . 'avatars/' . $user->user_avatar);
					}
				}
				else
				{
					// Keep avatar the same
					$avatar = $user->user_avatar;
				}
				
				// Check if email changed
				if($this->input->post('new_email'))
				{
					// Email changed, assign user email
					$user_email = $this->input->post('new_email');
				}
				else
				{	
					// Email didn't change, assign user email
					$user_email = $user->user_email;
				}
				
				// Check if the user is activated
				if((bool) $this->input->post('activation'))
				{
					// User is activated, assign activation
					$activation = 1;
				}
				else
				{
					// User is not activated, assign activation
					$activation = $this->encrypt->sha1($user->user_salt . $this->session->userdata('session_id'));
					
					// Load the email library
					$this->load->library('email');
			
					// Set up the email
					$this->email->from($this->ClanCMS->get_setting('site_email'), CLAN_NAME);
					$this->email->to($user->user_email);
					$this->email->subject('Activation link for your account on ' . CLAN_NAME);
					$this->email->message("Hello " . $user->user_name . ",\n\nYour account has been de-activated and you need to re-activate it to login. Please click on the link below to re-activate your account.\n\n" . site_url() . "account/activate/" . $activation . "\n\nThanks for Registering!\n" . CLAN_NAME . "\n" . site_url());	

					// Email the user
					$this->email->send();
				}
				
				// Check if user name changed
				if($this->input->post('new_username'))
				{
					// User name changed, assign user name
					$user_name = $this->input->post('new_username');
					
					// Load the email library
					$this->load->library('email');
			
					// Set up the email
					$this->email->from($this->ClanCMS->get_setting('site_email'), CLAN_NAME);
					$this->email->to($user_email);
					$this->email->subject('Your account username has changed on ' . CLAN_NAME);
					$this->email->message("Hello " . $user_name . ",\n\nHere are your new account details on " . CLAN_NAME . ":\n\nUsername: " . $user_name . "\n\nThanks for Registering!\n" . CLAN_NAME . "\n" . site_url());	

					// Email the user
					$this->email->send();
				}
				else
				{	
					// User name didn't change, assign user name
					$user_name = $user->user_name;
				}
				
				// Check if password changed
				if($this->input->post('new_password') == 2)
				{
					// Generate a password, assign user password
					$generated_password = $this->user->_salt(8);
					$user_password = $this->encrypt->sha1($user->user_salt . $this->encrypt->sha1($generated_password));
					
					// Load the email library
					$this->load->library('email');
			
					// Set up the email
					$this->email->from($this->ClanCMS->get_setting('site_email'), CLAN_NAME);
					$this->email->to($user_email);
					$this->email->subject('Your account password has changed on ' . CLAN_NAME);
					$this->email->message("Hello " . $user_name . ",\n\nWelcome to " . CLAN_NAME . "! Here are your login details for your account:\n\nUsername: " . $user_name . "\nPassword: " . $generated_password . "\n\nThanks for Registering!\n" . CLAN_NAME . "\n" . site_url());	

					// Email the user
					$this->email->send();
				}
				elseif($this->input->post('new_password') == 1)
				{	
					// Password changed, assign user password
					$user_password = $this->encrypt->sha1($user->user_salt . $this->encrypt->sha1($this->input->post('password')));
					
					// Load the email library
					$this->load->library('email');
			
					// Set up the email
					$this->email->from($this->ClanCMS->get_setting('site_email'), CLAN_NAME);
					$this->email->to($user_email);
					$this->email->subject('Your account password has changed on ' . CLAN_NAME);
					$this->email->message("Hello " . $user_name . ",\n\nHere are your new account details on " . CLAN_NAME . ":\n\nUsername: " . $user_name . "\nPassword: " . $this->input->post('password') . "\n\nThanks for Registering!\n" . CLAN_NAME . "\n" . site_url());	

					// Email the user
					$this->email->send();
				}
				else
				{
					// Password didn't change, assign user password
					$user_password = $user->user_password;
				}
				
				// Set up the data
				$data = array(
					'group_id'					=> $this->input->post('usergroup'),
					'user_name'					=> $user_name,
					'user_password'				=> $user_password,
					'user_email'				=> $user_email,
					'user_timezone'				=> $this->input->post('timezone'),
					'user_daylight_savings'		=> $this->input->post('daylight_savings'),
					'user_avatar'				=> $avatar,
					'user_activation'			=> $activation
				);
				
				// Insert the user in the database
				$this->users->update_user($user->user_id, $data);
				
				// Alert the adminstrator
				$this->session->set_flashdata('message', 'The user was successfully updated!');
				
				// Redirect the adminstrator
				redirect(ADMINCP . 'users/edit/' . $user->user_id);
			}
		}
		
		// Retrieve the user groups
		$groups = $this->users->get_groups();
		
		// Retrieve user joined, format timezone & assign user joined
		$user->joined = $this->ClanCMS->timezone($user->user_joined);
		
		// Create a reference to user & groups
		$this->data->user =& $user;
		$this->data->groups =& $groups;
	
		// Load the admincp users edit view
		$this->load->view(ADMINCP . 'users_edit', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete
	 *
	 * Delete's a user
	 *
	 * @access	public
	 * @return	void
	 */
	function delete()
	{
		// Set up the data
		$data = array(
			'user_id'	=>	$this->uri->segment(4, '')
		);
		
		// Retrieve the user
		if(!$user = $this->users->get_user($data))
		{
			// User doesn't exist, redirect the administrator
			redirect(ADMINCP . 'users');
		}
		
		// Check if the user is a Super Administrator
		if($user->user_id == SUPERADMINISTRATOR)
		{
			// Alert the adminstrator
			$this->session->set_flashdata('message', 'This user is protected!');
			
			// User is a Super Administrator, redirect the administrator
			redirect(ADMINCP . 'users');
		}
		
		// Retrieve the articles
		if($articles = $this->articles->get_articles('', '', array('user_id' => $user->user_id)))
		{
			// Loop through each article
			foreach($articles as $article)
			{
				// Retrieve the comments
				if($comments = $this->articles->get_comments('', '', array('article_id' => $article->article_id)))
				{
					// Loop through each comment
					foreach($comments as $comment)
					{
						// Delete the comment from the dabatase
						$this->articles->delete_comment($comment->comment_id);
					}
				}
				
				// Delete the article from the database
				$this->articles->delete_article($article->article_id);
			}
		}
		
		// Retrieve the members
		if($members = $this->squads->get_members(array('user_id' => $user->user_id)))
		{
			// Loop through each member
			foreach($members as $member)
			{
				// Retrieve players
				if($players = $this->matches->get_players(array('member_id' => $member->member_id)))
				{
					// Loop through each player
					foreach($players as $player)
					{
						// Delete the player from the database
						$this->matches->delete_player($player->player_id);
					}
				}
				
				// Delete the member from the database
				$this->squads->delete_member($member->member_id);
			}
		}
		
		// Retrieve article comments
		if($comments = $this->articles->get_comments('', '', array('user_id' =>  $user->user_id)))
		{
			// Loop through each comment
			foreach($comments as $comment)
			{
				// Delete the comment from the database
				$this->articles->delete_comment($comment->comment_id);
			}
		}
		
		// Retrieve match comments
		if($comments = $this->matches->get_comments('', '', array('user_id' =>  $user->user_id)))
		{
			// Loop through each comment
			foreach($comments as $comment)
			{
				// Delete the comment from the database
				$this->matches->delete_comment($comment->comment_id);
			}
		}
		
		// Check if avatar exists
		if(file_exists(UPLOAD . 'avatars/' . $user->user_avatar))
		{
			// Avatar eixsts, remove the avatar
			unlink(UPLOAD . 'avatars/' . $user->user_avatar);
		}
					
		// Delete the user from the database
		$this->users->delete_user($user->user_id);
				
		// Alert the adminstrator
		$this->session->set_flashdata('message', 'The user was successfully deleted!');
				
		// Redirect the adminstrator
		redirect(ADMINCP . 'users');
	}

	// --------------------------------------------------------------------

	/**
	 * Alpha Dash Space
	 *
	 * Check's to see if a username is valid
	 *
	 * @access	private
	 * @param	string
	 * @return	bool
	 */
	function _alpha_dash_space($user_name = '')
	{
		// Check if user name exists
		if($user_name == '')
		{
			// User name doesn't exist, return TRUE
			return TRUE;
		}
		
		// Check if the user name is valid
		if(!preg_match("/^([-a-z0-9_ ])+$/i", $user_name))
		{
			// User name isn't valid, alert the user & return FALSE
			$this->form_validation->set_message('_alpha_dash_space', 'The username may only contain alpha-numeric characters, spaces, underscores, and dashes.');
			return FALSE;
		}
		else
		{
			// User name is valid, return TRUE
			return TRUE;
		}
	} 

	// --------------------------------------------------------------------
	
	/**
	 * Check Username
	 *
	 * Check's to see if a username is unique
	 *
	 * @access	private
	 * @param	string
	 * @return	bool
	 */
	function _check_username($user_name = '')
	{
		// Set up the data
		$data = array(
			'user_name'		=> $user_name
		);
		
		// Retrieve the user
		if(!$user = $this->users->get_user($data))
		{
			// User doesn't exist, return TRUE
			return TRUE;
		}
		else
		{
			// User exists, alert the user & return FALSE
			$this->form_validation->set_message('_check_username', 'That username is already taken.');
			return FALSE;
		}
	}
			
	// --------------------------------------------------------------------
	
	/**
	 * Check Email
	 *
	 * Check's to see if a email is unique
	 *
	 * @access	private
	 * @param	string
	 * @return	bool
	 */
	function _check_email($user_email = '')
	{
		// Set up the data
		$data = array(
			'user_email'	=> $user_email
		);
		
		// Retrieve the user
		if(!$user = $this->users->get_user($data))
		{
			// User doesn't exist, return TRUE
			return TRUE;
		}
		else
		{
			// User exists, alert the user & return FALSE
			$this->form_validation->set_message('_check_email', 'That email is already taken.');
			return FALSE;
		}
	}
	
}

/* End of file users.php */
/* Location: ./application/controllers/admincp/users.php */
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
 * Clan CMS Account Controller
 *
 * @package		Clan CMS
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Account extends Controller {

	/**
	 * Constructor
	 *
	 */	
	function Account()
	{
		// Call the Controller constructor
		parent::Controller();
		
		// Load the Matches model
		$this->load->model('Matches_model', 'matches');
		
		// Load the Squads model
		$this->load->model('Squads_model', 'squads');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Edit's the user
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Check to see if the user is logged in
		if (!$this->user->logged_in())
		{
			// User is not logged in, redirect them
			redirect('account/login');
		}
		
		// Retrieve the user
		if(!$user = $this->users->get_user(array('user_id' => $this->session->userdata('user_id'))))
		{
			// User doesn't exist, redirect them
			redirect('account/login');
		}
		
		// Retrieve the forms
		$update_password = $this->input->post('update_password');
		$update_email = $this->input->post('update_email');
		$update_preferences = $this->input->post('update_preferences');
		
		// Check it update password has been posted
		if($update_password)
		{
			// Set form validation rules
			$this->form_validation->set_rules('password', 'Current Password', 'trim|required|callback__check_password');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[8]');
			$this->form_validation->set_rules('new_password_confirmation', 'Re-type New Password', 'trim|required|matches[new_password]');
		
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{
				// Set up the data
				$data = array (
					'user_password'	=> $this->encrypt->sha1($user->user_salt . $this->encrypt->sha1($this->input->post('new_password')))
				);
				
				// Update the user in the datbase
				$this->users->update_user($user->user_id, $data);
				
				// Redirect the user
				redirect('account/login');
			}
		}
		
		// Check it update email has been posted
		if($update_email)
		{
			// Set form validation rules
			$this->form_validation->set_rules('new_email', 'New Email', 'trim|required|valid_email|callback__check_email');
			$this->form_validation->set_rules('new_email_confirmation', 'Re-type New Email', 'trim|required|matches[new_email]');
		
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{
				// Set up the data
				$data = array (
					'user_email'	=> $this->input->post('new_email')
				);
			
				// Update the user in the database
				$this->users->update_user($user->user_id, $data);
				
				// Alert the user
				$this->session->set_flashdata('message', 'Your email has been updated!');
				
				// Redirect the user
				redirect('account');
			}
		}
		
		// Check it update preferences has been posted
		if($update_preferences)
		{
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
				
				// Set up the data
				$data = array (
					'user_timezone'				=> $this->input->post('timezone'),
					'user_daylight_savings'		=> $this->input->post('daylight_savings'),
					'user_avatar'				=> $avatar
				);
			
				// Update the user in the database
				$this->users->update_user($user->user_id, $data);
				
				// Alert the user
				$this->session->set_flashdata('message', 'Your preferences have been updated!');
				
				// Redirect the user
				redirect('account');
			}
		}
		
		// Create a reference to user
		$this->data->user =& $user;
		
		// Load the account view
		$this->load->view(THEME . 'account', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Profile
	 *
	 * Display's a user profile
	 *
	 * @access	public
	 * @return	void
	 */
	function profile()
	{
		// Retrieve the user slug
		$user_slug = $this->uri->segment(3, '');
		
		// Retrieve the user or show 404
		($user = $this->users->get_user(array('user_name' => $this->users->user_name($user_slug)))) or show_404();
		
		// Retrieve user joined, format timezone & assign user joined
		$user->joined = $this->ClanCMS->timezone($user->user_joined);
				
		// Retrieve the group
		if($group = $this->users->get_group(array('group_id' => $user->group_id)))
		{
			// Group exist's assign user group
			$user->group = $group->group_title;
		}
		else
		{
			// Group doesn't exist, assign user group
			$user->group = '';
		}
		
		// Retrieve members
		$members = $this->squads->get_members(array('user_id' => $user->user_id));
		
		// Check if members exist
		if($members)
		{
			// Members exist, loop through each member
			foreach($members as $member)
			{
				// Retrieve the squad
				$squad = $this->squads->get_squad(array('squad_id' => $member->squad_id));
				
				// Assign squad slug
				$member->squad_slug = $squad->squad_slug;
				
				// Assign squad title
				$member->squad_title = $squad->squad_title;
				
				// Retrieve the total number of member wins
				$member->total_wins = $this->squads->count_wins(array('member_id' => $member->member_id));
				
				// Retrieve the total number of member losses
				$member->total_losses = $this->squads->count_losses(array('member_id' => $member->member_id));
				
				// Retrieve the total number of member ties
				$member->total_ties = $this->squads->count_ties(array('member_id' => $member->member_id));
				
				// Retrieve the total number of member kills
				$member->total_kills = $this->squads->count_kills(array('member_id' => $member->member_id));
						
				// Retrieve the total number of member deaths
				$member->total_deaths = $this->squads->count_deaths(array('member_id' => $member->member_id));
				
				// Check if member total deaths equals 0
				if($member->total_deaths == 0)
				{
					// Member total deaths equals 0, format kills & deaths, assign member kd
					$member->kd = number_format(($member->total_kills / 1), 2, '.', '');
				}
				else
				{
					// Member total deaths doesn't equal 0, format kills & deaths, assign member kd
					$member->kd = number_format(($member->total_kills / $member->total_deaths), 2, '.', '');
				}
				
				// Retrieve the member squad
				$member->squad = $this->squads->get_squad(array('squad_id' => $member->squad_id));
				
				// Retrieve matches
				//$members->matches = $this->matches->get_players(array('member_id' => $user->user_id));
				
				// Retrieve the total matches
				$member->total_matches = $this->matches->count_matches(array('squad_id' => $member->squad_id));
				
				// Retrieve the total matches played
				$member->total_matches_played = $this->matches->count_players(array('member_id' => $member->member_id));
			
				// Check if total matches equals 0
				if($member->total_matches == 0)
				{
					// Format matches total matches played & total matches, assign matches percent
					$member->matches_percent = number_format((100 * ($member->total_matches_played / 1)), 0, '.', '');
				}
				else
				{
					// Format matches total matches played & total matches, assign matches percent
					$member->matches_percent = number_format((100 * ($member->total_matches_played / $member->total_matches)), 0, '.', '');
				}
			}
		}
		
		// Retrieve matches
		if($matches = $this->matches->get_matches())
		{
			// Assign recent matches
			$recent_matches = array();
				
			// Assign matches count
			$matches_count = 0;
			
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
		
				// Retrieve the squad
				$squad = $this->squads->get_squad(array('squad_id' => $match->squad_id));
				
				// Assign match squad
				$match->squad = $squad->squad_title;
				
				// Assign match squad slug
				$match->squad_slug = $squad->squad_slug;
				
				// Check if members exist
				if($members)
				{
					// Members exist, loop through each member
					foreach($members as $member)
					{
						// Retrieve the player
						if($player = $this->matches->get_player(array('match_id' => $match->match_id, 'member_id' => $member->member_id)))
						{
							// Assign match kills
							$match->kills = $player->player_kills;
							
							// Assign match deaths
							$match->deaths = $player->player_deaths;
							
							// Check if match deaths equals 0
							if($match->deaths == 0)
							{
								// Match deaths equals 0, format kills & deaths, assign match kd
								$match->kd = number_format(($match->kills / 1), 2, '.', '');
							}
							else
							{
								// Match deaths doesn't equal 0, format kills & deaths, assign match kd
								$match->kd = number_format(($match->kills / $match->deaths), 2, '.', '');
							}
				
							// Check if matches count is less then 5
							if($matches_count < 5)
							{
								// Matches count it less then 5, player exists & assign recent matches
								$recent_matches = array_merge($recent_matches, array($match));
							}
							
							// Itterate matches count
							$matches_count =+ 1;
						}
					}
				}
			}
		}
		
		// Create a reference to user, members & matches
		$this->data->user =& $user;
		$this->data->members =& $members;
		$this->data->matches =& $recent_matches;
		
		// Load the profile view
		$this->load->view(THEME . 'profile', $this->data);
	}
	
	
	// --------------------------------------------------------------------
	
	/**
	 * Login
	 *
	 * Login's a user
	 *
	 * @access	public
	 * @return	void
	 */
	function login()
	{
		// Check to see if the user is logged in
		if ($this->user->logged_in())
		{
			// User is logged in, redirect them
			redirect('account');
		}
		
		// Retrieve the forms
		$redirect = $this->input->post('redirect');
		
		// Set form validation rules
		$this->form_validation->set_rules('username', 'User Name', 'trim|required|callback__check_login');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		
		// Form validation passed, so continue
		if (!$this->form_validation->run() == FALSE)
		{
			// Login the user
			if(!$this->user->login($this->input->post('username'), $this->input->post('password'), $this->input->post('remember')))
			{
				// Login failed, alert the user
				$this->form_validation->set_message('login_failed', 'Invalid username or password');
			}
			else
			{
				// Redirect the user
				redirect($redirect);
			}
		}
		
		// Load the login view
		$this->load->view(THEME . 'login');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Logout
	 *
	 * Logout's a user
	 *
	 * @access	public
	 * @return	void
	 */
	function logout()
	{
		// Logout the user
		$this->user->logout();
		
		// Redirect the user
		redirect($this->session->userdata('previous'));
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Activate
	 *
	 * Activate's a user account
	 *
	 * @access	public
	 * @return	void
	 */
	function activate()
	{
		// Check to see if the user is logged in
		if ($this->user->logged_in())
		{
			// User is logged in, redirect them
			redirect('account');
		}
		
		// Set up the data
		$data = array(
			'user_activation'	=> $this->uri->segment(3, '')
		);
		
		// Retrieve the user
		if($user = $this->users->get_user($data))
		{
			// User exists, set up the data
			$data = array(
				'user_activation'	=> 1
			);
			
			// Update the user in the database
			$this->users->update_user($user->user_id, $data);
			
			// Assign page title
			$page->title = "Activation Success";
		
			// Assign page content
			$page->content = 'Your account has been activated!' . br(2) . 'You should now be able to ' . anchor('account/login', 'login') . ' and interact with the site.' . br(2) . 'Thanks for Registering!' . br() . CLAN_NAME . br() . anchor(base_url());
			
			// Create a reference to page
			$this->data->page =& $page;
		
			// Load the page view
			$this->load->view(THEME . 'page', $this->data);
		}
		else
		{
			// Assign page title
			$page->title = "Activation Error";
		
			// Assign page content
			$page->content = 'This is an invalid activation link!' . br(2) . 'Please try again. If you are still having issues please ' . anchor('about', 'contact a site administrator') . br(2) . 'Thanks for Registering!' . br() . CLAN_NAME . br() . anchor(base_url());
			
			// Create a reference to page
			$this->data->page =& $page;
			
			// Load the page view
			$this->load->view(THEME . 'page', $this->data);
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Forgot
	 *
	 * Retrieve's a user account
	 *
	 * @access	public
	 * @return	void
	 */
	function forgot()
	{		
		// Check to see if the user is logged in
		if ($this->user->logged_in())
		{
			// User is logged in, redirect them
			redirect('account');
		}
		
		// Set form validation rules
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback__check_forgot');

		// Form validation passed, so continue
		if (!$this->form_validation->run() == FALSE)
		{
			// Retrieve the user
			if($user = $this->users->get_user(array('user_email' => $this->input->post('email'))))
			{
				// Load the email library
				$this->load->library('email');
			
				// Set up the email data
				$this->email->from($this->ClanCMS->get_setting('site_email'), CLAN_NAME);
				$this->email->to($this->input->post('email'));
				$this->email->subject('Account information requested on ' . CLAN_NAME);
				$this->email->message("Hello " . $user->user_name . ",\n\nYou have requested your account information on " . CLAN_NAME . ". Here is your account information:\n\nUsername: " . $user->user_name . "\n\nIf you forgot your password please click the link below to reset your password:\n\n" . base_url() . "account/reset/" . $this->encrypt->sha1($user->user_password) . "/user/" . $user->user_id . "\n\nThanks for Registering!\n" . CLAN_NAME . "\n" . base_url());	

				// Email the user the activation code
				$this->email->send();
			
				// Assign page title
				$page->title = "Account Information Sent";
		
				// Assign page content
				$page->content = 'An email containing your username and instructions on changing your password has been sent to your email address.'. br(2) . 'Thanks for Registering!' . br() . CLAN_NAME . br() . anchor(base_url());
	
				// Create a reference to page
				$this->data->page =& $page;
				
				// Load the page view
				$this->load->view(THEME . 'page', $this->data);
			}
		}
		else
		{
		
			// Load the forgot view
			$this->load->view(THEME . 'forgot');
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Reset
	 *
	 * Reset's a user password
	 *
	 * @access	public
	 * @return	void
	 */
	function reset()
	{		
		// Check to see if the user is logged in
		if ($this->user->logged_in())
		{
			// User is logged in, redirect them
			redirect('account');
		}
		
		// Retrieve the user
		if(!$user = $this->users->get_user(array('user_id' => $this->uri->segment(5, ''))))
		{
			// User is logged in, redirect them
			redirect('account');
		}
		
		// Assign user reset code
		$user->reset_code = $this->encrypt->sha1($user->user_password);
		
		// Check if reset code is valid
		if($user->reset_code == $this->uri->segment(3, ''))
		{
			// Set form validation rules
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[8]');
			$this->form_validation->set_rules('new_password_confirmation', 'Re-type New Password', 'trim|required|matches[new_password]');
		
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{
				// Set up the data
				$data = array (
					'user_password'	=> $this->encrypt->sha1($user->user_salt . $this->encrypt->sha1($this->input->post('new_password')))
				);
				
				// Update the user in the datbase
				$this->users->update_user($user->user_id, $data);
				
				// Load the email library
				$this->load->library('email');
			
				// Set up the email data
				$this->email->from($this->ClanCMS->get_setting('site_email'), CLAN_NAME);
				$this->email->to($user->user_email);
				$this->email->subject('Account information updated on ' . CLAN_NAME);
				$this->email->message("Hello " . $user->user_name . ",\n\nYour account information has been updated on " . CLAN_NAME . ". Here is your account information:\n\nUsername: " . $user->user_name . "\nPassword: " . $this->input->post('new_password') . "\n\nThanks for Registering!\n" . CLAN_NAME . "\n" . base_url());	
				// Email the user the activation code
				$this->email->send();
		
				// Assign page title
				$page->title = 'Password Reset';
				
				// Assign page content
				$page->content = 'You have sucessfully reset your password!' . br(2) . 'An email containing your account infromation has been sent to you in case you forget again.' . br(2) . 'Thanks for Registering!' . br() . CLAN_NAME . br() . anchor(base_url());
			
				// Create a reference to page
				$this->data->page =& $page;
				
				// Load the page view
				$this->load->view(THEME . 'page', $this->data);
			}
			else
			{
				// Create a reference to user
				$this->data->user =& $user;
				
				// Load the forgot view
				$this->load->view(THEME . 'reset', $this->data);
			}
		}
		else
		{
			// Assign page title
			$page->title = 'Invalid Reset Code';
			
			// Assign page content
			$page->content = 'This is not a valid password reset code!';
			
			// Create a reference to page
			$this->data->page =& $page;
		
			// Load the page view
			$this->load->view(THEME . 'page', $this->data);
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Check Password
	 *
	 * Check's to see if the user's password is valid
	 *
	 * @access	private
	 * @param	string
	 * @return	bool
	 */
	function _check_password($user_password = '')
	{
		// Retrieve the user
		if(!$user = $this->users->get_user(array('user_id' => $this->session->userdata('user_id'))))
		{
			// User doesn't exist, alert the user & return FALSE
			$this->form_validation->set_message('_check_password', 'That is not your current password');
			return FALSE;
		}
		
		// Create the password to be checked
		$check_password = $this->encrypt->sha1($user->user_salt . $this->encrypt->sha1($this->input->post('password')));
		
		// Check if user password equals check password
		if($user->user_password == $check_password)
		{
			// User password equals check password, return TRUE
			return TRUE;
		}
		else
		{
			// User password doesn't equal check password, alert the user & return FALSE
			$this->form_validation->set_message('_check_password', 'That is not your current password');
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
	
	// --------------------------------------------------------------------
	
	/**
	 * Check Login
	 *
	 * Check's to see if the user's login credentials are valid
	 *
	 * @access	private
	 * @param	string
	 * @return	bool
	 */
	function _check_login($user_name = '')
	{
		// Set up the data
		$data = array(
			'user_name'			=> $user_name
		);
		
		// Retrieve the user
		if(!$user = $this->users->get_user($data))
		{
			// User doesn't exist, alert the user & return FALSE
			$this->form_validation->set_message('_check_login', 'Invalid username or password');
			return FALSE;
		}
		
		// Set up the data
		$data = array(
			'user_name'			=> $user_name,
			'user_password'		=> $this->encrypt->sha1($user->user_salt . $this->encrypt->sha1($this->input->post('password')))
		);
		
		// Retrieve the user
		if($user = $this->users->get_user($data))
		{
			// Check is user activation equals 1
			if($user->user_activation == 1)
			{
				// User exists, return TRUE
				return TRUE;
			}
			else
			{
				// User activation doesn't equal 1, alert the user & return FALSE
				$this->form_validation->set_message('_check_login', 'Your account has not been activated.');
				return FALSE;
			}
		}
		else
		{
			// User doesn't exist, alert the user & return FALSE
			$this->form_validation->set_message('_check_login', 'Invalid username or password.');
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Check Forgot
	 *
	 * Check's to see if a email exists
	 *
	 * @access	private
	 * @param	string
	 * @return	bool
	 */
	function _check_forgot($user_email = '')
	{
		// Set up the data
		$data = array(
			'user_email'	=> $user_email
		);
		
		// Retrieve the user
		if($user = $this->users->get_user($data))
		{
			// User exists, return TRUE
			return TRUE;
		}
		else
		{
			// User doesn't exist, alert the user & return FALSE
			$this->form_validation->set_message('_check_forgot', 'There are no users with that email.');
			return FALSE;
		}
	}
	
}

/* End of file account.php */
/* Location: ./clancms/controllers/account.php */
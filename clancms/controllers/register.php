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
 * Clan CMS Register Controller
 *
 * @package		Clan CMS
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Register extends Controller {
	
	/**
	 * Constructor
	 *
	 */	
	function Register()
	{
		// Call the Controller constructor
		parent::Controller();
		
		// Load the array helper
		$this->load->helper('array');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Add's a user
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Check it the user is logged in
		if($this->user->logged_in())
		{
			// User is logged in, redirect them
			redirect('account');
		}
		
		// Check if registration is allowed
		if((bool) !$this->ClanCMS->get_setting('allow_registration'))
		{
			// Assign page title
			$page->title = 'Registration is not allowed!';
			
			// Assign page content
			$page->content = 'Sorry, but registration has been disabled by an administrator. Please try again later.' . br(2) . 'Thanks,' . br() . CLAN_NAME . br() . anchor(base_url());
			
			// Create a reference to page
			$this->data->page =& $page;
			
			// Load the page view
			$this->load->view(THEME . 'page', $this->data);
		}
		else
		{
			// Set form validation rules
			$this->form_validation->set_rules('username', 'Username', 'trim|required|callback__alpha_dash_space|callback__check_username');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback__check_email');
			$this->form_validation->set_rules('email_confirmation', 'Email Confirmation', 'trim|required|matches[email]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
			$this->form_validation->set_rules('password_confirmation', 'Password Confirmation', 'trim|required|matches[password]');
			$this->form_validation->set_rules('timezone', 'Timezone', 'trim|required');
			$this->form_validation->set_rules('daylight_savings', 'Daylight Savings', 'trim|required');
			$this->form_validation->set_rules('captcha', 'Captcha', 'trim|required|callback__check_captcha');
						
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{
				// Retrieve salt
				$salt = $this->user->_salt();
				
				// Set up the data
				$data = array(
					'group_id'					=> 1,
					'user_name'					=> $this->input->post('username'),
					'user_password'				=> $this->encrypt->sha1($salt . $this->encrypt->sha1($this->input->post('password'))),
					'user_salt'					=> $salt,
					'user_email'				=> $this->input->post('email'),
					'user_timezone'				=> $this->input->post('timezone'),
					'user_daylight_savings'		=> $this->input->post('daylight_savings'),
					'user_ipaddress'			=> $this->input->ip_address(),
					'user_avatar'				=> '',
					'user_activation'			=> $this->session->userdata('session_id'),
					'user_joined'				=> mdate('%Y-%m-%d %H:%i:%s', now())
				);
				
				// Insert the user in the database
				$this->users->insert_user($data);
				
				// Load the email library
				$this->load->library('email');
				
				// Set up the email
				$this->email->from($this->ClanCMS->get_setting('site_email'), CLAN_NAME);
				$this->email->to($this->input->post('email'));
				$this->email->subject('Activation link for your account on ' . CLAN_NAME);
				$this->email->message("Hello " . $this->input->post('username') . ",\n\nWelcome to " . CLAN_NAME . "! Here are your login details for your account:\n\nUsername: " . $this->input->post('username') . "\nPassword: " . $this->input->post('password') . "\n\nHowever, before you can login you need to activate your account. Please click on the link below to activate your account.\n\n" . base_url() . "account/activate/" . $this->session->userdata('session_id') . "\n\nThanks for Registering!\n" . CLAN_NAME . "\n" . base_url());	

				// Email the user
				$this->email->send();

				// Assign page title
				$page->title = 'Registration Success!';
				
				// Assign page content
				$page->content = 'Congratulations, you have successfully registered on ' . anchor('', CLAN_NAME) . '!' . br(2) . 'However, before you can login to your account you need to activate it. Please look at your email for the activation email.' . br(2) . 'Thanks for Registering!' . br() . CLAN_NAME . br() . anchor(base_url());
				
				// Create a reference to page
				$this->data->page =& $page;
				
				// Load the page view
				$this->load->view(THEME . 'page', $this->data);
			}
			else
			{
				// Load the image library
				$this->load->library('image_lib');
				
				// Load the captcha helper
				$this->load->helper('captcha');
				
				// Retrieve the word bank
				$word_bank = explode("\n", $this->ClanCMS->get_setting('captcha_words'));
				
				// Choose a word from the word bank
				$word = random_element($word_bank);
				
				// Assign the word to the session
				$this->session->set_userdata('captcha', $word);
				
				// Set up the data
				$data = array(
					'word'	 	 => $word,
					'img_path'	 => UPLOAD . 'captcha',
					'img_url'	 => IMAGES . 'captcha',
					'img_width'	 => 150,
					'img_height' => 50,
					'expiration' => 0
				);
			
				// Create the captcha
				$captcha = create_captcha($data);
			
				// Create a reference to captcha
				$this->data->captcha =& $captcha;
				
				// Load the register view
				$this->load->view(THEME . 'register', $this->data);
			}
		}
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
			
	// --------------------------------------------------------------------
	
	/**
	 * Check Captcha
	 *
	 * Check's to see if a captcha matches
	 *
	 * @access	private
	 * @param	string
	 * @return	bool
	 */
	function _check_captcha($user_captcha = '')
	{
		// Check if the captcha matches
		if(strtolower($user_captcha) == strtolower($this->session->userdata('captcha')))
		{
			// Captcha matches, return TRUE
			return TRUE;
		}
		else
		{
			// Captcha doesn't match, alert the user & return FALSE
			$this->form_validation->set_message('_check_captcha', 'The CAPTCHA word(s) are incorrect.');
			return FALSE;
		}
	}
}

/* End of file register.php */
/* Location: ./clancms/controllers/register.php */
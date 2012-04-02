<?php
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
 * @since			Version 0.6.2
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Shoutbox
 *
 * @package		Clan CMS
 * @subpackage	Widgets
 * @category		Widgets
 * @author		co[dezyne]
 * @link			http://www.codezyne.me
 */
class Shoutbox_widget extends Widget {

	// Widget information
	public $title = 'Shoutbox';
	public $description = "Allows users to communicate through shoutbox.";
	public $author = 'co[dezyne]';
	public $link = 'http://www.codezyne.me';
	public $version = '2.0';
	

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
	 * Display's the shouts
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Load the Users model
		$this->CI->load->model('Users_model', 'users');

		// Display previous shouts
		$shouts = $this->get_shouts(10);
		
		// Retrieve the user
		$user = $this->CI->users->get_user(array('user_id' => $this->CI->session->userdata('user_id')));
		
		// Check to see if user exist
		if($user)
		{
			// Retrieve the group
			if($group = $this->CI->users->get_group(array('group_id' => $user->group_id)))
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
		
		
		
		if($shouts)
		{
			// Time Conversions
			$current = strtotime(date('Y-m-d G:i:s'));
			foreach($shouts as $shout)
				{ 
					// Set matching for post time
					$delay = round((($current - strtotime($shout->when)) / 60 ), 0);
					
					if($delay <= 3){
						// Shouts less than 3 minutes
						$shout->delay  = 'just now';
					}elseif($delay > 3 && $delay < 60){
						
						// Shouts 3 to 60 minutes
						$shout->delay = $delay . ' mins ago';
						
					}elseif($delay >= 60 && $delay < 1440){
						
						// Shouts greater than one hour 
						$delay = round(($delay / 60), 0);
						$shout->delay  = $delay . ' hours ago';
						
					}elseif($delay >= 1440 && $delay < 10800){
						
						// Shouts greater than a day
						$delay = round(($delay / 1440), 0);
						$shout->delay = $delay . ' days ago';
						
					}elseif($delay >= 10800){
						
						// Shouts greater than a week
						$delay = round(($delay / 10080), 0);
						$shout->delay  = $delay . ' weeks ago';		
											
					}
				}
				
		
			// Search shouts for hyperlinks
			foreach($shouts as $shout)
			{
				// Break apart the shoutted comment
				$chunk = explode(' ', $shout->shout);
				
				// Iterate through array searching for URIs
				 foreach($chunk as &$bit)
				 {
				 	
				 	$check_www = preg_match('/^www/', $bit);
				 	$check_http = preg_match('/^http/', $bit);
				 	
				 	// If shout contains a link, anchor it, else leave it alone
				 	if($check_www == 1)
				 	{
				 		$bit = '<a href="http://' . $bit . '" target="_blank" />' . $bit . '</a>';
				 	}elseif($check_http == 1)
				 	{
				 		$bit = '<a href="' . $bit . '" target="_blank" />' . $bit . '</a>';
				 	}else{
				 		$bit = $bit;
				 	}
				 	
				 }
				 
				 // Put array back together
				$merged = implode(' ', $chunk);
				
				// Reference newly build shout
				$shout ->shout = $merged;
				
				// Replace whitespace, if exists
				$shout->user_clean = preg_replace('/\s/', '+', $shout->user);
			}
		}
		
		$shoutbox = $this->CI->input->post('shoutbox');
		
		//  If shout submitted, verify push to add_shout()
		if ($shoutbox) {
			$this->CI->form_validation->set_rules('comment', 'Shout', 'required');
			
			// Form validation passed, so continue
			if (!$this->CI->form_validation->run() == FALSE)
			{
					$push = array(
						'user'	=>	$this->CI->input->post('user'),
						'shout'	=>	$this->CI->input->post('comment'),
						'avatar'	=>	$this->CI->input->post('avatar'),
						'rank'	=>	$this->CI->input->post('rank')
					);
			
			$this->add_shout($push);
			
			// Comment passed, notify user
			$this->CI->session->set_flashdata('shout', 'Shout added!!');
		
			// Redirect the user to refresh
			redirect($this->CI->session->userdata('previous', 'refresh'));
			}
		}
			
		// Create a reference to user
		$this->data->user = $user;
		$this->data->shouts = $shouts;
		
		// Assign the widget info
		$widget->title = 'Shoutbox';
		$widget->content = $this->CI->load->view('widgets/shoutbox', $this->data, TRUE);
		$widget->tabs = array();
		
		// Load the widget view
		$this->CI->load->view(WIDGET . 'widget', $widget);
	}
	// --------------------------------------------------------------------
	
	/**
	 * Get Shouts
	 *
	 * Retrieves last shouts
	 *
	 * @access	public
	 * @return	void
	 */
	 function get_shouts($count) {
		
		$this->CI->db->order_by('id', 'desc');
		$this->CI->db->limit($count);
		$this->CI->db->from('shoutbox');
		$q = $this->CI->db->get();
		
		if($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
			    $data[] = $row;
			}
		return $data;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Shout
	 *
	 * Inserts a shout into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function add_shout($data)
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		// Data is valid, insert the data in the database
		return $this->CI->db->insert('shoutbox', $data);
		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Count Shouts
	 *
	 * Count the number of shouts in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_shouts($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('shoutbox')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
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
			APPPATH . 'views/widgets/shoutbox.php'
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
	
/* End of file shoutbox_widget.php */
/* Location: ./clancms/widgets/shoutbox_widget.php */
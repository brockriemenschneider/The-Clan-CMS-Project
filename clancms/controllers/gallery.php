<?php
/**
 * Clan CMS
 *
 * An open source application for gaming clans
 *
 * @package		Clan CMS
 * @author		co[dezyne
 * @copyright	Copyright (c) 2011 - 2012 co[dezyne]
 * @license		http://codezyne.me
 * @link		http://codezyne.me
 * @since		Version 0.1
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Gallery Controller
 *
 * @package			Clan CMS
 * @subpackage	Controllers
 * @category			Controllers
* @author				co[dezyne
 * @link				http://codezyne.me
 */
class Gallery extends CI_Controller {
	
	/**
	 * Constructor
	 *
	 */	
	function __construct()
	{
		// Call the Controller constructor
		parent::__construct();
		
		// Load the Gallery model
		$this->load->model('Gallery_model', 'gallery');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the gallery
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Video Constraints
		$ns = array
		(
		        'content' => 'http://purl.org/rss/1.0/modules/content/',
		        'wfw' => 'http://wellformedweb.org/CommentAPI/',
		        'dc' => 'http://purl.org/dc/elements/1.1/'
		);
		$video = array();
		$blog_url = 'http://gdata.youtube.com/feeds/api/users/bluexephos/uploads';
		$rawFeed = file_get_contents($blog_url);
		$data['sxml'] = new SimpleXmlElement($rawFeed);

		// Display all uploaded images
		$data['images'] = $this->gallery->get_images();
		
		// Retrieve our forms
		$gallery_upload = $this->input->post('upload');
		
		// Check it update article has been posted
		if($gallery_upload)
		{
			// Set form validation rules
			$this->form_validation->set_rules('title', 'title', 'trim|required');
			$this->form_validation->set_rules('userfile', 'file|required');
		
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{
				$this->gallery->add_image();
			}
			
		}

		
		$this->load->view(THEME . 'gallery', $data);
	}
	
	// --------------------------------------------------------------------
	/**
	 * Delete Header
	 *
	 *  Removes header images
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function del_image()
	{
		// Set up the data
		$data = array(
			'id'	=>	$this->uri->segment(3, '')
		);

		// Retrieve the header by file_name
		if(!$image = $this->gallery->get_image($data))
		{
			// Image doesn't exist, alert the administrator
			$this->session->set_flashdata('message', 'The image was not found!');
		
			// Redirect the administrator
			redirect($this->session->userdata('previous'));
		}

		// Delete the header from gallery & thumbs folders
		
		unlink(IMAGES . 'gallery/' .$image->image && IMAGES . 'gallery/thumbs/' . $image->image);
		
		// Sumbit image for deletion
		$this->gallery->delete_image($image->id, $data);
		
		// Alert the administrator
		$this->session->set_flashdata('message', 'The image <span class="bold">' . $image->title . '</span> was successfully deleted!');
				
		// Redirect the administrator
		redirect('gallery');
	
	}	
	

/* End of file gallery.php */
/* Location: ./clancms/controllers/gallery.php */
}
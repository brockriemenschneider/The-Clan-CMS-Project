<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
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
 * Clan CMS Gallery Model
 *
 * @package			Clan CMS
 * @subpackage	Models
 * @category			Controllers
* @author				co[dezyne
 * @link				http://codezyne.me
 */
class Gallery_model extends CI_Model {

	/**
	 * Constructor
	 *
	 */
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
// --------------------------------------------------------------------
	/** Gallery
	 * 
	 *  Multimedia Management
	 *
	 * @access	public
	 * @return	void
	 */
	 function gallery() {

		// Display all Game headers
		$data['games'] = $this->articles->get_images();
		
		//  on submit -> to model
		if ($this->input->post('upload')) {
			$this->articles->add_header();
		}
		
		$this->load->view('gallery', $data);
	 }

	// --------------------------------------------------------------------
	
	/**
	 * Count Images
	 *
	 * Count the number of article images in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_slides($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('gallery')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}	 
	// --------------------------------------------------------------------
	/**
	 * Get Images
	 *
	 * Retrieves image listings from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_images() {
		$q = $this->db
						->order_by('date', 'desc')
						->get('gallery');
		
		if($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
			    $data[] = $row;
			}
		return $data;
		}
	}
	// --------------------------------------------------------------------
	/**
	 * Get Image
	 *
	 * Selects singular image 
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */	
	function get_image($data = array()) {	

		// Check for valid data
		if(empty($data) OR !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->where($data)
						->get('gallery', 1);

		// Check if query row exists
		if($query->row())
		{
			// Query row exists, return query row
			return $query->row();
		}
		else
		{
			// Query row doesn't exist, return FALSE
			return FALSE;
		}
		
	}
	
	// --------------------------------------------------------------------
	/**
	 * Add Image
	 *
	 * Inserts uploaded images into database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function add_image() {
		
		// Image restraints
		$file_config = array(
				'allowed_types'	=>	'jpg|jpeg|png|gif',
				'upload_path'		=>	UPLOAD . 'gallery',
				'max_size'			=>	4096,
				'remove_spaces'	=>	TRUE
			);
			
		//Load the library with restraints and run method, passing the meta data to data array	
		$this->load->library('upload', $file_config);
		
		// Verify file is permissible
		if(!$this->upload->do_upload()) {
			$this->session->set_flashdata('message', 'The file was unsucessfully uploaded');
		} else {
	
			//  Do this to parse data for db and resize()
			$image_data = $this->upload->data();
			
			// resize restraints
			$resize = array(
				'source_image' 		=> 	$image_data['full_path'],
				'new_image' 		=> 	UPLOAD . 'gallery/thumbs',
				'maintain_ratio' 	=> 	FALSE,
				'width'			=>	130,
				'height'			=>	115,
				'master_dim'		=> 	'width'
			);
			
			$this->load->library('image_lib', $resize);
			$this->image_lib->resize();
			
			// Pass info from data to database
			$data = array(
					'title'			=>	$this->input->post('title'),
					'image'		=>	$image_data['file_name'],
					'uploader'		=>	$this->session->userdata('username'),
					'height'		=>	$image_data['image_height'],
					'width'		=>	$image_data['image_width'],
					'size'			=>	$image_data['file_size']
					);
			$this->db->insert('gallery', $data);
			
			
			// Alert the administrator
			$this->session->set_flashdata('message', 'The image <span class="bold">' .$this->input->post('title') . '</span> was successfully uploaded!');
			
			// Redirect to refresh get_headers()
			redirect('gallery');	
			}
		}

// --------------------------------------------------------------------
	/**
	 * Delete Image
	 *
	 * Removes image from database and system
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function delete_image($image_id = 0) {	

		
		// Check to see if we have valid data
		if($image_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if image exists
		if(!$image = $this->get_image(array('id' => $image_id)))
		{
			// Comment doesn't exist, return FALSE
			return FALSE;
		}
		
	// Data is valid, header exists, delete the data from the database 
	return $query = $this->db->delete('gallery', array('id' => $image_id));

	}	 
	
	// --------------------------------------------------------------------
	
	/**
	 * Count Images
	 *
	 * Count the number of images in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_images($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('gallery')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
/* End of file gallery_model.php */
/* Location: ./clancms/models/gallery_model.php */
}
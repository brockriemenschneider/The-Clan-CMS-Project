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
		$data['games'] = $this->gallerys->get_images();
		
		//  on submit -> to model
		if ($this->input->post('upload')) {
			$this->gallerys->add_header();
		}
		
		$this->load->view('gallery', $data);
	 }

	// --------------------------------------------------------------------
	/**
	 * Get Images
	 *
	 * Retrieves image listings from the database
	 *
	 * @access	public
	 * @return	array
	 */
	function get_images() {
		$q = $this->db
						->where('image !=', '')
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
	 * Get Videos
	 *
	 * Retrieves video listings from the database
	 *
	 * @access	public
	 * @return	array
	 */
	function get_videos() {
		$q = $this->db
						->where('video !=', '')
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
	 * Get Gallery
	 *
	 * Selects singular gallery item 
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */	
	function get_gallery_item($data = array()) {	

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
	function add_image()
	{
		
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
		if(!$this->upload->do_upload()) 
		{
			// Alert the user
			$this->session->set_flashdata('gallery', 'The image was unsucessfully uploaded');
		} 
		else 
		{
	
			//  Do this to parse data for db and resize()
			$image_data = $this->upload->data();
			
			// Check if image already exists
			$exists = $this->get_gallery_item(array('image' => $image_data['file_name']));
			
			if($exists)
			{
				// Image exists, Alert the user
				$this->session->set_flashdata('gallery', 'The image <span class="bold">' .$this->input->post('title') . '</span> already exists!');
				
				// Redirect to refresh get_headers()
				redirect('gallery');
			}
			else 
			{
				// Check if file is image
				if(!$image_data['is_image'] == 1){
					
					return false;
					
				} 
				else 
				{
					// Check if we need to scale the image
					if($image_data['image_width'] < 700)
					{
						// Does not need scaling
						$scale = array(
							'source_image' 		=> 	$image_data['full_path'],
							'new_image' 		=> 	UPLOAD . 'gallery/thumbs',
							'quality'			=>	'100%'
						);
						
						$this->load->library('image_lib', $scale);
						$this->image_lib->resize();
						
					} 
					else 
					{
					
						// Scaled image resize restraints
						$scale = array(
							'source_image' 		=> 	$image_data['full_path'],
							'new_image' 		=> 	UPLOAD . 'gallery/thumbs',
							'maintain_ratio' 	=> 	TRUE,
							'width'			=>	710,
							'height'			=>	525,
							'master_dim'		=> 	'width',
							'quality'			=>	'100%',
						);
						
						$this->load->library('image_lib', $scale);
						$this->image_lib->resize();
					
					}
					
					// Setup Image data
					$data = array(
							'title'			=>	$this->input->post('title'),
							'image'		=>	$image_data['file_name'],
							'uploader'		=>	$this->session->userdata('username'),
							'height'		=>	$image_data['image_height'],
							'width'		=>	$image_data['image_width'],
							'size'			=>	$image_data['file_size'],
							'gallery_slug'	=>	$image_data['raw_name']
							);
					
				
					// Image is new, upload
					$this->db->insert('gallery', $data);
					
					// Alert the user
					$this->session->set_flashdata('gallery', 'The image <span class="bold">' .$this->input->post('title') . '</span> was successfully uploaded!');
					
					// Redirect to refresh get_headers()
					redirect('gallery');
			
					}
				}
			}
		}
	
	// --------------------------------------------------------------------
	/**
	 * Add Video
	 *
	 * Catalogues youtube video into database
	 *
	 * @access	public
	 * @param	string
	 * @return	array
	 */
	 function add_video($video)
	 {
	 	/// Check to see if we have valid data
		if(empty($video))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		$this->db->insert('gallery', $video);
		
		// Alert the user
		$this->session->set_flashdata('gallery', 'The video <span class="bold">' .$this->input->post('title') . '</span> was successfully shared!');
		
		// Redirect to refresh get_headers()
		redirect('gallery');
		
		
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
	function delete_image($image_id = 0) 
	{	
		// Check to see if we have valid data
		if($image_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if image exists
		if(!$image = $this->get_gallery_item(array('gallery_id' => $image_id)))
		{
			// Comment doesn't exist, return FALSE
			return FALSE;
		}
		
		
		
	// Data is valid, image exists, delete the data from the database 
	return $query = $this->db->delete('gallery', array('gallery_id' => $image_id));

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
						->where('image !=', '')
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	
	// --------------------------------------------------------------------
	
	/**
	 * Count Videos
	 *
	 * Count the number of videos in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_videos($data = array())
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
						->where('video !=', '')
						->count_all_results();
						
		// Return query
		return $query;
	}
	// -----------------------------------------------------------------------
	
	/**
	 *
	 * Edit Description
	 *
	 *@access		private
	 *@param		array
	 *@return		array
	 */
	 function edit_desc($data=array(), $gallery_id)
	 {
	 	// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
	 	$this->db->where('gallery_id', $gallery_id)
	 			->update('gallery', $data);
	 	
	 }
	 
	// --------------------------------------------------------------------
	
	/**
	 * Get Comment
	 *
	 * Retrieves a gallery comment from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_comment($data = array())
	{	
		// Check for valid data
		if(empty($data) OR !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->where($data)
						->get('gallery_comments', 1);
		
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
	 * Get Comments
	 *
	 * Retrieves all gallery comments from the database
	 *
	 * @access	public
	 * @param	int
	 * @param	int
	 * @param	array
	 * @return	array
	 */
	function get_comments($limit = 0, $offset = 0, $data = array())
	{
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Check if limit exists
		if($limit == 0)
		{
			// Limit doesn't exist, assign limit
			$limit = '';
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->order_by('comment_id', 'desc')
						->limit($limit, $offset)
						->where($data)
						->get('gallery_comments');
		
		// Check if query result exists
		if($query->result())
		{
			// Query result exists, return query result
			return $query->result();
		}
		else
		{
			// Query result doesn't exist, return FALSE
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Count Comments
	 *
	 * Count the number of gallery comments in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_comments($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('gallery_comments')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Comment
	 *
	 * Inserts a gallery comment into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_comment($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('gallery_comments', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Comment
	 *
	 * Updates a gallery comment in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_comment($comment_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($comment_id == '0' OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if comment exists
		if(!$comment = $this->get_comment(array('comment_id' => $comment_id)))
		{
			// Comment doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, comment exists, update the data in the database
		return $this->db->update('gallery_comments', $data, array('comment_id' => $comment_id));
	}

	// --------------------------------------------------------------------
	/**
	 * Delete Comment
	 *
	 * Deletes a gallery comment from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_comment($comment_id = 0)
	{	
		// Check to see if we have valid data
		if($comment_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if comment exists
		if(!$comment = $this->get_comment(array('comment_id' => $comment_id)))
		{
			// Comment doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, comment exists, delete the data from the database
		return $this->db->delete('gallery_comments', array('comment_id' => $comment_id));
	}
	
	// --------------------------------------------------------------------
	/**
	 * User Images
	 *
	 * Retrieves a user's image listings from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function user_media($user) {
		$q = $this->db->where('uploader', $user)
					->order_by('date', 'desc')
					->get('gallery');
		
		if($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
			    $data[] = $row;
			}
		return $data;
		}
	}
/* End of file gallery_model.php */
/* Location: ./clancms/models/gallery_model.php */
}
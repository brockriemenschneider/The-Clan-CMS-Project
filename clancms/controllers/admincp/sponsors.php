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
 * Clan CMS Admin CP Sponsors Controller
 *
 * @package		Clan CMS
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Sponsors extends Controller {
	
	/**
	 * Constructor
	 *
	 */	
	function Sponsors()
	{
		// Call the Controller constructor
		parent::Controller();
		
		// Check to see if user is an administrator
		if(!$this->user->is_administrator())
		{
			// User is not an administrator, redirect the user
			redirect('account/login');
		}
		
		// Check if the administrator has permission
		if(!$this->user->has_permission('sponsors'))
		{
			// Administrator doesn't have permission, show error & exit
			$error =& load_class('Exceptions');
			echo $error->show_error('Access Denied!', 'You do not have permission to view this page!');
			exit;
		}
		
		// Load the Sponsors model
		$this->load->model('Sponsors_model', 'sponsors');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the Admin CP Sponsors
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Retrieve all sponsors
		$sponsors = $this->sponsors->get_sponsors();
		
		// Create a reference to sponsors
		$this->data->sponsors =& $sponsors;
		
		// Load the admincp sponsors view
		$this->load->view(ADMINCP . 'sponsors', $this->data);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Add
	 *
	 * Add's a sponsor
	 *
	 * @access	public
	 * @return	void
	 */
	function add()
	{
		// Retrieve the forms
		$add_sponsor = $this->input->post('add_sponsor');
		
		// Check it add sponsor has been posted
		if($add_sponsor)
		{
			// Set form validation rules
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('link', 'Link', 'trim|prep_url');
			$this->form_validation->set_rules('image', 'Image', 'trim|callback__check_image');
			$this->form_validation->set_rules('description', 'Description', 'trim');
			$this->form_validation->set_rules('priority', 'Priority', 'trim|required|integer');
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{	
				// Set up upload config
				$config['upload_path'] = UPLOAD . 'sponsors';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['encrypt_name'] = TRUE;
				
				// Load the upload library
				$this->load->library('upload', $config);
			
		
				// Check to see if the image was uploaded
				if(!$this->upload->do_upload('image'))
				{
					// Image wasn't uploaded, display errors
					$upload->errors = $this->upload->display_errors();
				}
				else
				{
					// Upload was successful, retrieve the data
					$data = array('upload_data' => $this->upload->data());
	
					// Set up the data
					$data = array (
						'sponsor_title'			=> $this->input->post('title'),
						'sponsor_link'			=> $this->input->post('link'),
						'sponsor_description'	=> $this->input->post('description'),
						'sponsor_image'			=> $data['upload_data']['file_name'],
						'sponsor_priority'		=> $this->input->post('priority')
					);
			
					// Insert the sponsor into the database
					$this->sponsors->insert_sponsor($data);
					
					// Retrieve the sponsor id
					$sponsor_id = $this->db->insert_id();
					
					// Alert the adminstrator
					$this->session->set_flashdata('message', 'The sponsor was successfully added!');
				
					// Redirect the adminstrator
					redirect(ADMINCP . 'sponsors/edit/' . $sponsor_id);
				}
			}
		}
		
		// Create a reference to upload
		$this->data->upload =& $upload;
		
		// Load the admincp sponsors add view
		$this->load->view(ADMINCP . 'sponsors_add', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Edit
	 *
	 * Edit's a sponsor
	 *
	 * @access	public
	 * @return	void
	 */
	function edit()
	{
		// Set up the data
		$data = array(
			'sponsor_id'	=>	$this->uri->segment(4)
		);
		
		// Retrieve the sponsor
		if(!$sponsor = $this->sponsors->get_sponsor($data))
		{
			// Sponsor doesn't exist, redirect the administrator
			redirect(ADMINCP . 'sponsors');
		}
		
		// Retrieve the forms
		$update_sponsor = $this->input->post('update_sponsor');
		
		// Check it update sponsor has been posted
		if($update_sponsor)
		{
			// Set form validation rules
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('link', 'Link', 'trim|prep_url');
			
			// Check if the sponsor has an image
			if($sponsor->sponsor_image)
			{
				// Sponsor has an image, don't require it
				$this->form_validation->set_rules('image', 'Image', 'trim');
			}
			else
			{
				// Sponsor doesn't have an image, require it
				$this->form_validation->set_rules('image', 'Image', 'trim|callback__check_image');
			}
			
			// Set form validation rules
			$this->form_validation->set_rules('description', 'Description', 'trim');
			$this->form_validation->set_rules('priority', 'Priority', 'trim|required|integer');
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{
				// Check if image exists
				if($_FILES['image']['name'])
				{
					// Set up upload config
					$config['upload_path'] = UPLOAD . 'sponsors';
					$config['allowed_types'] = 'gif|jpg|png|bmp';
					$config['encrypt_name'] = TRUE;
				
					// Image exists, load the upload library
					$this->load->library('upload', $config);
			
					// Check to see if the image was uploaded
					if(!$this->upload->do_upload('image'))
					{
						// Image wasn't uploaded, display errors
						$upload->errors = $this->upload->display_errors();
					}
					else
					{
						// Upload was successful, retrieve the data
						$data = array('upload_data' => $this->upload->data());
					}
				
					// Change the image
					$image = $data['upload_data']['file_name'];

					// Check if image exists
					if(file_exists(UPLOAD . 'sponsors/' . $sponsor->sponsor_image))
					{
						// Image eixsts, remove the image
						unlink(UPLOAD . 'sponsors/' . $sponsor->sponsor_image);
					}
				}
				else
				{
					// Keep image the same
					$image = $sponsor->sponsor_image;
				}
			
				// Set up the data
				$data = array (
					'sponsor_title'			=> $this->input->post('title'),
					'sponsor_link'			=> $this->input->post('link'),
					'sponsor_description'	=> $this->input->post('description'),
					'sponsor_image'			=> $image,
					'sponsor_priority'		=> $this->input->post('priority')
				);
			
				// Update the sponsor in the database
				$this->sponsors->update_sponsor($sponsor->sponsor_id, $data);
				
				// Alert the adminstrator
				$this->session->set_flashdata('message', 'The sponsor was successfully updated!');
				
				// Redirect the adminstrator
				redirect(ADMINCP . 'sponsors/edit/' . $sponsor->sponsor_id);
			}
		}
		
		// Create a reference to sponsor & upload
		$this->data->sponsor =& $sponsor;
		$this->data->upload =& $upload;
		
		// Load the admincp sponsors edit view
		$this->load->view(ADMINCP . 'sponsors_edit', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete
	 *
	 * Delete's a sponsor
	 *
	 * @access	public
	 * @return	void
	 */
	function delete()
	{
		// Set up the data
		$data = array(
			'sponsor_id'	=>	$this->uri->segment(4)
		);
		
		// Retrieve the sponsor
		if(!$sponsor = $this->sponsors->get_sponsor($data))
		{
			// Sponsor doesn't exist, redirect the administrator
			redirect(ADMINCP . 'sponsors');
		}
		
		// Check if image exists
		if(file_exists(UPLOAD . 'sponsors/' . $sponsor->sponsor_image))
		{
			// Image eixsts, remove the image
			unlink(UPLOAD . 'sponsors/' . $sponsor->sponsor_image);
		}
				
		// Delete the sponsor from the database
		$this->sponsors->delete_sponsor($sponsor->sponsor_id);
				
		// Alert the adminstrator
		$this->session->set_flashdata('message', 'The sponsor was successfully deleted!');
				
		// Redirect the adminstrator
		redirect(ADMINCP . 'sponsors');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Order
	 *
	 * Update's the order of the sponsors
	 *
	 * @access	public
	 * @return	void
	 */
	function order()
	{	
		// Retrieve our forms
		$sponsors = $this->input->post('sponsor');
		
		// Loop through each sponsor
		foreach($sponsors as $sponsor_priority => $sponsor_id)
		{
			// Set up the data
			$data = array(
				'sponsor_priority'	=> $sponsor_priority
			);
	
			// Update the sponsors in the database
			$this->sponsors->update_sponsor($sponsor_id, $data);
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Check Image
	 *
	 * Check's to see if a image is being uploaded
	 *
	 * @access	private
	 * @return	bool
	 */
	function _check_image()
	{
		// Check if there is an image
		if($_FILES['image']['name'])
		{
			// There is an image, return TRUE
			return TRUE;
		}
		else
		{
			// There is not a image, return FALSE
			$this->form_validation->set_message('_check_image', 'The image field is required.');
			return FALSE;
		}
	}
	
}

/* End of file sponsors.php */
/* Location: ./clancms/controllers/admincp/sponsors.php */
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
 * @since		Version 0.6.1
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Admin CP Slider Controller
 *
 * @package		Clan CMS
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Slider extends CI_Controller {
	
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
			// User is not an administrator, redirect the user
			redirect('account/login');
		}
		
		// Check if the administrator has permission
		if(!$this->user->has_permission('slider'))
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
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the Admin CP News Slides
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Retrieve all slides
		$slides = $this->articles->get_slides();
		
		// Check if slides exist
		if($slides)
		{
			// Slides exist, loop through each slide
			foreach($slides as $slide)
			{
				// Retrieve the slide article
				if($article = $this->articles->get_article(array('article_id' => $slide->article_id)))
				{
					// Retrieve the squad
					$squad = $this->squads->get_squad(array('squad_id' => $article->squad_id));
					
					// Check if squad exists
					if($squad)
					{
						// Squad exists, assign article squad
						$article->squad = $squad->squad_title;
					}
					else
					{
						// Squad doesn't exist, assign article squad
						$article->squad = '';
					}
				
					// Assign article information
					$slide->slider_title = $article->squad . $article->article_title;
					$slide->slider_link = 'articles/view/' . $article->article_slug;
				}
			}
		}
			
		// Create a reference to slides
		$this->data->slides =& $slides;
		
		// Load the admincp slides view
		$this->load->view(ADMINCP . 'slides', $this->data);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Add
	 *
	 * Add's a slide
	 *
	 * @access	public
	 * @return	void
	 */
	function add()
	{
		// Retrieve the forms
		$add_slide = $this->input->post('add_slide');
		
		// Check it add slide has been posted
		if($add_slide)
		{
			// Set form validation rules
			$this->form_validation->set_rules('type', 'Type', 'trim|required');
			
			// Check the slide type
			if((bool) !$this->input->post('type'))
			{
				// Set form validation rules
				$this->form_validation->set_rules('title', 'Title', 'trim|required');
				$this->form_validation->set_rules('link', 'Link', 'trim|prep_url');
			}
			else
			{
				// Set form validation rules
				$this->form_validation->set_rules('article', 'Article', 'trim|required');
			}
			
			// Set form validation rules
			$this->form_validation->set_rules('content', 'Content', 'trim');
			$this->form_validation->set_rules('image', 'Image', 'trim|callback__check_image');
			$this->form_validation->set_rules('priority', 'Priority', 'trim|required|integer');
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{	
				// Set up upload config
				$config['upload_path'] = UPLOAD . 'slider/slides/';
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
					
					// Retrieve the file name
					$file_name = $data['upload_data']['file_name'];
					
					// Load the image library
					$this->load->library('image_lib');
					
					// Assign new image properties
					$new_width = $this->ClanCMS->get_setting('slide_width');
					$new_height = $this->ClanCMS->get_setting('slide_height');
					
					// Set up image config
					$config['image_library'] = 'gd2';
					$config['source_image']	= UPLOAD . 'slider/slides/' . $file_name;
					$config['maintain_ratio'] = FALSE;
					$config['quality'] = '100%';
					$config['width'] = $new_width;
					$config['height'] = $new_height;
					$config['new_image'] = UPLOAD . 'slider/slides/' . $file_name;

					// Initialize the image library
					$this->image_lib->initialize($config); 

					// Resize the image
					$this->image_lib->resize();
					
					// Clear the image config
					$this->image_lib->clear();
					
					// Assign new image properties
					$new_width = $this->ClanCMS->get_setting('slide_preview_width');
					$new_height = $this->ClanCMS->get_setting('slide_preview_height');
					
					// Set up image config
					$config['image_library'] = 'gd2';
					$config['source_image']	= UPLOAD . 'slider/slides/' . $file_name;
					$config['maintain_ratio'] = FALSE;
					$config['quality'] = '100%';
					$config['width'] = $new_width;
					$config['height'] = $new_height;
					$config['new_image'] = UPLOAD . 'slider/previews/' . $file_name;

					// Initialize the image library
					$this->image_lib->initialize($config); 

					// Resize the image
					$this->image_lib->resize();
					
					// Check the slide type
					if((bool) !$this->input->post('type'))
					{
						// Set up the data
						$data = array (
							'slider_title'			=> $this->input->post('title'),
							'slider_content'		=> $this->input->post('content'),
							'slider_image'			=> $file_name,
							'slider_link'			=> $this->input->post('link'),
							'slider_priority'		=> $this->input->post('priority')
						);
					}
					else
					{
						// Set up the data
						$data = array (
							'article_id'			=> $this->input->post('article'),
							'slider_content'		=> $this->input->post('content'),
							'slider_image'			=> $file_name,
							'slider_priority'		=> $this->input->post('priority')
						);
					}
			
					// Insert the article slide into the database
					$this->articles->insert_slide($data);
					
					// Retrieve the slide id
					$slide_id = $this->db->insert_id();
					
					// Alert the adminstrator
					$this->session->set_flashdata('message', 'The slide was successfully added!');
				
					// Redirect the adminstrator
					redirect(ADMINCP . 'slider/edit/' . $slide_id);
				}
			}
		}
		
		// Retrieve the articles
		$articles = $this->articles->get_articles('', '', array('article_status' => 1));
		
		// Create a reference to upload & articles
		$this->data->upload =& $upload;
		$this->data->articles =& $articles;
		
		// Load the admincp slides add view
		$this->load->view(ADMINCP . 'slides_add', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Edit
	 *
	 * Edit's a slide
	 *
	 * @access	public
	 * @return	void
	 */
	function edit()
	{
		// Set up the data
		$data = array(
			'slider_id'	=>	$this->uri->segment(4)
		);
		
		// Retrieve the slide
		if(!$slide = $this->articles->get_slide($data))
		{
			// Slide doesn't exist, redirect the administrator
			redirect(ADMINCP . 'slider');
		}
			
		// Retrieve the slide article
		if($article = $this->articles->get_article(array('article_id' => $slide->article_id)))
		{
			// Retrieve the squad
			$squad = $this->squads->get_squad(array('squad_id' => $article->squad_id));
					
			// Check if squad exists
			if($squad)
			{
				// Squad exists, assign article squad
				$article->squad = $squad->squad_title;
			}
			else
			{
				// Squad doesn't exist, assign article squad
				$article->squad = '';
			}
				
			// Assign article information
			$slide->slider_title = $article->squad . $article->article_title;
		}
		
		// Retrieve the forms
		$update_slide = $this->input->post('update_slide');
		
		// Check it update slide has been posted
		if($update_slide)
		{
			// Set form validation rules
			$this->form_validation->set_rules('type', 'type', 'trim|required');
			
			// Check the slide type
			if((bool) !$this->input->post('type'))
			{
				// Set form validation rules
				$this->form_validation->set_rules('title', 'Title', 'trim|required');
				$this->form_validation->set_rules('link', 'Link', 'trim|prep_url');
			}
			else
			{
				// Set form validation rules
				$this->form_validation->set_rules('article', 'Article', 'trim|required');
			}
			
			// Set form validation rules
			$this->form_validation->set_rules('content', 'Content', 'trim');
			
			// Check if the slide has an image
			if($slide->slider_image)
			{
				// Slide has an image, don't require it
				$this->form_validation->set_rules('image', 'Image', 'trim');
			}
			else
			{
				// Slide doesn't have an image, require it
				$this->form_validation->set_rules('image', 'Image', 'trim|callback__check_image');
			}
			
			// Set form validation rules
			$this->form_validation->set_rules('priority', 'Priority', 'trim|required|integer');
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{
				// Check if image exists
				if($_FILES['image']['name'])
				{
					// Set up upload config
					$config['upload_path'] = UPLOAD . 'slider/slides/';
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
						
						// Retrieve the file name
						$file_name = $data['upload_data']['file_name'];
						
						// Load the image library
						$this->load->library('image_lib');
					
						// Assign new image properties
						$new_width = $this->ClanCMS->get_setting('slide_width');
						$new_height = $this->ClanCMS->get_setting('slide_height');
					
						// Set up image config
						$config['image_library'] = 'gd2';
						$config['source_image']	= UPLOAD . 'slider/slides/' . $file_name;
						$config['maintain_ratio'] = FALSE;
						$config['quality'] = '100%';
						$config['width'] = $new_width;
						$config['height'] = $new_height;
						$config['new_image'] = UPLOAD . 'slider/slides/' . $file_name;

						// Initialize the image library
						$this->image_lib->initialize($config); 

						// Resize the image
						$this->image_lib->resize();
						
						// Clear the image config
						$this->image_lib->clear();
						
						// Assign new image properties
						$new_width = $this->ClanCMS->get_setting('slide_preview_width');
						$new_height = $this->ClanCMS->get_setting('slide_preview_height');
						
						// Set up image config
						$config['image_library'] = 'gd2';
						$config['source_image']	= UPLOAD . 'slider/slides/' . $file_name;
						$config['maintain_ratio'] = FALSE;
						$config['quality'] = '100%';
						$config['width'] = $new_width;
						$config['height'] = $new_height;
						$config['new_image'] = UPLOAD . 'slider/previews/' . $file_name;

						// Initialize the image library
						$this->image_lib->initialize($config); 

						// Resize the image
						$this->image_lib->resize();
					}
				
					// Change the image
					$image = $file_name;

					// Check if image exists
					if(file_exists(UPLOAD . 'slider/slides/' . $slide->slider_image))
					{
						// Image eixsts, remove the image
						unlink(UPLOAD . 'slider/slides/' . $slide->slider_image);
					}
					
					// Check if preview image exists
					if(file_exists(UPLOAD . 'slider/previews/' . $slide->slider_image))
					{
						// Image eixsts, remove the image
						unlink(UPLOAD . 'slider/previews/' . $slide->slider_image);
					}
				}
				else
				{
					// Keep image the same
					$image = $slide->slider_image;
				}
			
				// Check the slide type
				if((bool) !$this->input->post('type'))
				{
					// Set up the data
					$data = array (
						'article_id'			=> 0,
						'slider_title'			=> $this->input->post('title'),
						'slider_content'		=> $this->input->post('content'),
						'slider_image'			=> $image,
						'slider_link'			=> $this->input->post('link'),
						'slider_priority'		=> $this->input->post('priority')
					);
				}
				else
				{
					// Set up the data
					$data = array (
						'article_id'			=> $this->input->post('article'),
						'slider_content'		=> $this->input->post('content'),
						'slider_image'			=> $image,
						'slider_link'			=> '',
						'slider_priority'		=> $this->input->post('priority')
					);
				}
			
				// Update the article slide in the database
				$this->articles->update_slide($slide->slider_id, $data);
				
				// Alert the adminstrator
				$this->session->set_flashdata('message', 'The slide was successfully updated!');
				
				// Redirect the adminstrator
				redirect(ADMINCP . 'slider/edit/' . $slide->slider_id);
			}
		}
		
		// Retrieve the articles
		$articles = $this->articles->get_articles('', '', array('article_status' => 1));
		
		// Create a reference to slide, upload & articles
		$this->data->slide =& $slide;
		$this->data->upload =& $upload;
		$this->data->articles =& $articles;
		
		// Load the admincp slider edit view
		$this->load->view(ADMINCP . 'slides_edit', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete
	 *
	 * Delete's a slide
	 *
	 * @access	public
	 * @return	void
	 */
	function delete()
	{
		// Set up the data
		$data = array(
			'slider_id'	=>	$this->uri->segment(4)
		);
		
		// Retrieve the article slide
		if(!$slide = $this->articles->get_slide($data))
		{
			// Slide doesn't exist, redirect the administrator
			redirect(ADMINCP . 'slider');
		}
		
		// Check if image exists
		if(file_exists(UPLOAD . 'slider/slides/' . $slide->slider_image))
		{
			// Image eixsts, remove the image
			unlink(UPLOAD . 'slider/slides/' . $slide->slider_image);
		}
		
		// Check if preview image exists
		if(file_exists(UPLOAD . 'slider/previews/' . $slide->slider_image))
		{
			// Image eixsts, remove the image
			unlink(UPLOAD . 'slider/previews/' . $slide->slider_image);
		}
		
		// Delete the article slide from the database
		$this->articles->delete_slide($slide->slider_id);
				
		// Alert the adminstrator
		$this->session->set_flashdata('message', 'The slide was successfully deleted!');
				
		// Redirect the adminstrator
		redirect(ADMINCP . 'slider');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Order
	 *
	 * Update's the order of the slider
	 *
	 * @access	public
	 * @return	void
	 */
	function order()
	{	
		// Retrieve our forms
		$slider = $this->input->post('slides');
		
		// Loop through each slide
		foreach($slider as $slider_priority => $slider_id)
		{
			// Set up the data
			$data = array(
				'slider_priority'	=> $slider_priority
			);
	
			// Update the article slide in the database
			$this->articles->update_slide($slider_id, $data);
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

/* End of file slider.php */
/* Location: ./clancms/controllers/admincp/slider.php */
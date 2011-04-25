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
 * @since		Version 0.6.0
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Admin CP Widgets Controller
 *
 * @package		Clan CMS
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Widgets extends CI_Controller {
	
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
		if(!$this->user->has_permission('widgets'))
		{
			// Administrator doesn't have permission, show error & exit
			$error =& load_class('Exceptions', 'core');
			echo $error->show_error('Access Denied!', 'You do not have permission to view this page!');
			exit;
		}
		
		// Load the inflector helper
		$this->load->helper('inflector');
		
		// Load the Widgets model
		$this->load->model('Widgets_model', 'widgets');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the Admin CP Widgets
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Retrieve all widget areas
		if($areas = $this->widgets->get_areas())
		{
			// Loop through each area
			foreach($areas as $area)
			{
				// Retrieve all widgets for this area
				if($area->widgets = $this->widgets->get_widgets(array('area_id' => $area->area_id)))
				{
					// Loop through each widget
					foreach($area->widgets as $widget)
					{
						// Read the widget
						$widget->type = $this->widgets->read_widget($widget->widget_slug)->title;
					}
				}
			}
		}
		
		// Assign updates
		$updates = array();
		
		// Retrieve all installed widgets
		if($widgets = $this->widgets->scan_widgets())
		{
			// Loop throug heach widget
			foreach($widgets as $widget)
			{
				// Check for updates for this widget
				$update = $this->widgets->check_updates($widget->slug);
				
				// Check if update is valid
				if($update)
				{
					// Assign the update to the updates array
					$updates[] = $update;
				}
			}
		}
		
		// Create a reference to areas, widgets & updates
		$this->data->areas =& $areas;
		$this->data->widgets =& $widgets;
		$this->data->updates =& $updates;
		
		// Load the admincp widgets view
		$this->load->view(ADMINCP . 'widgets', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Browse
	 *
	 * Browse all widgets
	 *
	 * @access	public
	 * @return	void
	 */
	function browse()
	{
		// Load the xmlrpc library
		$this->load->library('xmlrpc');
		
		// Assign server and the method to be requested
		$this->xmlrpc->server('http://www.xcelgaming.com/widgets', 80);
		$this->xmlrpc->method('browse');
		
		// Retrieve the page
		$page = $this->uri->segment(5, '');
	
		// Check if page exists
		if($page == '')
		{
			// Page doesn't exist, assign page
			$page = 1;
		}
		
		$request = array(
			array(
				'page' => array($page, 'int')
			), 'struct');
		
		// Request the response
		$this->xmlrpc->request(array($request, 'array'));
		
		// Check if the xml rpc request failed
		if (!$this->xmlrpc->send_request() && $this->session->flashdata('message') == '')
		{
			// Xml request failed, alert the adminstrator
			$this->session->set_flashdata('message', 'Could not retrieve any widgets! Please try again later.');
			
			// Redirect the administrator
			redirect(ADMINCP . 'widgets/browse');
		}
		else
		{
			$response = $this->xmlrpc->display_response();
			$settings = $response[0];
			array_shift($response);
			$widgets = $response;
			
			//Set up the variables
			$per_page = $settings['per_page'];
			$total_results = $settings['total_results'];
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
			
			// Create a reference to widgets & pages
			$this->data->widgets =& $widgets;
			$this->data->pages =& $pages;
				
		}
		
		// Load the admincp widgets browse view
		$this->load->view(ADMINCP . 'widgets_browse', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * View
	 *
	 * View a widget
	 *
	 * @access	public
	 * @return	void
	 */
	function view()
	{
		// Load the xmlrpc library
		$this->load->library('xmlrpc');
		
		// Assign server and the method to be requested
		$this->xmlrpc->server('http://www.xcelgaming.com/widgets', 80);
		$this->xmlrpc->method('view');
		
		// Retrieve the page
		$page = $this->uri->segment(7, '');
	
		// Check if page exists
		if($page == '')
		{
			// Page doesn't exist, assign page
			$page = 1;
		}
		
		// Assign the request
		$request = array(
			array(
				'widget_slug' => array($this->uri->segment(4, ''), 'string'),
				'page' => array($page, 'int')
			), 'struct');
		
		// Request the response
		$this->xmlrpc->request(array($request, 'array'));
		
		// Check if the xml rpc request failed
		if (!$this->xmlrpc->send_request() && $this->session->flashdata('message') == '')
		{
			// Xml request failed, alert the adminstrator
			$this->session->set_flashdata('message', 'Could not retrieve the widget! Please try again later.');
			
			// Redirect the administrator
			redirect(ADMINCP . 'widgets/browse');
		}
		else
		{
			// Retrieve the response
			$widget = $this->xmlrpc->display_response();
			
			//Set up the variables
			$per_page = $widget[0]['widget']['per_page'];
			$total_results = $widget[0]['widget']['total_results'];
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
				
			// Check if the widget has updates
			$update = $this->widgets->check_updates($widget[0]['widget']['widget_slug']);
			
			// Create a reference to widget, screenshots, changelogs, faqs, update & pages
			$this->data->widget =& $widget[0]['widget'];
			$this->data->screenshots =& $widget[1]['screenshots'];
			$this->data->changelogs =& $widget[2]['changelogs'];
			$this->data->faqs =& $widget[3]['faqs'];
			$this->data->reviews =& $widget[4]['reviews'];
			$this->data->update =& $update;
			$this->data->pages =& $pages;
		}
		
		// Load the admincp widgets view view
		$this->load->view(ADMINCP . 'widgets_view', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Install
	 *
	 * Install's a widget
	 *
	 * @access	public
	 * @return	void
	 */
	function install()
	{
		// Load the xmlrpc library
		$this->load->library('xmlrpc');
		
		// Assign server and the method to be requested
		$this->xmlrpc->server('http://www.xcelgaming.com/widgets', 80);
		$this->xmlrpc->method('download');
		
		// Assign the request
		$request = array(
			array(
				'widget_slug' => array($this->uri->segment(4, ''), 'string')
			), 'struct');
		
		// Request the response
		$this->xmlrpc->request(array($request, 'array'));
		
		// Check if the xml rpc request failed
		if (!$this->xmlrpc->send_request() && $this->session->flashdata('message') == '')
		{
			// Xml request failed, alert the adminstrator
			$this->session->set_flashdata('message', 'Could not download the widget! Please try again later.');
			
			// Redirect the administrator
			redirect(ADMINCP . 'widgets/browse');
		}
		else
		{
			// Retrieve the response
			$widget = $this->xmlrpc->display_response();
			
			// Assign widget to the widget
			$widget = $widget[0]['widget'];
			
			// Check if the widget is already installed
			if($this->widgets->is_installed($widget['widget_slug']))
			{
				// Alert the adminstrator
				$this->session->set_flashdata('message', 'You have already installed this widget!');
			
				// Redirect the administrator
				redirect(ADMINCP . 'widgets/browse');
			}
			
			// Download the widget
			if(copy('http://www.xcelgaming.com/customize/widgets/download/' . $widget['download_file'], $widget['download_file']))
			{
				// Load the unzip library
				$this->load->library('unzip');
		
				// Install the widget
				$this->unzip->extract($widget['download_file']);
			
				// Delete the install package
				unlink($widget['download_file']);
			
				// The widget has been installed, alert the adminstrator
				$this->session->set_flashdata('message', 'The widget has been installed!');
			
				// Redirect the administrator
				redirect(ADMINCP . 'widgets');
			}
			else
			{
				// The widget was not downloaded, alert the adminstrator
				$this->session->set_flashdata('message', 'Could not download the widget! Please try again later.');
			
				// Redirect the administrator
				redirect(ADMINCP . 'widgets');
			}
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Update
	 *
	 * Update's a widget
	 *
	 * @access	public
	 * @return	void
	 */
	function update()
	{
		// Load the xmlrpc library
		$this->load->library('xmlrpc');
		
		// Assign server and the method to be requested
		$this->xmlrpc->server('http://www.xcelgaming.com/widgets', 80);
		$this->xmlrpc->method('download');
		
		// Assign the request
		$request = array(
			array(
				'widget_slug' => array($this->uri->segment(4, ''), 'string')
			), 'struct');
		
		// Request the response
		$this->xmlrpc->request(array($request, 'array'));
		
		// Check if the xml rpc request failed
		if (!$this->xmlrpc->send_request() && $this->session->flashdata('message') == '')
		{
			// Xml request failed, alert the adminstrator
			$this->session->set_flashdata('message', 'Could not download the widget! Please try again later.');
			
			// Redirect the administrator
			redirect(ADMINCP . 'widgets/browse');
		}
		else
		{
			// Retrieve the response
			$widget = $this->xmlrpc->display_response();
			
			// Assign widget to the widget
			$widget = $widget[0]['widget'];
			
			// Download the widget
			copy('http://www.xcelgaming.com/customize/widgets/download/' . $widget['download_file'], $widget['download_file']);
			
			// Load the unzip library
			$this->load->library('unzip');
		
			// Install the widget
			$this->unzip->extract($widget['download_file']);
			
			// Delete the install package
			unlink($widget['download_file']);
			
			// The widget has been installed, alert the adminstrator
			$this->session->set_flashdata('message', 'The widget has been updated!');
			
			// Redirect the administrator
			redirect(ADMINCP . 'widgets');
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Add
	 *
	 * Add's a widget
	 *
	 * @access	public
	 * @return	void
	 */
	function add()
	{
		// Retrieve the widget
		if(!$widget = $this->widgets->read_widget($this->uri->segment(4)))
		{
			// Widget doesn't exist, redirect the administrator
			redirect(ADMINCP . 'widgets');
		}
		
		// Check if widget settings is defined
		if(empty($widget->settings))
		{
			// Assign widget settings
			$widget->settings = array();
		}
		
		// Retrieve the forms
		$add_widget = $this->input->post('add_widget');
		
		// Check it add widget has been posted
		if($add_widget)
		{
			// Set form validation rules
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('area', 'Widget Area', 'trim|required');
			$this->form_validation->set_rules('priority', 'Priority', 'trim|required|integer');
			
			//Check if settings exist
			if($widget->settings)
			{
				// Loop through each setting
				foreach($widget->settings as $setting)
				{
					$this->form_validation->set_rules('setting[' . $setting['slug'] . ']', $setting['title'], $setting['rules']);
				}
			}
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{	
				// Set up the data
				$data = array (
					'area_id'			=> $this->input->post('area'),
					'widget_title'		=> $this->input->post('title'),
					'widget_slug'		=> $widget->slug,
					'widget_settings'	=> serialize($this->input->post('setting')),
					'widget_priority'	=> $this->input->post('priority')
				);
			
				// Insert the widget into the database
				$this->widgets->insert_widget($data);
					
				// Retrieve the widget id
				$widget_id = $this->db->insert_id();
					
				// Alert the adminstrator
				$this->session->set_flashdata('message', 'The widget was successfully added!');
				
				// Redirect the adminstrator
				redirect(ADMINCP . 'widgets/edit/' . $widget_id);
			}
		}
		
		// Retrieve all widget areas
		$areas = $this->widgets->get_areas();
		
		// Create a reference to widget & areas
		$this->data->widget =& $widget;
		$this->data->areas =& $areas;
		
		// Load the admincp widgets add view
		$this->load->view(ADMINCP . 'widgets_add', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Edit
	 *
	 * Edit's a widget
	 *
	 * @access	public
	 * @return	void
	 */
	function edit()
	{
		// Set up the data
		$data = array(
			'widget_id'	=>	$this->uri->segment(4)
		);
		
		// Retrieve the widget
		if(!$widget = $this->widgets->get_widget($data))
		{
			// Widget doesn't exist, redirect the administrator
			redirect(ADMINCP . 'widgets');
		}
		
		// Retrieve the widget type
		if(!$type = $this->widgets->read_widget($widget->widget_slug))
		{
			// Widget doesn't exist, redirect the administrator
			redirect(ADMINCP . 'widgets');
		}
		
		// Check if type settings is defined
		if(empty($type->settings))
		{
			// Assign type settings
			$type->settings = array();
		}
		
		// Unserialize the widget settings
		$widget->settings = unserialize($widget->widget_settings);
		
		// Retrieve the areas
		$areas = $this->widgets->get_areas();
		
		// Retrieve the forms
		$update_widget = $this->input->post('update_widget');
		
		// Check it update widget has been posted
		if($update_widget)
		{
			// Set form validation rules
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('area', 'Widget Area', 'trim|required');
			$this->form_validation->set_rules('priority', 'Priority', 'trim|required|integer');
			
			//Check if settings exist
			if($widget->settings)
			{
				// Loop through each setting
				foreach($widget->settings as $setting)
				{
					$this->form_validation->set_rules('setting[' . $setting['slug'] . ']', $setting['title'], $setting['rules']);
				}
			}
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{	
				// Set up the data
				$data = array (
					'area_id'			=> $this->input->post('area'),
					'widget_title'		=> $this->input->post('title'),
					'widget_settings'	=> serialize($this->input->post('setting')),
					'widget_priority'	=> $this->input->post('priority')
				);
			
				// Update the widget in the database
				$this->widgets->update_widget($widget->widget_id, $data);
				
				// Alert the adminstrator
				$this->session->set_flashdata('message', 'The widget was successfully updated!');
				
				// Redirect the adminstrator
				redirect(ADMINCP . 'widgets/edit/' . $widget->widget_id);
			}
		}
		
		// Create a reference to widget & areas
		$this->data->widget =& $widget;
		$this->data->type =& $type;
		$this->data->areas =& $areas;
		
		// Load the admincp widgets edit view
		$this->load->view(ADMINCP . 'widgets_edit', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete
	 *
	 * Delete's a widget
	 *
	 * @access	public
	 * @return	void
	 */
	function delete()
	{
		// Set up the data
		$data = array(
			'widget_id'	=>	$this->uri->segment(4)
		);
		
		// Retrieve the widget
		if(!$widget = $this->widgets->get_widget($data))
		{
			// Widget doesn't exist, redirect the administrator
			redirect(ADMINCP . 'widgets');
		}
		
		// Delete the widget from the database
		$this->widgets->delete_widget($widget->widget_id);
				
		// Alert the adminstrator
		$this->session->set_flashdata('message', 'The widget was successfully deleted!');
				
		// Redirect the adminstrator
		redirect(ADMINCP . 'widgets');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Uninstall
	 *
	 * Uninstall's a widget
	 *
	 * @access	public
	 * @return	void
	 */
	function uninstall()
	{
		// Retrieve the widget
		if(!$widget = $this->widgets->read_widget($this->uri->segment(4)))
		{
			// Alert the adminstrator
			$this->session->set_flashdata('message', 'This widget is not currently installed!');
			
			// Widget doesn't exist, redirect the administrator
			redirect(ADMINCP . 'widgets');
		}
		
		// Include the widget
		include_once(WIDGETS . $widget->slug . '_widget.php');
		
		// Assign class name
		$class_name = ucfirst($widget->slug . '_widget');
		
		// Check if the uninstall function exists
		if(method_exists(new $class_name, 'uninstall'))
		{
			// Call the uninstall function
			call_user_func(array(new $class_name, 'uninstall'));
		}
		else
		{
			// Alert the adminstrator
			$this->session->set_flashdata('message', 'There was an unexpected error trying to uninstall this widget!');
			
			// Redirect the adminstrator
			redirect(ADMINCP . 'widgets');
		}
		
		// Retrieve the widgets
		if($widgets = $this->widgets->get_widgets(array('widget_slug' => $widget->slug)))
		{
			// Loop through the widgets
			foreach($widgets as $instance)
			{
				// Delete the widget from the database
				$this->widgets->delete_widget($instance->widget_id);
			}
		}
		// Alert the adminstrator
		$this->session->set_flashdata('message', 'The widget was successfully uninstalled!');
				
		// Redirect the adminstrator
		redirect(ADMINCP . 'widgets');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Order
	 *
	 * Update's the order of the widgets
	 *
	 * @access	public
	 * @return	void
	 */
	function order()
	{	
		// Retrieve our forms
		$widgets = $this->input->post('widget');
		
		// Loop through each widget
		foreach($widgets as $widget_priority => $widget_id)
		{
			// Set up the data
			$data = array(
				'widget_priority'	=> $widget_priority
			);
	
			// Update the widgets in the database
			$this->widgets->update_widget($widget_id, $data);
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Areas
	 *
	 * Display's the Admin CP Widget Areas
	 *
	 * @access	public
	 * @return	void
	 */
	function areas()
	{
		// Retrieve all widget areas
		$areas = $this->widgets->get_areas();
		
		// Create a reference to areas
		$this->data->areas =& $areas;
		
		// Load the admincp widget areas view
		$this->load->view(ADMINCP . 'widgetareas', $this->data);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Add Area
	 *
	 * Add's a widget area
	 *
	 * @access	public
	 * @return	void
	 */
	function addarea()
	{
		// Retrieve the forms
		$add_widgetarea = $this->input->post('add_widgetarea');
		
		// Check it add widgetarea has been posted
		if($add_widgetarea)
		{
			// Set form validation rules
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('slug', 'Slug', 'trim|required|alpha_dash|callback__check_slug');
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{	
				// Set up the data
				$data = array (
					'area_title'		=> $this->input->post('title'),
					'area_slug'			=> $this->input->post('slug')
				);
			
				// Insert the widget area into the database
				$this->widgets->insert_area($data);
					
				// Retrieve the widget area id
				$area_id = $this->db->insert_id();
					
				// Alert the adminstrator
				$this->session->set_flashdata('message', 'The widget area was successfully added!');
				
				// Redirect the adminstrator
				redirect(ADMINCP . 'widgets/editarea/' . $area_id);
			}
		}
		
		// Load the admincp widget area add view
		$this->load->view(ADMINCP . 'widgetareas_add');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Edit Area
	 *
	 * Edit's a widget area
	 *
	 * @access	public
	 * @return	void
	 */
	function editarea()
	{
		// Set up the data
		$data = array(
			'area_id'	=>	$this->uri->segment(4)
		);
		
		// Retrieve the area
		if(!$area = $this->widgets->get_area($data))
		{
			// Area doesn't exist, redirect the administrator
			redirect(ADMINCP . 'widgets/areas');
		}
		
		// Retrieve the forms
		$update_widgetarea = $this->input->post('update_widgetarea');
		
		// Check it update widget area has been posted
		if($update_widgetarea)
		{
			// Set form validation rules
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			
			// Check if area slug changed
			if($area->area_slug != $this->input->post('slug'))
			{
				// Area slug changed, set form validation rules
				$this->form_validation->set_rules('slug', 'Slug', 'trim|required|alpha_dash|callback__check_slug');
			}
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{	
				// Set up the data
				$data = array (
					'area_title'		=> $this->input->post('title'),
					'area_slug'			=> $this->input->post('slug')
				);
			
				// Update the area in the database
				$this->widgets->update_area($area->area_id, $data);
				
				// Alert the adminstrator
				$this->session->set_flashdata('message', 'The widget area was successfully updated!');
				
				// Redirect the adminstrator
				redirect(ADMINCP . 'widgets/editarea/' . $area->area_id);
			}
		}
		
		// Create a reference to area
		$this->data->area =& $area;
		
		// Load the admincp widget areas edit view
		$this->load->view(ADMINCP . 'widgetareas_edit', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete Area
	 *
	 * Delete's a widget area
	 *
	 * @access	public
	 * @return	void
	 */
	function deletearea()
	{
		// Set up the data
		$data = array(
			'area_id'	=>	$this->uri->segment(4)
		);
		
		// Retrieve the area
		if(!$area = $this->widgets->get_area($data))
		{
			// Area doesn't exist, redirect the administrator
			redirect(ADMINCP . 'widgets/areas');
		}
		
		// Check if widgets exist
		if($widgets = $this->widgets->get_widgets(array('area_id' => $area->area_id)))
		{
			// Widgets exist, loop through each widget
			foreach($widgets as $widget)
			{
				// Update the widget in the database
				$this->widgets->delete_widget($widget->widget_id);
			}
		}
		
		// Delete the widget area from the database
		$this->widgets->delete_area($area->area_id);
				
		// Alert the adminstrator
		$this->session->set_flashdata('message', 'The widget area was successfully deleted!');
				
		// Redirect the adminstrator
		redirect(ADMINCP . 'widgets/areas');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Check Slug
	 *
	 * Check's to see if a slug is unique
	 *
	 * @access	private
	 * @param	string
	 * @return	bool
	 */
	function _check_slug($slug = '')
	{
		// Set up the data
		$data = array(
			'area_slug'		=> $slug
		);
		
		// Retrieve the area
		if(!$area = $this->widgets->get_area($data))
		{
			// Area doesn't exist, return TRUE
			return TRUE;
		}
		else
		{
			// Area exists, alert the user & return FALSE
			$this->form_validation->set_message('_check_slug', 'That widget area slug is already taken.');
			return FALSE;
		}
	}
}

/* End of file widgets.php */
/* Location: ./clancms/controllers/admincp/widgets.php */
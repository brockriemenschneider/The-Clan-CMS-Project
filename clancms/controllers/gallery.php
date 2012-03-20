<?php
/**
 * Clan CMS
 *
 * An open source application for gaming clans
 *
 * @package		Clan CMS
 * @author		co[dezyne]
 * @copyright		Copyright (c) 2011 - 2012 co[dezyne]
 * @license		http://codezyne.me
 * @link			http://codezyne.me
 * @since			Version 0.6.1
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Gallery Controller
 *
 * @package			Clan CMS
 * @subpackage		Controllers
 * @category			Controllers
* @author				co[dezyne]
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
		
<<<<<<< HEAD
		// Load the Tracker model
		$this->load->model('Tracker_model', 'tracker');
		
		// Load the Settings model
		$this->load->model('Settings_model', 'settings');
		
=======
>>>>>>> articles
		// Load Download helper
		$this->load->helper('download');
		
		// Load the typography library
		$this->load->library('typography');
		
		// Load the bbcode library
		$this->load->library('BBCode');
		
		// Load the text helper
		$this->load->helper('text');
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
<<<<<<< HEAD
		// Retrieve official channel
		$official_youtube = $this->settings->get_setting(array('setting_slug' => 'youtube_id'));
		
		// Retrieve video form
		$video_upload = $this->input->post('video');
		
		// Retrieve image form
		$image_upload = $this->input->post('upload');
		
		// Check it video has been posted
		if($video_upload)
		{
			// Set form validation rules
			$this->form_validation->set_rules('videoid', 'Video ID', 'trim|required|max_length[11]');
		
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{
				// Assign share data
				$id= $this->input->post('videoid');
				$uploader = $this->session->userdata('username');
					
				//  Submit to youtube function
				$this->video_helper($id, $uploader);
			}
			
		}
		
		// Check if gallery upload has been posted
		if($image_upload)
		{
			// Set form validation rules
			$this->form_validation->set_rules('title', 'Image Title', 'trim|required|max_length[15]');
			$this->form_validation->set_rules('userfile', 'file|required');
		
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{
				$this->gallery->add_image();
			}
			
		}
		
		// Fetch active user
		$user = $this->users->get_user(array('user_id' => $this->session->userdata('user_id')));
		
		// Get gallery
		$images = $this->gallery->get_images();
		$videos = $this->gallery->get_videos();
		
		// Query tracking table
		if($user)
		{
			if($images)
			{
				// iterate through each image, appending tracker status
				foreach($images as $image)
				{
					// Get tracked status
					$image->tracked = $this->tracker->get_new($this->uri->segment(1), $image->gallery_slug, $user->user_id);
				}
			}
			
			if($videos)
			{
				// iterate through each video, appending tracker status
				foreach($videos as $video)
				{
					// Get tracked status
					$video->tracked = $this->tracker->get_new($this->uri->segment(1), $video->gallery_slug, $user->user_id);
				}
			}

		}
		
		$this->data->sxml =& $sxml;
		$this->data->images =& $images;
		$this->data->videos =& $videos;
		$this->data->official = $official_youtube;

		$this->load->view(THEME . 'gallery', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Videos
	 *
	 * Display's the video gallery
	 *
	 * @access	public
	 * @return	void
	 */
	function videos()
	{
		// Retrieve official channel
		$official_youtube = $this->settings->get_setting(array('setting_slug' => 'youtube_id'));
		
		// Fetch active user
		$user = $this->users->get_user(array('user_id' => $this->session->userdata('user_id')));
		
		// Get gallery
		$videos = $this->gallery->get_videos();
		
		// Query tracking table
		if($user)
		{			
			if($videos)
			{
				// iterate through each video, appending tracker status
				foreach($videos as $video)
				{
					// Get tracked status
					$video->tracked = $this->tracker->get_new($this->uri->segment(1), $video->gallery_slug, $user->user_id);
				}
			}

		}
		
		
		$this->data->videos =& $videos;
		$this->data->official = $official_youtube;

		$this->load->view(THEME . 'videos', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Images
	 *
	 * Display's the image gallery
	 *
	 * @access	public
	 * @return	void
	 */
	function images()
	{ 
		// Retrieve official channel
		$official_youtube = $this->settings->get_setting(array('setting_slug' => 'youtube'));
		
		// Retrieve image form
		$image_upload = $this->input->post('upload');
		
		// Check if gallery upload has been posted
		if($image_upload)
		{
			// Set form validation rules
			$this->form_validation->set_rules('title', 'Image Title', 'trim|required|max_length[15]');
=======
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
		
		// Check it update gallery has been posted
		if($gallery_upload)
		{
			// Set form validation rules
			$this->form_validation->set_rules('title', 'title', 'trim|required');
>>>>>>> articles
			$this->form_validation->set_rules('userfile', 'file|required');
		
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{
				$this->gallery->add_image();
			}
			
		}
<<<<<<< HEAD
		
		// Fetch active user
		$user = $this->users->get_user(array('user_id' => $this->session->userdata('user_id')));
		
		// Get gallery
		$images = $this->gallery->get_images();
		
		// Query tracking table
		if($user)
		{
			if($images)
			{
				// iterate through each image, appending tracker status
				foreach($images as $image)
				{
					// Get tracked status
					$image->tracked = $this->tracker->get_new($this->uri->segment(1), $image->gallery_slug, $user->user_id);
				}
			}

		}
		
		
		$this->data->images =& $images;
		$this->data->official = $official_youtube;

		$this->load->view(THEME . 'images', $this->data);
	}
	
	// --------------------------------------------------------------------
	/**
	 * Video Helper
	 *
	 * Passes YouTube IDs through Youtube library
	 *
	 * @access	private
	 * @param	array
	 * @return	void
	 */
	function video_helper($id, $uploader)
	{
		// Load YouTube library
		$this->load->library('youtube');
		
		// Pass video through library 
		$video = $this->youtube->parse( $id );
		// Setup our data
		$data = array(
			'gallery_slug'	=>	$id,
			'title'			=>	"$video->title",
			'desc'		=>	"$video->description",
			'uploader'		=>	$uploader,
			'video'		=>	"$video->thumbnailURL"
			);
		
		// Check if video is already in database
		$video = $this->gallery->get_gallery_item(array('gallery_slug' => $id));
		
		if(!$video)
		{
			//  Submit to database
			$this->gallery->add_video($data);
		} /*
		else 
		{
			// Alert the user
			$this->session->set_flashdata('gallery', 'This video has already been shared!');
			//redirect('gallery');
		} */
				
	}
	// --------------------------------------------------------------------
	
	/**
	 * Video View
	 *
	 * Display's an uploaded Youtube video & it's comments
	 *
	 * @access	public
	 * @return	void
	 */
	 function video()
	{
		// Load YouTube library
		$this->load->library('youtube');
	
		// Retrieve the image if it exists or redirect to gallery
		$media = $this->gallery->get_gallery_item(array('gallery_slug' => $this->uri->segment(3, '')));
		
		// Ensure the video exists
		if(!$media)
		{
			$this->session->set_flashdata('message', 'The video you requested was not found');
			redirect('gallery');
		}
		
		// Parse video through library
		$video = $this->youtube->parse( $media->gallery_slug );
		
		// Format Timezone
		$media->date = $this->ClanCMS->timezone($media->date);
		
		// Retrieve Uploader's avatar
		$user = $this->users->get_user(array('user_name' => $media->uploader));
		
		if($user)
		{
			$media->avatar = $user->user_avatar;
			$media->uploader_id = $user->user_id;
			
			// Retrieve uploader's group
			if($group = $this->users->get_group(array('group_id' => $user->group_id)))
			{
				// Group exist's assign user group
				$media->group = $group->group_title;
			}
			else
			{
				// Group doesn't exist, assign user group
				$media->group = '';
			}	
			
		}
		
		// Retrieve our forms
		$desc = $this->input->post('add_desc');
		$comment = $this->input->post('add_comment');
		
		// Someone is updating the description
		if($desc && $this->user->logged_in())
		{
			// Set form validation rules
			$this->form_validation->set_rules('desc', 'Description', 'trim|required');
			
			// Form validation passed & checked if gallery allows comments, so continue
			if (!$this->form_validation->run() == FALSE)
			{	
				// Set up our data
				$data = array (
					'desc'		=> $this->input->post('desc'),
					);
			
				// Insert the comment into the database
				$this->gallery->edit_desc($data, $media->gallery_id);
				
				// Alert the user
				$this->session->set_flashdata('message', 'Your description has been edited!');
				
				// Redirect the user
				redirect('gallery/video/' . $media->gallery_slug);
			}
		}
		
		// Check if add comment has been posted and check if the user is logged in
		if($comment && $this->user->logged_in())
		{
			// Set form validation rules
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required');
			
			// Form validation passed & checked if gallery allows comments, so continue
			if (!$this->form_validation->run() == FALSE)
			{	
				// Add to comments count
				$count = $media->comments;
				$count = ($count + 1);
			
				// Set up the data
				$data = array (
					'comments'		=> $count,
					);
				
				//  Update comment count
				$this->gallery->edit_desc($data, $media->gallery_id);	
				
				// Set up our data
				$data = array (
					'gallery_id'		=> $media->gallery_id,
					'user_id'			=> $this->session->userdata('user_id'),
					'comment_title'		=> $this->input->post('comment'),
					'comment_date'	=> mdate('%Y-%m-%d %H:%i:%s', now())
				);
			
				// Insert the comment into the database
				$this->gallery->insert_comment($data);
				
				// Alert the user
				$this->session->set_flashdata('message', 'Your comment has been posted!');
				
				// Redirect the user
				redirect('gallery/video/' . $media->gallery_slug);
			}
		}		
		
		// Retrieve the current page
		$page = $this->uri->segment(5, '');
	
		// Check if page exists
		if($page == '')
		{
			// Page doesn't exist, assign it
			$page = 1;
		}
	
		//Set up the variables
		$per_page = 15;
		$total_results = $this->gallery->count_comments(array('gallery_id' => $media->gallery_id));
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
		
		$comments = $this->gallery->get_comments($per_page, $offset, array('gallery_id' => $media->gallery_id));

		// Check if comments exist
		if($comments)
		{
			// Comments exist, loop through each comment
			foreach($comments as $comment)
			{
				// Retrieve the user
				if($user = $this->users->get_user(array('user_id' => $comment->user_id)))
				{
					// User exists, assign comment author & comment avatar
					$comment->author = $user->user_name;
					$comment->avatar = $user->user_avatar;
				}
				else
				{
					// User doesn't exist, assign comment author & comment avatar
					$comment->author = '';
					$comment->avatar = '';
				}
				
				// Format and assign the comment date
				$comment->date = $this->ClanCMS->timezone($comment->comment_date);
				
				// Do not count uploader comments
				if($comment->author == $media->uploader)
				{
					// Assign 0 for count
					$comment->count = 0;
				}
				else
				{
					// Give a count point
					$comment->count = 1;
				}
				
				// Create array to hold comment points
				$count[] = $comment->count;
			}
			
			// Assign comment points
			$media->comments = array_sum($count);
			
		}
		
		// Fetch active user
		$user = $this->users->get_user(array('user_id' => $this->session->userdata('user_id')));
		
		// Query tracking table
		if($user)
		{
			// set up data
			$data = array(
				'controller_name'	=>	$this->uri->segment(1),
				'controller_method'	=>	$this->uri->segment(2),
				'controller_item_id'	=>	$this->uri->segment(3),
				'user_id'			=>	$user->user_id,
				);
			
			// Check user against tracker
			$track = $this->tracker->check($data);
			
			if(!$track)
			{
				// Object is new to user
				$this->tracker->track($data);
			}

		}
		
		// Count views
		if($user && !$track)
		{
			// Hot update view count
			$views = ($media->views + 1);
			$media->views = $views;
			$this->db->where('gallery_id', $media->gallery_id)
				->update('gallery', array('views' => $media->views));
		}		
		
		// Create references
		$this->data->comments =& $comments;
		$this->data->pages =& $pages;
		$this->data->user =& $user;
		$this->data->video = $video;
		$this->data->media =& $media;
		
		// Load the view
		$this->load->view(THEME . 'video', $this->data);
	
	}


=======

		$this->load->view(THEME . 'gallery', $data);
	}
	
>>>>>>> articles
	// --------------------------------------------------------------------
	
	/**
	 * Image View
	 *
	 * Display's an uploaded image & it's comments
	 *
	 * @access	public
	 * @return	void
	 */
	 
	function image()
<<<<<<< HEAD
	{ 		
		// Retrieve the image if it exists or redirect to gallery
		$image = $this->gallery->get_gallery_item(array('gallery_slug' => $this->uri->segment(3, '')));
=======
	{ 
		
		// Retrieve the image if it exists or redirect to gallery
		$image = $this->gallery->get_image(array('image_slug' => $this->uri->segment(3, '')));
>>>>>>> articles
		
		if(!$image)
		{
			$this->session->set_flashdata('message', 'The image you requested was not found');
			redirect('gallery');
		}
		
		// Format Timezone
		$image->date = $this->ClanCMS->timezone($image->date);
		
		// Aspect ratio
		if($image->width && $image->height)
		{
			// Determine GCD
			function GCD($a, $b) 
			{  
				while ($b != 0)  
				{
					$remainder = $a % $b;  
					$a = $b;  
					$b = $remainder;  
				}  
				return abs ($a);  
			}  
			
			// Compute AR
			$a = $image->width;
			$b = $image->height; 
			$gcd = GCD($a, $b);  
			$a = $a/$gcd;  
			$b = $b/$gcd;  
			$image->ratio = $a . ":" . $b; 
		}
		
		
		// Retrieve Uploader's avatar
		$user = $this->users->get_user(array('user_name' => $image->uploader));
		$image->avatar = $user->user_avatar;
		$image->uploader_id = $user->user_id;
		
		// Retrieve uploader's group
		if($group = $this->users->get_group(array('group_id' => $user->group_id)))
		{
			// Group exist's assign user group
			$image->group = $group->group_title;
		}
		else
		{
			// Group doesn't exist, assign user group
			$image->group = '';
		}	
		
		// Retrieve our forms
		$desc = $this->input->post('add_desc');
		$comment = $this->input->post('add_comment');
		
		// Someone is updating the description
		if($desc && $this->user->logged_in())
		{
			// Set form validation rules
			$this->form_validation->set_rules('desc', 'Description', 'trim|required');
			
			// Form validation passed & checked if gallery allows comments, so continue
			if (!$this->form_validation->run() == FALSE)
			{	
				// Set up our data
				$data = array (
					'desc'		=> $this->input->post('desc'),
					);
			
				// Insert the comment into the database
				$this->gallery->edit_desc($data, $image->gallery_id);
				
				// Alert the user
				$this->session->set_flashdata('message', 'Your description has been edited!');
				
				// Redirect the user
<<<<<<< HEAD
				redirect('gallery/image/' . $image->gallery_slug);
=======
				redirect('gallery/image/' . $image->image_slug);
>>>>>>> articles
			}
		}
		
		// Check if add comment has been posted and check if the user is logged in
		if($comment && $this->user->logged_in())
		{
			// Set form validation rules
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required');
			
			// Form validation passed & checked if gallery allows comments, so continue
			if (!$this->form_validation->run() == FALSE)
			{	
<<<<<<< HEAD
				// Add to comments count
				$count = $image->comments;
				$count = ($count + 1);
			
				// Set up the data
				$data = array (
					'comments'		=> $count,
					);
				
				//  Update comment count
				$this->gallery->edit_desc($data, $image->gallery_id);	
				
=======
>>>>>>> articles
				// Set up our data
				$data = array (
					'gallery_id'		=> $image->gallery_id,
					'user_id'			=> $this->session->userdata('user_id'),
					'comment_title'		=> $this->input->post('comment'),
					'comment_date'	=> mdate('%Y-%m-%d %H:%i:%s', now())
				);
			
				// Insert the comment into the database
				$this->gallery->insert_comment($data);
				
				// Alert the user
				$this->session->set_flashdata('message', 'Your comment has been posted!');
				
				// Redirect the user
<<<<<<< HEAD
				redirect('gallery/image/' . $image->gallery_slug);
=======
				redirect('gallery/image/' . $image->image_slug);
>>>>>>> articles
			}
		}		
		
		// Retrieve the current page
		$page = $this->uri->segment(5, '');
	
		// Check if page exists
		if($page == '')
		{
			// Page doesn't exist, assign it
			$page = 1;
		}
	
		//Set up the variables
		$per_page = 15;
		$total_results = $this->gallery->count_comments(array('gallery_id' => $image->gallery_id));
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
		
		$comments = $this->gallery->get_comments($per_page, $offset, array('gallery_id' => $image->gallery_id));
<<<<<<< HEAD

=======
			
>>>>>>> articles
		// Check if comments exist
		if($comments)
		{
			// Comments exist, loop through each comment
			foreach($comments as $comment)
			{
				// Retrieve the user
				if($user = $this->users->get_user(array('user_id' => $comment->user_id)))
				{
					// User exists, assign comment author & comment avatar
					$comment->author = $user->user_name;
					$comment->avatar = $user->user_avatar;
				}
				else
				{
					// User doesn't exist, assign comment author & comment avatar
					$comment->author = '';
					$comment->avatar = '';
				}
				
				// Format and assign the comment date
				$comment->date = $this->ClanCMS->timezone($comment->comment_date);
				
				// Do not count uploader comments
				if($comment->author == $image->uploader)
				{
					// Assign 0 for count
					$comment->count = 0;
				}
				else
				{
					// Give a count point
					$comment->count = 1;
				}
				
				// Create array to hold comment points
				$count[] = $comment->count;
			}
<<<<<<< HEAD
			
			// Assign comment points
			$image->comments = array_sum($count);
			
		}
		
		// Fetch active user
		$user = $this->users->get_user(array('user_id' => $this->session->userdata('user_id')));
		
		// Query tracking table
		if($user)
		{
			// set up data
			$data = array(
				'controller_name'	=>	$this->uri->segment(1),
				'controller_method'	=>	$this->uri->segment(2),
				'controller_item_id'	=>	$this->uri->segment(3),
				'user_id'			=>	$user->user_id,
				);
			
			// Check user against tracker
			$track = $this->tracker->check($data);
			
			if(!$track)
			{
				// Object is new to user
				$this->tracker->track($data);
			}

		}
		
		// Count views
		if($user && !$track)
=======
			
		}
		
		// Assign comment points
		$image->comments = array_sum($count);
		
		// Fetch active user
		$user = $this->users->get_user(array('user_id' => $this->session->userdata('user_id')));
		
		// Block user for gaining self-views
		if($user && $user->user_name != $image->uploader)
>>>>>>> articles
		{
			// Hot update view count
			$views = ($image->views + 1);
			$image->views = $views;
			$this->db->where('gallery_id', $image->gallery_id)
				->update('gallery', array('views' => $image->views));
<<<<<<< HEAD
		}		
=======
		}
		
>>>>>>> articles
		
		// Create references
		$this->data->image =& $image;
		$this->data->comments =& $comments;
		$this->data->pages =& $pages;
		$this->data->user =& $user;
		
		// Load the gallery view
		$this->load->view(THEME . 'image', $this->data);
	}
	
	// -------------------------------------------------------------------
	
	/**
	 * Downloader
	 *
	 * @access	public
	 */
	 
	 function download()
	 {
	 	// Check to see if user is logged in
		if(!$this->user->logged_in())
		{
			// User is not logged, redirect them
			redirect('account/login');
		}
		
	 	// Retrive image
<<<<<<< HEAD
	 	$file = $this->gallery->get_gallery_item(array('gallery_slug' => $this->uri->segment(3)));
=======
	 	$file = $this->gallery->get_image(array('image_slug' => $this->uri->segment(3)));
>>>>>>> articles
	 	
	 	// Set image location
	 	$path = file_get_contents(UPLOAD . 'gallery/' .$file->image);
	 	
	 	if($path)
	 	{
	 		// Set image name
		 	$name = $file->image;
		 	
<<<<<<< HEAD
		 	// Fetch active user
		$user = $this->users->get_user(array('user_id' => $this->session->userdata('user_id')));
		
		// Query tracking table
		if($user)
		{
			// set up data
			$data = array(
				'controller_name'	=>	$this->uri->segment(1),
				'controller_method'	=>	$this->uri->segment(2),
				'controller_item_id'	=>	$this->uri->segment(3),
				'user_id'			=>	$user->user_id,
				);
			
			// Check user against tracker
			$track = $this->tracker->check($data);
			
			if(!$track)
			{
				// Object is new to user
				$this->tracker->track($data);
			}

		}

		// Count downloads
		if(!$track)
		{
		 	// Update download counts
		 	$downloads = ($file->downloads + 1);
			$file->downloads = $downloads;
			$this->db->update('gallery', array('downloads' => $file->downloads));
		}
		
		// Send download request
	 	force_download($name, $path);
		}
		else 
		{
	 	 	$this->session->set_flashdata('message', $file->image .' could not be downloaded.  Check if the file still exists.');
		}
=======
		 	$user = $this->users->get_user(array('user_id' => $this->session->userdata('user_id')));

			// Block user for gaining self-downloads
			if($user->user_name != $file->uploader)
			{
			 	// Update download counts
			 	$downloads = ($file->downloads + 1);
				$file->downloads = $downloads;
				$this->db->update('gallery', array('downloads' => $file->downloads));
			}
			
			// Send download request
		 	force_download($name, $path);
		 }else {
		 	
		 	$this->session->set_flashdata('message', $file->image .' could not be downloaded.  Check if the file still exists.');
		 	
		 	}
>>>>>>> articles
	 }
	 
	// --------------------------------------------------------------------
	/** User Gallery
	 *
	 * Display's user's Gallery
	 *
	 *@access public
	 *@param array
	 *
	 */
	 function user()
	 {
<<<<<<< HEAD
	 	// Load Youtube library
	 	$this->load->library('youtube');
	 	
=======
>>>>>>> articles
	 	// Retrieve the user slug
		$user_slug = $this->uri->segment(3, '');
		
		// Retrieve the user or show 404
		($user = $this->users->get_user(array('user_name' => $this->users->user_name($user_slug)))) or show_404();
		
<<<<<<< HEAD
		$media = $this->gallery->user_media($user->user_name);
		
		if($media)
		{
			// Iterate through objects to make arrays
			foreach($media as $item)
			{
				// Retrieve user joined, format timezone & assign user joined
				$item->date = $this->ClanCMS->timezone($item->date);
				
				$views[] = $item->views;
				
				$comments[] = $item->comments;
				
				$favors[] = $item->favors;
				
				$downloads[] = $item->downloads;
				
				$size[] = $item->size;
				
				if($item->video)
				{
					// Parse each video
					$pull = $this->youtube->parse($item->gallery_slug);
					$item->image = $pull->thumbnailURL;
				}
			}
			
			// Count and sum all elements
			$stats->images = $this->gallery->count_images(array('uploader' => $user->user_name));
			$stats->videos = $this->gallery->count_videos(array('uploader' => $user->user_name));
=======
		$images = $this->gallery->user_images($user->user_name);
		
		if($images)
		{
			// Iterate through objects to make arrays
			foreach($images as $image)
			{
				// Retrieve user joined, format timezone & assign user joined
				$image->date = $this->ClanCMS->timezone($image->date);
				
				$views[] = $image->views;
				
				$comments[] = $image->comments;
				
				$favors[] = $image->favors;
				
				$downloads[] = $image->downloads;
				
				$size[] = $image->size;
			}
			
			// Count and sum all elements
			$stats->uploads = $this->gallery->count_images(array('uploader' => $user->user_name));
>>>>>>> articles
			$stats->views = array_sum($views);
			$stats->comments = array_sum($comments);
			$stats->favors = array_sum($favors);
			$stats->downloads = array_sum($downloads);
			$stats->disk_use = round((array_sum($size) / 1024), 2) . ' MB';
<<<<<<< HEAD
			
			
		}
		
		
		// Create refrences
		$this->data->stats =& $stats;
		$this->data->media =& $media;
=======
		}
		
		// Create refrences
		$this->data->stats =& $stats;
		$this->data->images =& $images;
>>>>>>> articles
		$this->data->user =& $user;
		
		// Load view
		$this->load->view(THEME . 'media', $this->data);
	 }
	 
	// --------------------------------------------------------------------
	/**
	 * Delete Image
	 *
	 *  Removes an image
	 *
	 * @access	public
	 * @return	array
	 */
<<<<<<< HEAD
	function del_media()
=======
	function del_image()
>>>>>>> articles
	{ 
		// Set up the data
		$data = array(
			'gallery_id'	=>	$this->uri->segment(3, '')
		);

		// Retrieve the header by file_name
<<<<<<< HEAD
		if(!$media = $this->gallery->get_gallery_item($data))
=======
		if(!$image = $this->gallery->get_image($data))
>>>>>>> articles
		{
			// Image doesn't exist, alert the administrator
			$this->session->set_flashdata('message', 'The image was not found!');
		
			// Redirect the administrator
			redirect($this->session->userdata('previous'));
<<<<<<< HEAD
		}
		
		if($media->image)
		{
			// Delete the header from gallery & thumbs folders
			unlink(UPLOAD . 'gallery/' .$media->image);
			unlink(UPLOAD . 'gallery/thumbs/' . $media->image);
		}
		
		// Sumbit media for deletion
		$this->gallery->delete_image($media->gallery_id, $data);
		
		// Alert the administrator
		$this->session->set_flashdata('message', 'The media <span class="bold">' . $media->title . '</span> was successfully deleted!');
				
		// Redirect the administrator
		redirect($this->session->userdata('previous'));
=======
		}

		// Delete the header from gallery & thumbs folders
		unlink(UPLOAD . 'gallery/' .$image->image);
		unlink(UPLOAD . 'gallery/thumbs/' . $image->image);
		
		
		// Sumbit image for deletion
		$this->gallery->delete_image($image->gallery_id, $data);
		
		// Alert the administrator
		$this->session->set_flashdata('message', 'The image <span class="bold">' . $image->title . '</span> was successfully deleted!');
				
		// Redirect the administrator
		redirect('gallery');
>>>>>>> articles
	
	}	
	
	// -------------------------------------------------------------------------
	/**
	 * Delete Comment
	 *
	 * Delete's a gallery comment from the databse
	 *
	 * @access	public
	 * @return	void
	 */
	function delete_comment()
	{
		// Set up our data
		$data = array(
			'comment_id'	=>	$this->uri->segment(3)
		);
		
		// Retrieve the article comment
		if(!$comment = $this->gallery->get_comment($data))
		{
			// Comment doesn't exist, alert the administrator
			$this->session->set_flashdata('message', 'The comment was not found!');
		
			// Redirect the user
			redirect($this->session->userdata('previous'));
		}
		
		// Check if the user is an administrator
		if(!$this->user->is_administrator() && $this->session->userdata('user_id') != $comment->user_id)
		{
			// User isn't an administrator or the comment user, alert the user
			$this->session->set_flashdata('message', 'You are not allowed to delete this comment!');
			
			// Redirect the user
			redirect($this->session->userdata('previous'));
		}
<<<<<<< HEAD
		
		// Grab referring page so we can extract views
		$uri = $this->session->userdata('previous');
		$a = explode('/', $uri);
		$a = $a[2];
		
		// Retrieve the image 
		$image = $this->gallery->get_gallery_item(array('gallery_slug' => $a));
		
		if($image)
		{
			// Subtract 1 from comments
			$count = $image->comments;
			$count = ($count - 1);
		
			// Set up the data
			$data = array (
				'comments'		=> $count,
				);
			
			//  Update comment count
			$this->gallery->edit_desc($data, $image->gallery_id);	
			
		}
					
=======
				
>>>>>>> articles
		// Delete the article comment from the database
		$this->gallery->delete_comment($comment->comment_id, $data);
		
		// Alert the administrator
		$this->session->set_flashdata('message', 'The comment was successfully deleted!');
				
		// Redirect the administrator
		redirect($this->session->userdata('previous'));
	}
<<<<<<< HEAD
	
	// -------------------------------------------------------------------------
	/**
	 * Cache 
	 *
	 * Scans the clan YouTube channel for new videos
	 *
	 * @access	private
	 * @return	void
	 */	
	function cache()
	{
		// Retrieve official channel
		$official_youtube = $this->settings->get_setting(array('setting_slug' => 'youtube_id'));
		
		if($official_youtube)
		{
			
			// Video Constraints
			$ns = array
				(
				        'content' => 'http://purl.org/rss/1.0/modules/content/',
				        'wfw' => 'http://wellformedweb.org/CommentAPI/',
				        'dc' => 'http://purl.org/dc/elements/1.1/'
				);
				
			$video = array();
			$channel_url = 'http://gdata.youtube.com/feeds/api/users/' . $official_youtube->setting_value . '/uploads';
			
			$rawFeed = file_get_contents($channel_url);
			$sxml = new SimpleXmlElement($rawFeed);
	
			//  extract the videos
			foreach ($sxml->entry as $item)
			{ 
				
				// get nodes in media: namespace for media information
		      		$media = $item->children('http://search.yahoo.com/mrss/');
				$attrs = $media->group->player->attributes();
				$watch = $attrs['url'];
				$exp = explode('=',$watch);
				$exp1 = explode('&',$exp[1]); 
				$clan_video_id = $exp1[0];
				
				// Pass video through library 
				$this->video_helper( $clan_video_id,  $official_youtube->setting_value);
				
				
			}
		}
		
		// Alert the administrator
		$this->session->set_flashdata('gallery', 'The channel has been successfully cached!');
		
		// Redirect Admin
		redirect($this->session->userdata('previous'));
	}
=======

>>>>>>> articles
/* End of file gallery.php */
/* Location: ./clancms/controllers/gallery.php */
}
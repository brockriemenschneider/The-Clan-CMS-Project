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
 * @since		Version 0.5.0
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Admin CP Articles Controller
 *
 * @package		Clan CMS
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Articles extends CI_Controller {
	
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
			// User is not an administrator, redirect them
			redirect('account/login');
		}
		
		// Check if the administrator has permission
		if(!$this->user->has_permission('articles'))
		{
			// Administrator doesn't have permission, show error, and exit
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
	 * Display's the Admin CP Published Articles
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Retrieve the page
		$page = $this->uri->segment(4, '');
	
		// Check if page exists
		if($page == '')
		{
			// Page doesn't exist, assign page
			$page = 1;
		}
	
		//Set up the variables
		$per_page = 10;
		$total_results = $this->articles->count_articles(array('article_status' => 1));
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
		
		// Retrieve the articles
		$articles = $this->articles->get_articles($per_page, $offset, array('article_status' => 1));
		
		// Check it articles exist
		if($articles)
		{
			// Articles exist, loop through each article
			foreach($articles as $article)
			{
				// Retrieve the total number of comments for this article
				$article->total_comments = $this->articles->count_comments(array('article_id' => $article->article_id));
				
				// Format the article date, and assign it to article date
				$article->date = $this->ClanCMS->timezone($article->article_date);
			
				// Retrieve the user
				$user = $this->users->get_user(array('user_id' => $article->user_id));
				
				// Check if user exists
				if($user)
				{
					// User exists, assign article author
					$article->author = $user->user_name;
				}
				else
				{
					// User doesn't exist, assign article author
					$article->author = '';
				}
			}
		}
		
		// Create a reference to articles & pages
		$this->data->articles =& $articles;
		$this->data->pages =& $pages;
		
		// Load the admincp articles view
		$this->load->view(ADMINCP . 'articles', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Drafts
	 *
	 * Display's the Admin CP Draft Articles
	 *
	 * @access	public
	 * @return	void
	 */
	function drafts()
	{
		// Retrieve the page
		$page = $this->uri->segment(5, '');
	
		// Check if page exists
		if($page == '')
		{
			// Page doesn't exist, assign page
			$page = 1;
		}
	
		//Set up the variables
		$per_page = 10;
		$total_results = $this->articles->count_articles(array('article_status' => 0));
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
		
		// Retrieve the articles
		$articles = $this->articles->get_articles($per_page, $offset, array('article_status' => 0));
		
		// Check it articles exist
		if($articles)
		{
			// Articles exist, loop through each article
			foreach($articles as $article)
			{
				// Retrieve the total number of comments for this article
				$article->total_comments = $this->articles->count_comments(array('article_id' => $article->article_id));
				
				// Format the article date, and assign it to article date
				$article->date = $this->ClanCMS->timezone($article->article_date);
			
				// Retrieve the user
				$user = $this->users->get_user(array('user_id' => $article->user_id));
				
				// Check if user exists
				if($user)
				{
					// User exists, assign article author
					$article->author = $user->user_name;
				}
				else
				{
					// User doesn't exist, assign article author
					$article->author = '';
				}
			}
		}
		
		// Create a reference to articles & pages
		$this->data->articles =& $articles;
		$this->data->pages =& $pages;
		
		// Load the admincp articles view
		$this->load->view(ADMINCP . 'articles', $this->data);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Add
	 *
	 * Add's a article
	 *
	 * @access	public
	 * @return	void
	 */
	function add()
	{		
		// Retrievethe forms
		$add_article = $this->input->post('add_article');
		
		// Check it add article has been posted
		if($add_article)
		{
			// Set form validation rules
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('squad', 'Squad', 'trim|required');
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('article', 'Article', 'trim|required');
			$this->form_validation->set_rules('game', 'Game', 'required');
			$this->form_validation->set_rules('comments', 'Comments', 'trim|required');
		
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{
				// Set up the data
				$data = array (
					'squad_id'			=> $this->input->post('squad'),
					'article_title'		=> $this->input->post('title'),
					'article_content'	=> $this->input->post('article'),
					'article_comments'	=> $this->input->post('comments'),
					'article_game'			=> $this->input->post('game'),
					'user_id'			=> $this->session->userdata('user_id'),
					'article_status'	=> $this->input->post('status'),
					'article_permission'	=>	$this->input->post('permissions'),
					'article_date'		=> mdate('%Y-%m-%d %H:%i:%s', now())
				);
			
				// Insert the article into the database
				$this->articles->insert_article($data);
				
				// Retrieve the article id
				$article_id = $this->db->insert_id();
				
				// Set up the data
				$data = array (
					'article_slug'		=> $article_id . '-' . url_title($this->input->post('title'))
				);
				
				// Update the article in the database
				$this->articles->update_article($article_id, $data);
				
				// Alert the administrator
				$this->session->set_flashdata('message', 'The article was successfully added!');
				
				// Status doesn't equal 0, redirect the administrator
				redirect(ADMINCP . 'articles/edit/' . $article_id);
			}
		}
		
		// Retrieve the squads
		$squads = $this->squads->get_squads();
		// Create a reference to squads
		$this->data->squads =& $squads;
		
		// Load the games method
		$games = $this->articles->get_games();
		 // Reference games
		 $this->data->games =& $games;
		
		
		// Load the admincp articles add view
		$this->load->view(ADMINCP . 'articles_add', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Edit
	 *
	 * Displays a form to edit articles
	 *
	 * @access	public
	 * @return	void
	 */
	function edit()
	{
		// Set up our data
		$data = array(
			'article_id'	=>	$this->uri->segment(4)
		);
		
		// Retrieve the article
		if(!$article = $this->articles->get_article($data))
		{
			// Article doesn't exist, redirect the administrator
			redirect(ADMINCP . 'articles');
		}
		
		// Retrieve the current page
		$page = $this->uri->segment(6, '');
	
		// Check if page exists
		if($page == '')
		{
			// Page doesn't exist, assign it
			$page = 1;
		}
	
		//Set up the variables
		$per_page = 10;
		$total_results = $this->articles->count_comments(array('article_id' => $article->article_id ));
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
		
		// Retrieve our forms
		$update_article = $this->input->post('update_article');
		
		// Check it update article has been posted
		if($update_article)
		{
			// Set form validation rules
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('squad', 'Squad', 'trim|required');
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('article', 'Article', 'trim|required');
			$this->form_validation->set_rules('comments', 'Comments', 'trim|required');
			$this->form_validation->set_rules('game', 'Game', 'required');
		
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{
				// Set up the data
				$data = array (
					'squad_id'			=> $this->input->post('squad'),
					'article_title'		=> $this->input->post('title'),
					'article_slug'		=> $article->article_id . '-' . url_title($this->input->post('title')),
					'article_content'	=> $this->input->post('article'),
					'article_comments'	=> $this->input->post('comments'),
					'article_status'	=> $this->input->post('status'),
					'article_permission'	=>	$this->input->post('permissions'),
					'article_game'	=> $this->input->post('game'),
				);
				
				// Check if article is a draft
				if((bool) !$this->input->post('status'))
				{
					// Retrieve the slides
					if($slides = $this->articles->get_slides('', '', array('article_id' => $article->article_id)))
					{
						// Slides exist, loop through each slide
						foreach($slides as $slide)
						{
							// Delete the comment from the database
							$this->articles->delete_slide($slide->slider_id);
						}
					}
				}
				
				// Update the article into the database
				$this->articles->update_article($article->article_id, $data);
				
				// Alert the administrator
				$this->session->set_flashdata('message', 'The article was successfully updated!');
				
				// Status doesn't equal 0, redirect the administrator
				redirect(ADMINCP . 'articles/edit/' . $article->article_id);
			}
		}
		
		// Retrieve the user
		$user = $this->users->get_user(array('user_id' => $article->user_id));
				
		// Check if user exists
		if($user)
		{
			// User exists, assign article author
			$article->author = $user->user_name;
		}
		else
		{
			// User doesn't exist, assign article author
			$article->author = '';
		}
				
		// Retrieve the squads
		$squads = $this->squads->get_squads();
		
		// Check if article allows comments
		if((bool) $article->article_comments)
		{
			// Article allows comments, retrieve the articles comments
			$comments = $this->articles->get_comments($per_page, $offset, array('article_id' => $article->article_id));
				
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
				}
			}
		}
		// Display all Game headers
		$games = $this->articles->get_games();
		
		// Create a reference to article, squads, comments & pages
		$this->data->article =& $article;
		$this->data->squads =& $squads;
		$this->data->comments =& $comments;
		$this->data->pages =& $pages;
		$this->data->games =& $games;
		
		// Load the admincp articles edit view
		$this->load->view(ADMINCP . 'articles_edit', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete
	 *
	 * Delete's an article
	 *
	 * @access	public
	 * @return	void
	 */
	function delete()
	{
		// Set up the data
		$data = array(
			'article_id'	=>	$this->uri->segment(4, '')
		);
		
		// Retrieve the article
		if(!$article = $this->articles->get_article($data))
		{
			// Article doesn't exist, redirect the administrator
			redirect(ADMINCP . 'articles');
		}
		
		// Retrieve the slides
		if($slides = $this->articles->get_slides('', '', $data))
		{
			// Slides exist, loop through each slide
			foreach($slides as $slide)
			{
				// Delete the comment from the database
				$this->articles->delete_slide($slide->slider_id);
			}
		}
		
		// Retrieve the comments
		if($comments = $this->articles->get_comments('', '', $data))
		{
			// Comments exist, loop through each comment
			foreach($comments as $comment)
			{
				// Delete the comment from the database
				$this->articles->delete_comment($comment->comment_id);
			}
		}
		
		// Delete the article from the database
		$this->articles->delete_article($article->article_id);
				
		// Alert the administrator
		$this->session->set_flashdata('message', 'The article was successfully deleted!');
				
		// Redirect the administrator
		redirect(ADMINCP . 'articles');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Publish
	 *
	 * Publshe's an article
	 *
	 * @access	public
	 * @return	void
	 */
	function publish()
	{
		// Set up the data
		$data = array(
			'article_id'	=>	$this->uri->segment(4)
		);
		
		// Retrieve the article
		if(!$article = $this->articles->get_article($data))
		{
			// Article doesn't exist, redirect the administrator
			redirect(ADMINCP . 'articles/drafts');
		}
		
		// Check if the article is a draft
		if((bool) $article->article_status)
		{
			// Article ins't a draft, redirect the administrator
			redirect(ADMINCP . 'articles/drafts');
		}
		
		// Set up the data
		$data = array(
			'article_status'	=> 1
		);
		
		// Delete the article from the database
		$this->articles->update_article($article->article_id, $data);
				
		// Alert the administrator
		$this->session->set_flashdata('message', 'The article was published!');
				
		// Redirect the administrator
		redirect(ADMINCP . 'articles');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete Comment
	 *
	 * Delete's a article comment from the databse
	 *
	 * @access	public
	 * @return	void
	 */
	function delete_comment()
	{
		// Set up the data
		$data = array(
			'comment_id'	=>	$this->uri->segment(4, '')
		);
		
		// Retrieve the article comment
		if(!$comment = $this->articles->get_comment($data))
		{
			// Comment doesn't exist, alert the administrator
			$this->session->set_flashdata('message', 'The comment was not found!');
		
			// Redirect the administrator
			redirect($this->session->userdata('previous'));
		}
				
		// Delete the article comment from the database
		$this->articles->delete_comment($comment->comment_id, $data);
		
		// Alert the administrator
		$this->session->set_flashdata('message', 'The comment was successfully deleted!');
				
		// Redirect the administrator
		redirect(ADMINCP . 'articles/edit/' . $comment->article_id . '#comments');
	}
// --------------------------------------------------------------------
	/** Headers
	 * 
	 *  Adds news headers
	 *
	 * @access	public
	 * @return	void
	 */
	 function headers() {

		// Display all Game headers
		$data['games'] = $this->articles->get_games();
		
		//  on submit -> to model
		if ($this->input->post('upload')) {
			$this->articles->add_header();
		}
		
		$this->load->view(ADMINCP . 'articles_headers', $data);
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
	function del_header()
	{
		// Set up the data
		$data = array(
			'id'	=>	$this->uri->segment(4, '')
		);

		// Retrieve the header by file_name
		if(!$header = $this->articles->get_header($data))
		{
			// Comment doesn't exist, alert the administrator
			$this->session->set_flashdata('message', 'The header was not found!');
		
			// Redirect the administrator
			redirect($this->session->userdata('previous'));
		}

		// Delete the article comment from the database
		unlink(UPLOAD . 'headers/' .$header->image);
		$this->articles->delete_header($header->id, $data);
		
		// Alert the administrator
		$this->session->set_flashdata('message', 'The header was successfully deleted!');
				
		// Redirect the administrator
		redirect(ADMINCP . 'articles/headers/');
	
	}
	
	
	
}

/* End of file articles.php */
/* Location: ./clancms/controllers/admincp/articles.php */
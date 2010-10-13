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
 * Clan CMS Articles Controller
 *
 * @package		Clan CMS
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Articles extends Controller {
	
	/**
	 * Constructor
	 *
	 */	
	function Articles()
	{
		// Call the Controller constructor
		parent::Controller();
		
		// Load the Articles Model
		$this->load->model('Articles_model', 'articles');
		
		// Load the Squads Model
		$this->load->model('Squads_model', 'squads');
		
		// Load the typography library
		$this->load->library('typography');
		
		// Load the text helper
		$this->load->helper('text');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the articles
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{	
		// Retrieve the page
		$page = $this->uri->segment('3');
	
		// Check if page exists
		if($page == '')
		{
			// Page doesn't exist, assign it
			$page = 1;
		}
	
		//Set up the variables
		$per_page = 5;
		$total_results = $this->articles->count_articles(array('article_status' => 1));
		$offset = ($page - 1) * $per_page;
		$pages = '';
		
		// Create the pages
		for($i = 1; $i < ($total_results / $per_page) + 1; $i++)
		{
			// Check current page
			if($page == $i)
			{
				// Create current page link
				$pages.= '[' . $i . '] ';
			}
			else
			{
				// Create other pages links
				$pages.= anchor('articles/page/' . $i, $i) . ' ';
			}
		}
		
		// Retrieve the articles
		$articles = $this->articles->get_articles($per_page, $offset, array('article_status' => 1));
		
		// Check if articles exist
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
				
				// Limit the article's words, format the text, create links, and assign it to article summary
				$article->summary = auto_link($this->typography->auto_typography(word_limiter($article->article_content, 100)));
			}
		}

		// Create a reference to articles & pages
		$this->data->articles =& $articles;
		$this->data->pages =& $pages;
	
		// Load the articles view
		$this->load->view(THEME . 'articles', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * View
	 *
	 * Display's an article & it's comments
	 *
	 * @access	public
	 * @return	void
	 */
	function view()
	{
		// Retrieve the article if it exists or show 404
		($article = $this->articles->get_article(array('article_slug' => $this->uri->segment(3, ''), 'article_status' => 1))) or show_404();
		
		// Retrieve our forms
		$add_comment = $this->input->post('add_comment');
		
		// Check it add comment has been posted and check if the user is logged in
		if($add_comment && $this->user->logged_in())
		{
			// Set form validation rules
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required');
			
			// Form validation passed & checked if article allows comments, so continue
			if (!$this->form_validation->run() == FALSE && (bool) $article->article_comments)
			{	
				// Set up our data
				$data = array (
					'article_id'		=> $article->article_id,
					'user_id'			=> $this->session->userdata('user_id'),
					'comment_title'		=> $this->input->post('comment'),
					'comment_date'		=> mdate('%Y-%m-%d %H:%i:%s', now())
				);
			
				// Insert the comment into the database
				$this->articles->insert_comment($data);
				
				// Alert the user
				$this->session->set_flashdata('message', 'Your comment has been posted!');
				
				// Redirect the user
				redirect('articles/view/' . $article->article_slug);
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
		$per_page = 10;
		$total_results = $this->articles->count_comments(array('article_id' => $article->article_id));
		$offset = ($page - 1) * $per_page;
		$pages = '';
		
		// Create the pages
		for($i = 1; $i < ($total_results / $per_page) + 1; $i++)
		{
			// Check current page
			if($page == $i)
			{
				// Create current page link
				$pages.= '[' . $i . '] ';
			}
			else
			{
				// Create other pages links
				$pages.= anchor('/articles/view/' . $article->article_slug . '/page/' . $i . '#comments', $i) . ' ';
			}
		}
		
		// Configure the article
		$article->article = auto_link($this->typography->auto_typography($article->article_content));
		
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
		
		// Configure article date
		$article->date = $this->ClanCMS->timezone($article->article_date);
		
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
					$comment->author = $this->users->get_user(array('user_id' => $comment->user_id))->user_name;
					$comment->date = $this->ClanCMS->timezone($comment->comment_date);
				}
			}
		}
		
		// Create a reference to the article & comments & pages
		$this->data->article =& $article;
		$this->data->comments =& $comments;
		$this->data->pages =& $pages;
		
		// Load the Article view
		$this->load->view(THEME . 'article', $this->data);
	}
	
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
		// Set up our data
		$data = array(
			'comment_id'	=>	$this->uri->segment(3)
		);
		
		// Retrieve the article comment
		if(!$comment = $this->articles->get_comment($data))
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
				
		// Delete the article comment from the database
		$this->articles->delete_comment($comment->comment_id, $data);
		
		// Alert the administrator
		$this->session->set_flashdata('message', 'The comment was successfully deleted!');
				
		// Redirect the administrator
		redirect($this->session->userdata('previous'));
	}
	
}

/* End of file articles.php */
/* Location: ./clancms/controllers/articles.php */
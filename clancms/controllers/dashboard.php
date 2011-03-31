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
 * Clan CMS Dashboard Controller
 *
 * @package		Clan CMS
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Dashboard extends Controller {
	
	/**
	 * Constructor
	 *
	 */	
	function Dashboard()
	{
		// Call the Controller constructor
		parent::Controller();
		
		// Load the Articles Model
		$this->load->model('Articles_model', 'articles');
		
		// Load the Squads Model
		$this->load->model('Squads_model', 'squads');
		
		// Load the Pages Model
		$this->load->model('Pages_model', 'pages');
		
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
	 * Display's the dashboard
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{	
		// Retrieve the articles
		$articles = $this->articles->get_articles(5, '', array('article_status' => 1));
		
		// Check if articles exist
		if($articles)
		{
			// Articles exist, loop through each article
			foreach($articles as $article)
			{
				// Retrieve the total number of comments for this article, and assign it to article toal comments
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
				$article->summary = auto_link($this->typography->auto_typography($this->bbcode->to_html(word_limiter($article->article_content, 100))), 'url');
			}
		}

		// Create a reference to articles
		$this->data->articles =& $articles;
	
		// Load the dashboard view
		$this->load->view(THEME . 'dashboard', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Page
	 *
	 * Display's a page
	 *
	 * @access	public
	 * @return	void
	 */
	function page()
	{	
		// Retrieve the page or show 404
		($page = $this->pages->get_page(array('page_slug' => $this->uri->segment(2, '')))) or show_404();
		
		// Assign page title
		$page->title = $page->page_title;
				
		// Format the text, create links, and assign page content
		$page->content = auto_link($this->typography->auto_typography($this->bbcode->to_html(htmlspecialchars_decode($page->page_content))), 'url');
		
		// Create a reference to page
		$this->data->page =& $page;
	
		// Load the page view
		$this->load->view(THEME . 'page', $this->data);

	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Banned
	 *
	 * Display's the banned page
	 *
	 * @access	public
	 * @return	void
	 */
	function banned()
	{	
		// Assign page title
		$page->title = "You Have Been Banned!";
		
		// Assign page content
		$page->content = "You have been banned from this site!";
		
		// Create a reference to page
		$this->data->page =& $page;
		
		// Load the page view
		$this->load->view(THEME . 'page', $this->data);
	}

}

/* End of file dashboard.php */
/* Location: ./clancms/controllers/dashboard.php */
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
 * Clan CMS Roster Controller
 *
 * @package		Clan CMS
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Roster extends Controller {

	/**
	 * Constructor
	 *
	 */	
	function Roster()
	{
		// Call the Controller constructor
		parent::Controller();
		
		// Load the Squads model
		$this->load->model('Squads_model', 'squads');
		
		// Load the Articles model
		$this->load->model('Articles_model', 'articles');
		
		// Load the Matches model
		$this->load->model('Matches_model', 'matches');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the squads
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Retrieve the squads
		$squads = $this->squads->get_squads(array('squad_status' => 1));
		
		// Check if squads exist
		if($squads)
		{
			// Squads exist, loop through each squad
			foreach($squads as $squad)
			{
				// Retrive the squad members
				$squad->members = $this->squads->get_members(array('squad_id' => $squad->squad_id));
			
				// Check if squad members exist
				if($squad->members)
				{
					// Squad members exist, loop through each member
					foreach($squad->members as $member)
					{
						// Retrieve the member user
						$member->user = $this->users->get_user(array('user_id' => $member->user_id));
					
						// Check if member user exist
						if($member->user)
						{
							// Member user exists, assign member online & member user name
							$member->online = $this->user->is_online($member->user->user_id);
							$member->user_name = $member->user->user_name;
						}
						else
						{
							// Member user doesn't exist, assign member online & member user name
							$member->online = '';
							$member->user_name = '';
						}
						
						// Retrieve the total number of member kills
						$member->total_kills = $this->squads->count_kills(array('member_id' => $member->member_id));
						
						// Retrieve the total number of member deaths
						$member->total_deaths = $this->squads->count_deaths(array('member_id' => $member->member_id));
					
						// Check if member total deaths equals 0
						if($member->total_deaths == 0)
						{
							// Member total deaths equals 0, format kills & deaths, assign member kd
							$member->kd = number_format(($member->total_kills / 1), 2, '.', '');
						}
						else
						{
							// Member total deaths doesn't equal 0, format kills & deaths, assign member kd
							$member->kd = number_format(($member->total_kills / $member->total_deaths), 2, '.', '');
						}
					}
				}
			}
		}
			
		// Create a reference to squads & squad
		$this->data->squads =& $squads;
		$this->data->squad =& $squad;
		
		// Load the roster view
		$this->load->view(THEME . 'roster', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Squad
	 *
	 * Display's a squad
	 *
	 * @access	public
	 * @return	void
	 */
	function squad()
	{
		// Retrieve the squad slug
		$squad_slug = $this->uri->segment(3, '');
		
		// Retrieve the squad or show 404
		($squad = $this->squads->get_squad(array('squad_slug' => $squad_slug, 'squad_status' => 1))) or show_404();
		
		// Retrieve the squad members
		$squad->members = $this->squads->get_members(array('squad_id' => $squad->squad_id));
		
		// Check if squad members exist
		if($squad->members)
		{
			// Squad members exist, loop through each member
			foreach($squad->members as $member)
			{
				// Retrieve the member user
				$member->user = $this->users->get_user(array('user_id' => $member->user_id));
					
				// Check if member user exist
				if($member->user)
				{
					// Member user exists, assign member online & member user name
					$member->online = $this->user->is_online($member->user->user_id);
					$member->user_name = $member->user->user_name;		
				}
				else
				{
					// Member user doesn't exist, assign member online & member user name
					$member->online = '';
					$member->user_name = '';
				}
						
				// Retrieve the total number of member kills
				$member->total_kills = $this->squads->count_kills(array('member_id' => $member->member_id));
						
				// Retrieve the total number of member deaths
				$member->total_deaths = $this->squads->count_deaths(array('member_id' => $member->member_id));
					
				// Check if member total deaths equals 0
				if($member->total_deaths == 0)
				{
					// Member total deaths equals 0, format kills & deaths, assign member kd
					$member->kd = number_format(($member->total_kills / 1), 2, '.', '');
				}
				else
				{
					// Member total deaths doesn't equal 0, format kills & deaths, assign member kd
					$member->kd = number_format(($member->total_kills / $member->total_deaths), 2, '.', '');
				}
			}
		}
		
		// Retrieve the squads
		$squads = $this->squads->get_squads();
		
		// Retrieve the articles
		$articles = $this->articles->get_articles('', '', array('squad_id' => $squad->squad_id, 'article_status' => 1));
		
		// Check if articles exist
		if($articles)
		{
			// Articles exist, loop through each article
			foreach($articles as $article)
			{
				// Retrieve the total number of comments for this article
				$article->total_comments = $this->articles->count_comments(array('article_id' => $article->article_id));
				
				// Format the article date, assign article date
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
				
		// Retrieve the matches
		$matches = $this->matches->get_matches('', '', array('squad_id' => $squad->squad_id));
		
		// Check if matches exist
		if($matches)
		{
			// Matches exist, loop through each match
			foreach($matches as $match)
			{
				// Format each match date
				$match->date = $this->ClanCMS->timezone($match->match_date);
			}
		}
		
		// Create a reference to squads, articles, matches & squad
		$this->data->squads =& $squads;
		$this->data->articles =& $articles;
		$this->data->matches =& $matches;
		$this->data->squad =& $squad;
		
		// Load the squad view
		$this->load->view(THEME . 'squad', $this->data);
	}
	
}

/* End of file roster.php */
/* Location: ./clancms/controllers/roster.php */
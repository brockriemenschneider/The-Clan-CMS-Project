<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
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
 * Clan CMS Matches Widget
 *
 * @package		Clan CMS
 * @subpackage	Widgets
 * @category	Widgets
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Matches_widget extends Widget {

	// Widget information
	public $title = 'Matches';
	public $description = "Display's recent and upcoming matches a clan has.";
	public $author = 'Xcel Gaming';
	public $link = 'http://www.xcelgaming.com';
	public $version = '1.0.0';
	
	// Widget Settings
	public $settings = array(
		array(
			'title'			=> 'Type',
			'slug'			=> 'matches_type',
			'value'			=> '0',
			'type'			=> 'select',
			'options'		=> array('0' => 'Recent Matches', '1' => 'Upcoming Matches'),
			'description'	=> 'The type of matches to show',
			'rules'			=> 'trim|required'
		),
		array(
			'title'			=> '# of Matches',
			'slug'			=> 'matches_number',
			'value'			=> '5',
			'type'			=> 'text',
			'options'		=> array(),
			'description'	=> 'The number of matches to show for this match type',
			'rules'			=> 'trim|required|integer'
		)
	);
	
	/**
	 * Constructor
	 *
	 */
	function __construct()
	{
		// Call the Widget constructor
		parent::__construct();
		
		// Create a instance to CI
		$CI =& get_instance();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the matches
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Load the Matches model
		$this->CI->load->model('Matches_model', 'matches');
		
		// Check the match type
		if((bool) $this->setting['matches_type'])
		{
			// Retrieve the upcoming matches
			$matches = $this->CI->matches->get_matches($this->setting['matches_number'], '', array('match_date >' => mdate('%Y-%m-%d %H:%i:%s', local_to_gmt(time()))));
		}
		else
		{
			// Retrieve the latest matches
			$matches = $this->CI->matches->get_matches($this->setting['matches_number'], '', array('match_date <' => mdate('%Y-%m-%d %H:%i:%s', local_to_gmt(time()))));
		}
		
		// Check if matches exist
		if($matches)
		{
			// Matches exist, loop through each match
			foreach($matches as $match)
			{
				// Retrieve the opponent
				$opponent = $this->CI->matches->get_opponent(array('opponent_id' => $match->opponent_id));
				
				// Check if opponent exists
				if($opponent)
				{
					// Opponent exists, assign opponent & opponent slug
					$match->opponent = $opponent->opponent_title;
					$match->opponent_slug = $opponent->opponent_slug;
				}
				else
				{
					// Opponent doesn't exist, don't assign it
					$match->opponent = "";
					$match->opponent_slug = "";
				}
			
				// Retrieve match date, format timezone & assign match date
				$match->date = $this->CI->ClanCMS->timezone($match->match_date);
			}
		}
		
		// Create a reference to matches & setting
		$this->data->matches =& $matches;
		$this->data->setting = $this->setting;
		
		// Assign the widget info
		$widget->title = '';
		$widget->content = $this->CI->load->view('widgets/matches', $this->data, TRUE);
		
		// Check the match type
		if((bool) $this->setting['matches_type'])
		{
			$widget->tabs = array(
				array(
					'title'		=> 'MATCHES',
					'link'		=> 'matches',
					'selected'	=> FALSE
				),
				array(
					'title'		=> 'UPCOMING MATCHES',
					'link'		=> 'matches/upcoming',
					'selected'	=> TRUE
				)
			);
		}
		else
		{
			$widget->tabs = array(
				array(
					'title'		=> 'MATCHES',
					'link'		=> 'matches',
					'selected'	=> TRUE
				),
				array(
					'title'		=> 'UPCOMING MATCHES',
					'link'		=> 'matches/upcoming',
					'selected'	=> FALSE
				)
			);
		}
		
		// Load the widget view
		$this->CI->load->view(WIDGET . 'widget', $widget);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Uninstall
	 *
	 * Uninstall's the widget
	 *
	 * @access	public
	 * @return	void
	 */
	function uninstall()
	{
		// Assign files
		$files = array(
			APPPATH . 'views/widgets/matches.php'
		);
		
		// Loop through the files
		foreach($files as $file)
		{
			// Check if the file exists
			if(file_exists($file))
			{
				// Delete the file
				unlink($file);
			}
		}
		
		// Delete the widget
		unlink(__FILE__);
	}
}
	
/* End of file matches_widget.php */
/* Location: ./clancms/widgets/matches_widget.php */
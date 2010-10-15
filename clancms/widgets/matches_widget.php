<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
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
 * Clan CMS Matches Widget
 *
 * @package		Clan CMS
 * @subpackage	Widgets
 * @category	Widgets
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Matches_widget extends Widget {

	/**
	 * Constructor
	 *
	 */
	function Matches_widget()
	{
		// Call the Widget constructor
		parent::Widget();
		
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
		
		// Retrieve the latest matches
		$matches = $this->CI->matches->get_matches(5, '', array('match_date <' => mdate('%Y-%m-%d %H:%i:%s', local_to_gmt(time()))));
		
		// Check if matches exist
		if($matches)
		{
			// Matches exist, loop through each match
			foreach($matches as $match)
			{
				// Retrieve match date, format timezone & assign match date
				$match->date = $this->CI->ClanCMS->timezone($match->match_date);
			}
		}
		
		// Create a reference to matches
		$this->data->matches =& $matches;
		
		// Load the matches widget view
		$this->CI->load->view(THEME . 'widgets/matches', $this->data);
	}
	
}
	
/* End of file matches_widget.php */
/* Location: ./clancms/widgets/matches_widget.php */
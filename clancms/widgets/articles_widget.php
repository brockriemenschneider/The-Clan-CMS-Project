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
 * Clan CMS Articles Widget
 *
 * @package		Clan CMS
 * @subpackage	Widgets
 * @category	Widgets
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Articles_widget extends Widget {

	/**
	 * Constructor
	 *
	 */
	function Articles_widget()
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
	 * Display's the articles
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Load the Articles model
		$this->CI->load->model('Articles_model', 'articles');
		
		// Retrieve the articles
		$articles = $this->CI->articles->get_articles(3);
		
		// Create a reference to articles
		$this->data->articles =& $articles;
		
		// Load the articles widget view
		$this->CI->load->view(THEME . 'widgets/articles', $this->data);
	}
	
}
	
/* End of file articles_widget.php */
/* Location: ./clancms/widgets/articles_widget.php */
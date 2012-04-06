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
 * @since		Version 0.5.5
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS BBCode Class
 *
 * @package		Clan CMS
 * @subpackage	Libraries
 * @category	BBCode
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class BBCode {

	var $CI;
	
	/**
	 * Constructor
	 *
	 */	
	function __construct()
	{	
		// Create an instance to CI
		$this->CI =& get_instance();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * To HTML
	 *
	 * Converts BB Code to HTML
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	function to_html($bbcode = '')
	{
		// Trim the bbcode
		$bbcode = trim($bbcode);
		
		$bbcode = preg_replace_callback('/\[code\](.*?)\[\/code\]/ms', array($this, 'escape'), $bbcode);
	
		// Smilies to find
		$in = array(
			':evil:',
			':happy:', 	
			':sad:',
			':surprised:',
			':tongue:',
			':wink:',
			':smile:',
			':curly:',
			':heart:'
		);
		
		// Smiliy replacements
		$out = array(
			'<img title="Evil Grin" alt="Evil Grin" src="' . ADMINCP_URL . 'js/markitup/markitup/sets/bbcode/images/emoticon_evilgrin.png" />',
			'<img title="Happy" alt="Happy" src="' . ADMINCP_URL . 'js/markitup/markitup/sets/bbcode/images/emoticon_happy.png" />',
			'<img title="Sad" alt="Sad" src="' . ADMINCP_URL . 'js/markitup/markitup/sets/bbcode/images/emoticon_sad.png" />',
			'<img title="Surprised" alt="Surprised" src="' . ADMINCP_URL . 'js/markitup/markitup/sets/bbcode/images/emoticon_surprised.png" />',
			'<img title="Tongue" alt="Tongue" src="' . ADMINCP_URL . 'js/markitup/markitup/sets/bbcode/images/emoticon_tongue.png" />',
			'<img title="Wink" alt="Wink" src="' . ADMINCP_URL . 'js/markitup/markitup/sets/bbcode/images/emoticon_wink.png" />',
			'<img title="Smile" alt="Smile" src="' . ADMINCP_URL . 'js/markitup/markitup/sets/bbcode/images/emoticon_smile.png" />',
			'<img title="Curly Lips" alt="Curly Lips" src="' . ADMINCP_URL . 'js/markitup/markitup/sets/bbcode/images/emoticon_curlylips.png" />',
			'<img title="Heart" alt="Heart" src="' . ADMINCP_URL . 'js/markitup/markitup/sets/bbcode/images/emoticon_heart.png" />'
		);
		
		// Replace the Smilies
		$bbcode = str_replace($in, $out, $bbcode);
		
		// BBCode to find
		$in = array(
			'/\[b\](.*?)\[\/b\]/ms',	
			'/\[i\](.*?)\[\/i\]/ms',
			'/\[u\](.*?)\[\/u\]/ms',
			'/\[s\](.*?)\[\/s\]/ms',
			'/\[img\](.*?)\[\/img\]/ms',
			'/\[email\="?(.*?)"?\](.*?)\[\/email\]/ms',
			'/\[email\](.*?)\[\/email\]/ms',
			'/\[url\="?(.*?)"?\](.*?)\[\/url\]/ms',
			'/\[url\](.*?)\[\/url\]/ms',
			'/\[size\="?(.*?)"?\](.*?)\[\/size\]/ms',
			'/\[color\="?(.*?)"?\](.*?)\[\/color\]/ms',
			'/\[quote](.*?)\[\/quote\]/ms',
			'/\[list\=(.*?)\](.*?)\[\/list\]/ms',
			'/\[list\](.*?)\[\/list\]/ms',
			'/\[\*\]\s?(.*?)\n/ms',
			'/\[left\](.*?)\[\/left\]/ms',
			'/\[center\](.*?)\[\/center\]/ms',
			'/\[right\](.*?)\[\/right\]/ms',
			'/\[sup\](.*?)\[\/sup\]/ms',
			'/\[sub\](.*?)\[\/sub\]/ms',
			'/\[upper\](.*?)\[\/upper\]/ms',
			'/\[lower\](.*?)\[\/lower\]/ms',
			'/\[youtube\](.*?)\[\/youtube\]/ms'
		);
		
		// BB Code Replacements
		$out = array(
			'<strong>\1</strong>',
			'<em>\1</em>',
			'<u>\1</u>',
			'<s>\1</s>',
			'<img src="\1" alt="\1" />',
			'<a href="mailto:\1">\2</a>',
			'<a href="mailto:\1">\1</a>',
			'<a href="\1">\2</a>',
			'<a href="\1">\1</a>',
			'<span style="font-size:\1%">\2</span>',
			'<span style="color:\1">\2</span>',
			'<blockquote>\1</blockquote>',
			'<ol start="\1">\2</ol>',
			'<ul>\1</ul>',
			'<li>\1</li>',
			'<div style="text-align: left;">\1</div>',
			'<div style="text-align: center;">\1</div>',
			'<div style="text-align: right;">\1</div>',
			'<sup>\1</sup>',
			'<sub>\1</sub>',
			'<div style="text-transform: uppercase;">\1</div>',
			'<div style="text-transform: lowercase;">\1</div>',
			'<object width="400" height="325"><param name="movie" value="http://www.youtube.com/v/\1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/\1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="400" height="325"></embed></object>'
		);
	
		// Replace the BB Code
		$html = preg_replace($in, $out, $bbcode);
	
		return $html;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Escape
	 *
	 * Escapes Code
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	function escape($string)
	{
		$code = $string[1];
		$code = str_replace("[", "&#91;", $code);
		$code = str_replace("]", "&#93;", $code);
		return '<pre><code>'.$code.'</code></pre>';
	}	
}

/* End of file BBCode.php */
/* Location: ./clancms/libraries/BBCode.php */
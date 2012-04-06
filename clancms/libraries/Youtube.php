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
 * @category		YouTube
 * @author		co[dezyne]
 * @link			http://www.codezyne.me
 */
class Youtube {

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
	 * To Object
	 *
	 * Runs YouTube video ID through YT API, parsing the informaion
	 *
	 * @access	public
	 * @param	string
	 * @return	array
	 */
	function parse($youtubeID)
	{
		$obj = new stdClass;
		 
		 // set video data feed URL
		$feedURL = 'http://gdata.youtube.com/feeds/api/videos/' . $youtubeID;
		
		libxml_use_internal_errors(true);
		// read feed into SimpleXML object
		if( !$entry = simplexml_load_file($feedURL))
		{
			$this->CI->session->set_flashdata('gallery', 'That is not a valid YouTube video ID!');
			return FALSE;
			
			   
		}
		else
		{
		 
			// get last updated
			$attrs = $entry->updated;
			$attrs = explode('T',$attrs);
			$obj->updated = $attrs[0]; 
			
			// get video author
			$obj->author = $entry->author->name;
			
			// get nodes in media: namespace for media information
			$media = $entry->children('http://search.yahoo.com/mrss/');
			$obj->title = $media->group->title;
			$obj->description = $media->group->description;
			 
			// get video player URL
			$attrs = $media->group->player->attributes();
			$obj->watchURL = $attrs['url']; 
			 
			// get video thumbnail
			$attrs = $media->group->thumbnail[0]->attributes();
			$obj->thumbnailURL = $attrs['url']; 
			
			// get <yt:duration> node for video length
			$yt = $media->children('http://gdata.youtube.com/schemas/2007');
			$attrs = $yt->duration->attributes();
			$obj->length = $attrs['seconds']; 
			 
			// get <yt:stats> node for viewer statistics
			$yt = $entry->children('http://gdata.youtube.com/schemas/2007');
			$attrs = $yt->statistics->attributes();
			$obj->viewCount = $attrs['viewCount']; 
			 
			// get <gd:rating> node for video ratings
			$gd = $entry->children('http://schemas.google.com/g/2005'); 
			if ($gd->rating) 
			 { 
				 $attrs = $gd->rating->attributes();
				 $obj->rating = $attrs['average']; 
			} 
			 else 
			 {
				$obj->rating = 0;	
			}
			
			 // get <gd:comments> node for video comments
			$gd = $entry->children('http://schemas.google.com/g/2005');
			if ($gd->comments->feedLink) 
			 { 
				 $attrs = $gd->comments->feedLink->attributes();
				 $obj->commentsURL = $attrs['href']; 
				 $obj->commentsCount = $attrs['countHint']; 
			}
		
			return $obj;	 
		}
	} 
		
		

}

/* End of file Youtube.php */
/* Location: ./clancms/libraries/Youtube.php */
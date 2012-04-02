<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
 /**
 * CZ Gaming
 *
 * @package		CZ Gaming
 * @author		co[dezyne]
 * @copyright		Copyright (c) 2012, co[dezyne]
 * @license		http://codezyne.me/license.php
 * @link			http://codezyne.me
 * @since			Version 0.1
 */
// ------------------------------------------------------------------------
/**
 * CZ Gaming Twitter Class
 *
 * @package		CZ Gaming
 * @subpackage	Libraries
 * @category		Libraries
 * @author		co[dezyne]
 * @link			http://codezyne.me
 */
 
class Twitter {

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
	
	// -------------------------------------------------------------------
	function parse($user, $count)
	{
		// Receive twitter user's json file
		$twitter = file_get_contents('http://twitter.com/statuses/user_timeline/'. $user . '.json?count='.$count);
		
		// Decode json into object
		$data = json_decode($twitter, FALSE); 
		
		// Extract User details
		foreach($data as $item)
		{			
			// Define User
			$tweet->user->icon = $item->user->profile_image_url;
			$tweet->user->name = $item->user->name;
			$tweet->user->screen_name = $item->user->screen_name;
			$tweet->user->id = $item->user->id;
			$tweet->user->id_str = $item->user->id_str;
			$tweet->user->tweets = $item->user->statuses_count;
			
			// Break apart the shoutted comment
			$chunk = explode(' ', $item->text);
			
			// Iterate through array searching for URIs
			 foreach($chunk as &$bit)
			 {
			 	
			 	$check_www = preg_match('/^www/', $bit);
			 	$check_http = preg_match('/^http/', $bit);
			 	$check_tweeter = preg_match('/^@/', $bit);
			 	
			 	// If shout contains a link, anchor it, else leave it alone
			 	if($check_www == 1)
			 	{
			 		$bit = '<a href="http://' . $bit . '" target="_blank" />' . $bit . '</a>';
			 	}elseif($check_http == 1)
			 	{
			 		$bit = '<a href="' . $bit . '" target="_blank" />' . $bit . '</a>';
			 	}elseif($check_tweeter)
			 	{
			 		$bit = '<a href="https://twitter.com/intent/user?screen_name=' . $bit . '" />' . $bit . '</a>';
			 	}else{
			 		$bit = $bit;
			 	}
			 	
			 }
			 
			 // Put array back together
			$merged = implode(' ', $chunk);
			
			// Reference newly build shout
			$item->text = $merged;

			//  Setup tweet bindings
			$id = $item->id;
			$date = explode('+', $item->created_at);
			$date = $date[0];
			$reply = $item->in_reply_to_screen_name;
			$retweet = $item->retweeted;
			$text = $item->text;
			$reply = $item->in_reply_to_screen_name;
			$retweet = $item->retweeted;
			
			
			// Push bindings through 	parser
			$tweet->msg[] =& $this->tweet($id, $date, $text, $reply, $retweet);

		}
				
		// Build user's twitter object
		return $tweet;
		
	}
	
	function tweet($id, $date, $text, $reply, $retweet)
	{
		
		// Build tweet object
		$tweet->msg->id =& $id;
		$tweet->msg->date =& $date;
		$tweet->msg->text =& $text;
		$tweet->msg->reply =& $reply;
		$tweet->msg->retweet =& $retweet;	
		
		// Return object
		return $tweet->msg;
		
	}	


}

/* End of file twitter.php */
/* Location: ./czgaming/libraries/Twitter.php */
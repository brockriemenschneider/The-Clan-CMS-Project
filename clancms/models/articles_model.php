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
 * @since		Version 0.5.0
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Articles Model
 *
 * @package		Clan CMS
 * @subpackage	Models
 * @category	Models
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Articles_model extends CI_Model {

	/**
	 * Constructor
	 *
	 */
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Slide
	 *
	 * Retrieves a article slide from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_slide($data = array())
	{	
		// Check for valid data
		if(empty($data) OR !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->where($data)
						->get('article_slider', 1);
		
		// Check if query row exists
		if($query->row())
		{
			// Query row exists, return query row
			return $query->row();
		}
		else
		{
			// Query row doesn't exist, return FALSE
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Slides
	 *
	 * Retrieves all article slides from the database
	 *
	 * @access	public
	 * @param	int
	 * @param	int
	 * @param	array
	 * @return	array
	 */
	function get_slides($limit = 0, $offset = 0, $data = array())
	{
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Check if limit exists
		if($limit == 0)
		{
			// Limit doesn't exist, assign limit
			$limit = '';
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->order_by('slider_priority', 'asc')
						->limit($limit, $offset)
						->where($data)
						->get('article_slider');
		
		// Check if query result exists
		if($query->result())
		{
			// Query result exists, return query result
			return $query->result();
		}
		else
		{
			// Query result doesn't exist, return FALSE
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Count Slides
	 *
	 * Count the number of article slides in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_slides($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('article_slider')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Slide
	 *
	 * Inserts a article slide into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_slide($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('article_slider', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Slide
	 *
	 * Updates a article slide in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_slide($slide_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($slide_id == '0' OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if slide exists
		if(!$slide = $this->get_slide(array('slider_id' => $slide_id)))
		{
			// Slide doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, slide exists, update the data in the database
		return $this->db->update('article_slider', $data, array('slider_id' => $slide_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Slide
	 *
	 * Deletes a article slide from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_slide($slide_id = 0)
	{	
		// Check to see if we have valid data
		if($slide_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if slide exists
		if(!$slide = $this->get_slide(array('slider_id' => $slide_id)))
		{
			// Slide doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, slide exists, delete the data from the database
		return $this->db->delete('article_slider', array('slider_id' => $slide_id));
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Comment
	 *
	 * Retrieves a article comment from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_comment($data = array())
	{	
		// Check for valid data
		if(empty($data) OR !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->where($data)
						->get('article_comments', 1);
		
		// Check if query row exists
		if($query->row())
		{
			// Query row exists, return query row
			return $query->row();
		}
		else
		{
			// Query row doesn't exist, return FALSE
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Comments
	 *
	 * Retrieves all article comments from the database
	 *
	 * @access	public
	 * @param	int
	 * @param	int
	 * @param	array
	 * @return	array
	 */
	function get_comments($limit = 0, $offset = 0, $data = array())
	{
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Check if limit exists
		if($limit == 0)
		{
			// Limit doesn't exist, assign limit
			$limit = '';
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->order_by('comment_id', 'desc')
						->limit($limit, $offset)
						->where($data)
						->get('article_comments');
		
		// Check if query result exists
		if($query->result())
		{
			// Query result exists, return query result
			return $query->result();
		}
		else
		{
			// Query result doesn't exist, return FALSE
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Count Comments
	 *
	 * Count the number of article comments in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_comments($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('article_comments')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Comment
	 *
	 * Inserts a article comment into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_comment($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('article_comments', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Comment
	 *
	 * Updates a article comment in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_comment($comment_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($comment_id == '0' OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if comment exists
		if(!$comment = $this->get_comment(array('comment_id' => $comment_id)))
		{
			// Comment doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, comment exists, update the data in the database
		return $this->db->update('article_comments', $data, array('comment_id' => $comment_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Comment
	 *
	 * Deletes a article comment from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_comment($comment_id = 0)
	{	
		// Check to see if we have valid data
		if($comment_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if comment exists
		if(!$comment = $this->get_comment(array('comment_id' => $comment_id)))
		{
			// Comment doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, comment exists, delete the data from the database
		return $this->db->delete('article_comments', array('comment_id' => $comment_id));
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Article
	 *
	 * Retrieves a article from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_article($data = array())
	{	
		// Check for valid data
		if(empty($data) OR !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->where($data)
						->get('articles', 1);
		
		// Check if query row exists
		if($query->row())
		{
			// Query row exists, return query row
			return $query->row();
		}
		else
		{
			// Query row doesn't exist, return FALSE
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Articles
	 *
	 * Retrieves all articles from the database
	 *
	 * @access	public
	 * @param	int
	 * @param	int
	 * @param	array
	 * @return	array
	 */
	function get_articles($limit = 0, $offset = 0, $data = array())
	{
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Check if limit exists
		if($limit == 0)
		{
			// Limit doesn't exist, assign limit
			$limit = '';
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->order_by('article_id', 'desc')
						->limit($limit, $offset)
						->where($data)
						->get('articles');
		
		// Check if query result exists
		if($query->result())
		{
			// Query result exists, return query result
			return $query->result();
		}
		else
		{
			// Query result doesn't exist, return FALSE
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Count Articles
	 *
	 * Count the number of articles in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_articles($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('articles')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Article
	 *
	 * Inserts a article into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_article($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('articles', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Article
	 *
	 * Updates a article in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_article($article_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($article_id == '0' OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if article exists
		if(!$article = $this->get_article(array('article_id' => $article_id)))
		{
			// Article doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, article exists, update the data in the database
		return $this->db->update('articles', $data, array('article_id' => $article_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Article
	 *
	 * Deletes a article from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_article($article_id = 0)
	{	
		// Check to see if we have valid data
		if($article_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if article exists
		if(!$article = $this->get_article(array('article_id' => $article_id)))
		{
			// Article doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, article exists, delete the data from the database
		return $this->db->delete('articles', array('article_id' => $article_id));
	}
	
}

/* End of file articles_model.php */
/* Location: ./clancms/models/articles_model.php */
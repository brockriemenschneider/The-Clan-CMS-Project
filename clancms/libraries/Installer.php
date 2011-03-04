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
 * Clan CMS Installer Class
 *
 * @package		Clan CMS
 * @subpackage  Libraries
 * @category    Installation
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Installer {

	var $CI;
	
	/**
	 * Constructor
	 *
	 */	
	function Installer()
	{	
		// Create an instance to CI
		$this->CI =& get_instance();
		
		// Load the file helper
		$this->CI->load->helper('file');
		
		// Load the directory helper
		$this->CI->load->helper('directory');
	}
					
	// --------------------------------------------------------------------
	
    /**
	 * Install
	 *
	 * Installs the database
	 *
	 * @access	public
     * @return	bool
	 */
    function install()
    {
		// Change the permissions
		chmod('./clancms/views/install/sql/install.sql', 0755);
		
		// Retrieve the install sql
		$sql = file_get_contents('./clancms/views/install/sql/install.sql');
		
		// Format the sql
		$sql = str_replace('__DBPREFIX__', $this->CI->session->userdata('dbprefix'), $sql);
		
		// Connect to the database
		mysql_connect($this->CI->session->userdata('hostname'), $this->CI->session->userdata('username'), $this->CI->session->userdata('password')) or die(mysql_error());
		mysql_select_db($this->CI->session->userdata('database')) or die(mysql_error());

		// Parse the queries
		$queries = explode('-- command split --', $sql);
		
		// Loop through each query
		foreach($queries as $query)
		{
			// Run the query
			mysql_query($query);
		}
		
		// Close the connection
		mysql_close();
	}
				
	// --------------------------------------------------------------------
	
    /**
	 * Write ClanCMS File
	 *
	 * Writes to the ClanCMS model
	 *
	 * @access	public
     * @return	bool
	 */
    function write_ClanCMS_file()
    {
		// Change the permissions
		chmod('./clancms/models/clancms.php', 0755);
		
        // Fetch the database file
        $clancms_file = read_file('./clancms/models/clancms.php');
		
        // Variables to replace
        $replace = array(
            'define(\'INSTALL\', TRUE);' => 'define(\'INSTALL\', FALSE);',
			'__SUPERADMINISTRATOR__' => '1'
        );
		
        // Create the new clancms file content
        $new_clancms_file = str_replace(array_keys($replace), $replace, $clancms_file);
		
		// Attempt to write to the clancms file, return attempt
        if ( ! write_file('./clancms/models/clancms.php', $new_clancms_file, 'w+') )
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}

    }
	
	// --------------------------------------------------------------------
	
    /**
	 * Write DB File
	 *
	 * Writes to the database file
	 *
	 * @access	public
     * @return	bool
	 */
    function write_db_file()
    {
		// Change the permissions
		chmod('./clancms/config/database.php', 0755);
		
        // Fetch the database file
        $db_file = read_file('./clancms/config/database.php');
		
        // Variables to replace
        $replace = array(
            '__DBPREFIX__' => $this->CI->session->userdata('dbprefix'),
            '__HOSTNAME__' => $this->CI->session->userdata('hostname'),
            '__USERNAME__' => $this->CI->session->userdata('username'),
            '__PASSWORD__' => $this->CI->session->userdata('password'),
            '__DATABASE__' => $this->CI->session->userdata('database'),
            '$db[\'default\'][\'autoinit\'] = FALSE;' => ''
        );
		
        // Create the new database file content
        $new_db_file = str_replace(array_keys($replace), $replace, $db_file);
		
		// Attempt to write to the database file, return attempt
        if ( ! write_file('./clancms/config/database.php', $new_db_file, 'w+') )
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}

    }
	
	// --------------------------------------------------------------------
	
	/**
	 * Write Config File
	 *
	 * Writes to the config file
	 *
	 * @access	public
     * @return	bool
	 */
    function write_config_file()
    {
		// Load the string helper
		$this->CI->load->helper('string');
		
		// Change the permissions
		chmod('./clancms/config/config.php', 0755);
		
        // Fetch the config file
        $config_file = read_file('./clancms/config/config.php');
		
        // Variables to replace
        $replace = array(
            '__BASEURL__' => trim_slashes($this->CI->session->userdata('site_link')) . '/',
            '$config[\'sess_use_database\'] = FALSE;' => '$config[\'sess_use_database\'] = TRUE;'
        );
		
        // Create the new config file content
        $new_config_file = str_replace(array_keys($replace), $replace, $config_file);
		
		// Attempt to write to the config file, return attempt
        if ( ! write_file('./clancms/config/config.php', $new_config_file, 'w+') )
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}

    }
	
	// --------------------------------------------------------------------
	
	 /**
	 * Test DB Connection
	 *
	 * Tests the database connection
	 *
	 * @access	public
     * @return	bool
	 */
    function test_db_connection()
	{
		$hostname = $this->CI->session->userdata('hostname');
		$username = $this->CI->session->userdata('username');
		$password = $this->CI->session->userdata('password');

		if($connect = mysql_connect($hostname, $username, $password))
		{
			mysql_close($connect);
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	 /**
	 * Self Destruct
	 *
	 * Destroys the Installation Package
	 *
	 * @access	public
     * @return	void
	 */
	function self_destruct()
	{
		// Define the paths to installation files
		$installation_files = array(
			'./clancms/controllers/install.php',
			'./clancms/libraries/Installer.php'
		);
		
		// Define the path to the installation folder
		$installation_folder = './clancms/views/install';
	
		// Delete the installation folder
		delete_directory($installation_folder);
	
		// Delete the installation files
		foreach($installation_files as $files)
		{
			unlink($files);
		}
	}
	
}

/* End of file Installer.php */
/* Location: ./clancms/libraries/Installer.php */
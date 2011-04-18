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
	public $php_version;
	public $mysql_server_version;
	public $mysql_client_version;
	public $gd_version;
	
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
		
		// Load the encrypt library
		$this->CI->load->library('encrypt');
	}
	
	// --------------------------------------------------------------------
	
    /**
	 * PHP test
	 *
	 * Test to see if the server can support Clan CMS
	 *
	 * @access	public
     * @return	bool
	 */	
	function php_test()
	{
		// Assign php version
		$this->php_version = phpversion();
		
		// Check to see if the PHP version is greater than or equal to 5.1.6
		return ( version_compare($this->php_version, '5.1.6', '>=') ) ? TRUE : FALSE;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * MySQL test
	 *
	 * Test to see if the server can support Clan CMS
	 *
	 * @access	public
	 * @param	string
     * @return	bool
	 */	
	function mysql_test($type = 'server')
	{
		// Assign mysql server/client version
		$this->mysql_server_version = $this->CI->session->userdata('server_version');
		$this->mysql_client_version = $this->CI->session->userdata('client_version');
		
		// Check the type of mysql test
		if($type == 'server')
		{
			// Check if the server version is greater than or equal to 4.1
			return (version_compare($this->mysql_server_version, '4.1', '>=')) ? TRUE : FALSE;
		}
		else
		{
			// Check if the client version is greater than or equal to 4.1
			return (version_compare($this->mysql_client_version, '4.1', '>=')) ? TRUE : FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
    /**
	 * ZLib test
	 *
	 * Test to see if the server can support Clan CMS
	 *
	 * @access	public
     * @return	bool
	 */	
	function zlib_test()
	{
		// Return status of the zip library extension
		return extension_loaded('zlib');
	}

	// --------------------------------------------------------------------
	
    /**
	 * GD test
	 *
	 * Test to see if the server can support Clan CMS
	 *
	 * @access	public
     * @return	bool
	 */	
	function gd_test()
	{
		// Check if the function exists
		if (function_exists('gd_info'))
		{
			// Retrieve the gd info
			$gd_info = gd_info();
			
			// Assign ge version
			$this->gd_version = preg_replace('/[^0-9\.]/','',$gd_info['GD Version']);
			
			// Check to see if the GD library version is 1.0 or greater
			return ($this->gd_version >= 1) ? TRUE : FALSE;
		}
		else
		{
			// return FALSE
			return FALSE;
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
		$hostname = $this->CI->session->userdata('db_hostname');
		$port = $this->CI->session->userdata('db_port');
		$username = $this->CI->session->userdata('db_username');
		$password = $this->CI->session->userdata('db_password');

		return @mysql_connect("$hostname:$port", $username, $password);
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
        // Fetch the database file
        $db_file = read_file('./clancms/config/database.php');
		
        // Variables to replace
        $replace = array(
            '__DBPREFIX__' => $this->CI->session->userdata('db_prefix'),
            '__HOSTNAME__' => $this->CI->session->userdata('db_hostname'),
            '__USERNAME__' => $this->CI->session->userdata('db_username'),
            '__PASSWORD__' => $this->CI->session->userdata('db_password'),
            '__DATABASE__' => $this->CI->session->userdata('db_name'),
            '$db[\'default\'][\'autoinit\'] = FALSE;' => '',
			'__PORT__' => $this->CI->session->userdata('db_port')
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
		
        // Fetch the config file
        $config_file = read_file('./clancms/config/config.php');
		
		// Determine if mod rewrite works
		if(file_get_contents(BASE_URL . 'install/modrewrite') == 1)
		{
			$index = '""';
		}
		else
		{
			$index = '"index.php"';
		}
		
        // Variables to replace
        $replace = array(
            '"index.php"' => $index,
			'__ENCRYPTION__' => $this->CI->user->_salt(),
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
	 * Attempt Install
	 *
	 * Attempts to install the database and write the files
	 *
	 * @access	public
     * @return	bool
	 */
    function attempt_install()
    {
		// Retrieve salt
		$salt = $this->CI->user->_salt();
		
		// Retrieve the install sql
		$sql = file_get_contents('./clancms/views/install/sql/install.sql');
		
		// Format the sql
		$sql = str_replace('__DBPREFIX__', $this->CI->session->userdata('db_prefix'), $sql);
		$sql = str_replace('__CLANNAME__', $this->CI->session->userdata('clan_name'), $sql);
		$sql = str_replace('__SITEEMAIL__', $this->CI->session->userdata('site_email'), $sql);
		$sql = str_replace('__TIMEZONE__', $this->CI->session->userdata('timezone'), $sql);
		$sql = str_replace('__DAYLIGHTSAVINGS__', $this->CI->session->userdata('daylight_savings'), $sql);
		$sql = str_replace('__USERNAME__', $this->CI->session->userdata('username'), $sql);
		$sql = str_replace('__USERPASSWORD__', $this->CI->encrypt->sha1($salt . $this->CI->encrypt->sha1($this->CI->session->userdata('password'))), $sql);
		$sql = str_replace('__USERSALT__', $salt, $sql);
		$sql = str_replace('__USEREMAIL__', $this->CI->session->userdata('email'), $sql);
		$sql = str_replace('__USERTIMEZONE__', $this->CI->session->userdata('user_timezone'), $sql);
		$sql = str_replace('__USERDAYLIGHTSAVINGS__', $this->CI->session->userdata('user_daylight_savings'), $sql);
		$sql = str_replace('__USERIPADDRESS__', $this->CI->session->userdata('ipaddress'), $sql);
		$sql = str_replace('__USERJOINED__', mdate('%Y-%m-%d %H:%i:%s', now()), $sql);
		
		// Connect to the database
		mysql_connect($this->CI->session->userdata('db_hostname') . ':' . $this->CI->session->userdata('db_port'), $this->CI->session->userdata('db_username'), $this->CI->session->userdata('db_password')) or die(mysql_error());
		mysql_select_db($this->CI->session->userdata('db_name')) or die(mysql_error());

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
		
		// Attempt to write to the database file
		$this->write_db_file();
			
		// Attempt to write the config file
		$this->write_config_file();
		
		// Write the ClanCMS file
		$this->write_ClanCMS_file();
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
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * Clan CMS FileDownloader Class
 *
 * @package		Clan CMS
 * @subpackage	Libraries
 * @category	FileDownloader
 * @author		FuntimeError
 * @link		http://www.xcelgaming.com
 * @link		http://www.dfbrigade.org
 */
class FileDownloader {

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

	
	function readRemoteFile($path)
	{
		if(ini_get('allow_url_fopen') == true)
		{
			return file_get_contents($path);
		}
		else if(function_exists('curl_init') && function_exists('curl_setopt') && function_exists('curl_exec') && function_exists('curl_close'))
		{
			$ch = curl_init($path);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = curl_exec($ch);
			return $output;
		}
		else if(ini_get('safe_mode') == false)
		{
			//fsockopen
			$fp = fsockopen($path, 80, $errno, $errstr, 30);
			if ($fp) 
			{
				$urlhostinfo = parse_url($path, PHP_URL_PATH);
				$out = "GET / HTTP/1.1\r\n";
    			$out .= "Host: " .$urlhostinfo['host'] ."\r\n";
    			$out .= "Connection: Close\r\n\r\n";
    			fwrite($fp, $out);
    			if($buffer = fgets($fp) !== false)
    			{
    				fclose($fp);
        			return $buffer;
				}
    			fclose($fp);
			}
			return false;
		}
		
		
		else 
		{
			return false;
		}
	}
	
	
	
	function downloadFile($remote,$local)
	{
		$overwrite = true;
		//check if local file already exists and overwrite if requested
		if(file_exists($local) && $overwrite)
		{
			unlink($local);
		}
		
		$urlhostinfo = parse_url($remote);
		$basehost = $urlhostinfo['host'];
					
		$fp = @fsockopen($basehost, 80, $errno, $errstr, 30);
		if ($fp) 
		{
			$out = "GET " .$urlhostinfo['path'] . " HTTP/1.1\r\n";
    		$out .= "Host: " .$basehost ."\r\n";
    		$out .= "User-Agent: The Clan CMS Project Downloader" . "\r\n";
   			$out .= "Connection: Close\r\n\r\n";
   			fwrite($fp, $out);

			$response = '';
			$headers = true;
						die(var_dump($response));

			while(!feof($fp))
			{
				$line = fgets($fp);
				if($line=="\r\n")
				{
					$headers = false;
					continue;
				}
				if($headers && $loc = strstr($line, 'Location: '))
				{
					
					$loc = trim(substr($loc,10));
					return $this->downloadFile($loc,$local);

				}
				if(!$headers)
				{
					$response .= $line;
				}
			}
			
			
			if(strlen($response) > 0)
			{
				$lp = fopen($local,'w+');
				fwrite($lp, $response);
				fclose($lp);
			}	
			fclose($fp);	
		}
		if(file_exists($local) && filesize($local) > 0)
		{
			return true;
		}
		return false;
	}
}

/* End of file FileDownloader.php */
/* Location: ./clancms/libraries/FileDownloader.php */

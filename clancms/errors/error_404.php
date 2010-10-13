<?php

// Create a instance to CI
$CI =& get_instance();

// Set up the data
$this->data->title = $heading;
$this->data->message = $message;

// Check if we are in admincp
if($CI->uri->segment(1) == ADMINCP)
{
	// We are in the admincp, load the admincp message view
	$CI->load->view(ADMINCP . 'message', $this->data);
}
else
{
	// We are not in the admincp, load the message view
	$CI->load->view(THEME . 'message', $this->data);
}

?>
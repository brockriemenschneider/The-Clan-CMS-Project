<?php

// Create a instance to CI
$CI =& get_instance();

// Assign page title
$page->title = $heading;

// Assign page content
$page->content = $message;

// Create a reference to page
$this->data->page =& $page;

// Check if we are in admincp
if($CI->uri->segment(1) . '/' == ADMINCP)
{
	// We are in the admincp, load the admincp page view
	$CI->load->view(ADMINCP . 'page', $this->data);
}
else
{
	// We are not in the admincp, load the page view
	$CI->load->view(THEME . 'page', $this->data);
}

?>
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
 * CZ Gaming Calendar Class
 *
 * @package		CZ Gaming
 * @subpackage	Libraries
 * @category		Libraries
 * @author		co[dezyne]
 * @link			http://codezyne.me
 */
 
class Calendar {

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
	function clancms_calendar($time, $year, $month, $events = array(), $day_name_length = 1, $month_href = NULL, $first_day = 0, $prev_next = array())
	{
		// Begin the month
		$first_of_month = gmmktime(0,0,0,$month,1,$year);
		
		// Create day headers
		$day_names = array(); 
		for( $n=0, $t=(3 + $first_day) * 86400 ; $n < 7; $n++, $t+= 86400) 
			$day_names[$n] = ucfirst(gmstrftime('%A',$t)); 
		
		// Assign vars & begin 1st of the month on proper day
		list($month, $year, $month_name, $weekday) = explode(',',gmstrftime('%m,%Y,%B,%w', $first_of_month));
		$weekday = ($weekday + 7 - $first_day) % 7; 
		$month_title   = htmlentities(ucfirst($month_name)).'&nbsp;'.$year; 
		
		@list($prev, $prev_link) = each($prev_next);
		@list($next, $next_link) = each($prev_next);
		if($prev): $prev = anchor('events/' . htmlspecialchars($prev_link), $prev, array('title'=>'Previous Month', 'class'=> 'left prev-month')); endif;
		if($next): $next = anchor('events/' . htmlspecialchars($next_link), $next, array('title'=>'Next Month', 'class'=> 'right next-month')); endif;
		if($month_href): $month_title = anchor('events/' . htmlspecialchars($month_href), $month_title, array('class'=>'this-month')); endif;


		// Create table
		$calendar = '<table class="calendar"><caption class="subheader calendar-month">' . $prev . $month_title . $next . '</caption><thead class="calendar-weekdays">';
		
		// Parse day headers
		if($day_name_length)
		{
			foreach($day_names as $d)
				$calendar .= '<th>' . htmlentities($day_name_length < 4 ? substr($d, 0, $day_name_length) : $d) . '</th>';
				$calendar .= "</thead><tbody><tr>";
		}
		
		// Beginning of Month offsets
		if($weekday > 0) $calendar .= '<td class="calendar-offset" colspan="'.$weekday.'">&nbsp;</td>'; 

		// Run the numbers
		for($day=1, $days_in_month=gmdate('t',$first_of_month); $day<=$days_in_month; $day++, $weekday++)
		{
			
			if($weekday == 7)
			{
				// Week is full, start new tablerow
				$weekday   = 0; 
				$calendar .= "</tr><tr>";
			}
			
			

			if(isset($events[$day]) and is_array($events[$day]))
			{
				// Propagate the tabledata
				@list($link, $classes, $summary, $content) = $events[$day];
				
				// Check for overrides 
				if(is_null($content))  $content  = $day;
				
				// Construct tabledata
				$calendar .= '<td class="' . ($day == date('j', $time) && $month == date('n', $time) ? 'calendar-today ' : '') . ($classes ? htmlspecialchars($classes) : '') .'"' . ($summary ? ' title="' . $summary . '">' : '>').
				($classes == 'calendar-match' ? anchor('matches/view/' . htmlspecialchars($link), $content) : ($link ? anchor('events/' . htmlspecialchars($link), $content) : $content )) . '</td>';
			}
			else
			{
				 $calendar .= '<td class="' . ($day == date('j', $time) && $month == date('n', $time) ? 'yellow">' : '">') . $day . '</td>';
			}
			
			
		
		}
		
		
		// End of Month offsets
		if($weekday != 7) $calendar .= '<td class="calendar-offset" colspan="'.(7-$weekday).'">&nbsp;</td>'; 
		
		return $calendar."</tr></table>";
	} 


}

/* End of file calendar.php */
/* Location: ./czgaming/libraries/Calendar.php */
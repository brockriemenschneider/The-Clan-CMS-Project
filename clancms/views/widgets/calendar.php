<?php echo  $calendar . br(); ?>
<div class="calendar-legend">
	<ul>
		<li class="green">Match</li>
		<li class="red">Event</li>
		<li class="yellow">Today</li>
	</ul>
</div>
<div class="clear"></div>
<div class="yellow center">
	There are 
	<?php 
		if($events_count)  
			echo '<strong>' . $events_count . '</strong> events'; 
		
		if($events_count && $matches_count)
			echo ' and ';
			
		if($matches_count)
			echo '<strong>' . $matches_count . '</strong> matches';
	?> 
	this month.
</div>
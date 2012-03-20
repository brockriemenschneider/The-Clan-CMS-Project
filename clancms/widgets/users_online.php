<?php 
	echo 'Active Users:';
	echo br();
	echo number_format($total_users_online) . ' users and ' . number_format($total_guests_online) . ' guests';
			
	if($users_online):
		echo br();
		echo $users_online;
	endif;
?>
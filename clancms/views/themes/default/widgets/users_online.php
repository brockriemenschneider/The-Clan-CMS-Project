<div class="widget">

	<div class="header"></div>
		
	<div class="content">
		<div class="inside">
				
			<div class="subheader">
				<?php echo heading('Users Online: ' . number_format($total_users_online + $total_guests_online), 4); ?>
			</div>
			<?php 
				echo 'Active Users:';
				echo br();
				echo number_format($total_users_online) . ' users and ' . number_format($total_guests_online) . ' guests';
			
				if($users_online):
					echo br();
					echo $users_online;
				endif;
			?>
		</div>
	</div>
		
	<div class="footer"></div>
		
</div>
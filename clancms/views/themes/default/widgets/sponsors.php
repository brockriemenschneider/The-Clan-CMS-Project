<div class="widget">

	<div class="header"></div>
		
	<div class="content">
		<div class="inside">
				
			<div class="subheader">
				<?php echo heading('Sponsors', 4); ?>
			</div>
			
			<?php if($sponsors): ?>
				<?php foreach($sponsors as $sponsor): ?>
					<?php if($sponsor->sponsor_link): echo anchor($sponsor->sponsor_link, img(array('src' => IMAGES . $sponsor->sponsor_image, 'alt' => $sponsor->sponsor_title, 'title' => $sponsor->sponsor_title))); else: echo img(array('src' => IMAGES . $sponsor->sponsor_image, 'alt' => $sponsor->sponsor_title, 'title' => $sponsor->sponsor_title)); endif; ?>
				<?php endforeach; ?>
			<?php else: ?>
				<?php echo CLAN_NAME; ?> is currently not sponsored.
			<?php endif; ?>
				
		</div>
	</div>
		
	<div class="footer"></div>
		
</div>
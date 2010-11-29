<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">
	
	<div class="box">
		<div class="header">
			<?php echo heading('Sponsors', 4); ?>
		</div>
		
		<div class="content">
			<div class="inside">
				
			<?php if($sponsors): ?>
				<?php foreach($sponsors as $sponsor): ?>
				<div class="subheader">
					<?php echo heading($sponsor->sponsor_title, 4); ?>
				</div>
					<?php if($sponsor->sponsor_link): echo anchor($sponsor->sponsor_link, img(array('src' => IMAGES . 'sponsors/' . $sponsor->sponsor_image, 'alt' => $sponsor->sponsor_title, 'title' => $sponsor->sponsor_title))); else: echo img(array('src' => IMAGES . 'sponsors/' . $sponsor->sponsor_image, 'alt' => $sponsor->sponsor_title, 'title' => $sponsor->sponsor_title)); endif; ?>
				<?php echo $sponsor->sponsor_description; ?>
				<?php endforeach; ?>
			<?php else: ?>
				<?php echo CLAN_NAME; ?> is currently not sponsored.
			<?php endif; ?>
	
			</div>
		</div>
		
		<div class="footer"></div>
	</div>
	
</div>

<?php $this->load->view(THEME . 'footer'); ?>
<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

<div id="main">

	<div class="box">
		<div class="header">
			<?php echo heading($title, 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				<?php echo $message; ?>
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
	<div class="space"></div>
	
</div>

<?php $this->load->view(ADMINCP . 'footer'); ?>
<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">
	
	<div class="box">
		
		<div class="header">
			<?php echo heading($page->title, 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				<?php echo $page->content; ?>
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
</div>

<?php $this->load->view(THEME . 'footer'); ?>
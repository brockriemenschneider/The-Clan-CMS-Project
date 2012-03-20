<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">
	<div class="box">
		<div class="header"><?php echo heading('Event', 4); ?></div>
		<div class="content">
			<div class="inside">
			<pre><?php print_r($event); ?></pre>
			
			</div>
		</div>
		<div class="footer"></div>
	</div>
	<div class="space"></div>
</div>

<?php $this->load->view(THEME . 'footer'); ?>
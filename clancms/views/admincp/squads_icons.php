<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>


<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'squads', 'Squads'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'squads/add', 'Add Squad'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'squads/icons', 'Squad Icons'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header"><?php echo heading('Squad Icons', 4); ?></div>
		<div class="content">
			<div class="inside">
			<!-- Form Validation -->
				<?php if(validation_errors()): ?>
				<div class="alert">
					<?php echo validation_errors(); ?>
				</div>
				<?php endif; ?>
				<?php if($this->session->flashdata('message')): ?>
				<div class="alert">
					<?php echo $this->session->flashdata('message'); ?>
				</div>
				<?php endif; ?>
			<!-- End Validation -->
			

			<!-- Squad Icon Upload -->
				<div class="subheader"><?php echo heading('Upload New Icon', 4); ?></div>
				<div class="upload">
					<?php 
						echo form_open_multipart(ADMINCP . 'squads/icons');?>
					<label for="title">Icon Name</label> <input type="input" name="title" />
						<?php
						echo form_upload('userfile');
						echo form_submit('upload', 'Upload');
						echo form_close();
					 ?>
				</div>
				
				<hr>
				
				
			<!-- Squad Icon listings -->
				<div class="subheader"><?php echo heading('Current Icons', 4); ?></div>
				<div class="uploaded">
				
				<?php if($icons):?>
					<ul>
						<?php foreach($icons as $row) : ?>
							<li>
								<div class="icon"><?php echo img(array('src' => IMAGES . 'squad_icons/' . $row->icon)); ?></div>
								<div class="delete"><?php echo $actions = anchor(ADMINCP . 'squads/del_icon/' . $row->id, img(array('src' => THEME_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?></div>
							</li>
						<?php endforeach; ?>
				<?php else:?>
							<p>There are currently no squad icons.</p>
				<?php endif;?>
					</ul>
				</div>
				<div class="clear"></div>
				<hr />
			
			</div>	
				
		</div>
		<div class="footer"></div>
	</div>
	
</div>
	
<script type="text/javascript">
	function deleteConfirm()
	{
    	var answer = confirm("Are you sure you want to delete this squad's icon? Once deleted, there will be no way to recover it!")
    	if (answer)
		{
        	document.messages.submit();
    	}
    
    	return false;  
	} 
</script>
<?php $this->load->view(ADMINCP . 'footer'); ?>
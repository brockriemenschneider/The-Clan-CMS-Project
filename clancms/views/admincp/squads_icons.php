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
			
<style>
.upload {
    box-shadow: 0 0 5px #ccc inset;
    padding: 8px;
    border-radius: 7px;
}
.upload label {
    font-size: 18px;
    color: #cc0000;
    font-weight: bold;
    padding: 0 5px;
    line-height: 25px;
}
.uploaded {
    font-size: 18px;
}
.uploaded ul {
    list-style: none;
    box-shadow: 0 0 5px #e5e5e5 inset;
    border-radius: 8px;
    padding: 0;
}
.uploaded li {
    display: block;
    float: left;
    text-align: center;
    border: 1px solid #555;
    width: 100px;
    margin: 0 5px 5px;
}
.uploaded li .title {
    font-size: 12px;
    font-family: mw3;
    border-bottom: 1px solid #333;
}
.uploaded li .delete {
    border-top: 1px solid #333;
    padding: 1px 0;
}
</style>
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
							<li>There are currently no squad icons.</li>
				<?php endif;?>
					</ul>
				</div>
				<div class="clear"></div>
				<hr />
			
			</div>	
				
		</div>
		<div class="footer"></div>
	
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

</div>
<?php $this->load->view(ADMINCP . 'footer'); ?>
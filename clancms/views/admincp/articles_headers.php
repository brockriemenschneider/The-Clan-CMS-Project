<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>


<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles', 'Published'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/drafts', 'Drafts'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/add', 'Add Article'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/headers', 'News Headers'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header"><?php echo heading('News Headers', 4); ?></div>
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
.header_upload {
    box-shadow: 0 0 5px #ccc inset;
    padding: 8px;
    border-radius: 7px;
}
.header_upload label {
    font-size: 18px;
    color: #cc0000;
    font-weight: bold;
    padding: 0 5px;
    line-height: 25px;
}
.header_uploaded {
    font-size: 18px;
}
</style>
			<!-- Article Status -->
			
				<div class="subheader"><?php echo heading('Upload New Header', 4); ?></div>
				<div class="header_upload">
					<?php 
						echo form_open_multipart(ADMINCP . 'articles/headers');?>
					<label for="title">Title</label> <input type="input" name="title" />
						<?php
						echo form_upload('userfile');
						echo form_submit('upload', 'Upload');
						echo form_close();
					 ?>
				</div>
				
				<hr>
				
				
			<!-- Output All Game titles and headers -->
				<div class="subheader"><?php echo heading('Current Headers', 4); ?></div>
				<div class="header_uploaded">
				
				<?php if($games):?>
					<?php foreach($games as $row) : ?>
						<?php echo $row->title; ?>
						( <?php echo $actions = anchor(ADMINCP . 'articles/del_header/' . $row->id, 'Remove ' . img(array('src' => THEME_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?> ) <br />
						<?php echo img(array('src' => IMAGES . 'headers/' . $row->image)); ?><hr/>
					<?php endforeach; ?>
				<?php else:?>
					You have no uploaded news headers.
				<?php endif;?>
					
				</div>
			</div>	
				
		</div>
		<div class="footer"></div>
	
<script type="text/javascript">
	function deleteConfirm()
	{
    	var answer = confirm("Are you sure you want to delete this header? Once deleted, there will be no way to recover it!")
    	if (answer)
		{
        	document.messages.submit();
    	}
    
    	return false;  
	} 
</script>

</div>
<?php $this->load->view(ADMINCP . 'footer'); ?>
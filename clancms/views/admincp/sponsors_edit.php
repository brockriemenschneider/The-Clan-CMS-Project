<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

<?php echo form_open_multipart(ADMINCP . 'sponsors/edit/' . $sponsor->sponsor_id); ?>
<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'sponsors', 'Sponsors'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'sponsors/add', 'Add Sponsor'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'sponsors/edit/' . $sponsor->sponsor_id, 'Edit Sponsor: ' . $sponsor->sponsor_title); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Edit Sponsor: ' . $sponsor->sponsor_title, 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
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
			
				<?php if(isset($upload->errors)): ?>
				<div class="alert">
					<?php echo $upload->errors; ?>
				</div>
				<?php endif; ?>
				
				<div class="required-field required">Required Field</div>
				<?php echo br(); ?>
				
				<div class="subheader">
					<?php echo heading('Sponsor Information', 4); ?>
				</div>
		
				<div class="label required">Title</div>
				
				<?php 
				$data = array(
					'name'		=> 'title',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('title', $sponsor->sponsor_title)); ?>
				<?php echo br(); ?>
				<div class="description">The name of your sponsor</div>
		
				<div class="label">Link</div>
				
				<?php 
				$data = array(
					'name'		=> 'link',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('link', $sponsor->sponsor_link)); ?>
				<?php echo br(); ?>
				<div class="description">The link to the sponsor's website</div>
				
				<div class="label <?php if($sponsor->sponsor_image): echo ''; else: echo 'required'; endif; ?>">Image</div>
				
				<?php 
				$data = array(
					'name'		=> 'image',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_upload($data); ?>
				<?php echo br(); ?>
				<?php if($sponsor->sponsor_image): ?>
					<div class="description"><?php echo img(array('src' => IMAGES . 'sponsors/' . $sponsor->sponsor_image, 'alt' => $sponsor->sponsor_title, 'title' => $sponsor->sponsor_title)); ?></div>
				<?php endif; ?>
				<div class="description">The sponsor's logo</div>
				<?php echo br(); ?>
				
				<?php
				$data = array(
					'name'		=> 'description',
					'id'		=> 'wysiwyg',
					'rows'		=> '10',
					'cols'		=> '50'
				);
			
				echo form_textarea($data, set_value('description', $sponsor->sponsor_description)); ?>
				<?php echo br(); ?>
				<div class="description">Describe the sponsor</div>
				
				<div class="label required">Priority</div>
				
				<?php 
				$data = array(
					'name'		=> 'priority',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('priority', $sponsor->sponsor_priority)); ?>
				<?php echo br(); ?>
				<div class="description">The order in which this sponsor should appear</div>
				
				<?php 
					$data = array(
						'name'		=> 'update_sponsor',
						'class'		=> 'submit',
						'value'		=> 'Update Sponsor'
					);
				
				echo form_submit($data); ?>
				<div class="clear"></div>
		
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
</div>
<?php echo form_close(); ?>

<?php $this->load->view(ADMINCP . 'footer'); ?>
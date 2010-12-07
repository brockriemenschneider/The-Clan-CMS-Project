<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

<?php echo form_open_multipart(ADMINCP . 'sponsors/add'); ?>
<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'sponsors', 'Sponsors'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'sponsors/add', 'Add Sponsor'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Add Sponsor', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
				<?php if(validation_errors()): ?>
				<div class="alert">
					<?php echo validation_errors(); ?>
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

				echo form_input($data, set_value('title')); ?>
				<?php echo br(); ?>
				<div class="description">The name of your sponsor</div>
		
				<div class="label">Link</div>
				
				<?php 
				$data = array(
					'name'		=> 'link',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('link')); ?>
				<?php echo br(); ?>
				<div class="description">The link to the sponsor's website</div>
				
				<div class="label required">Image</div>
				
				<?php 
				$data = array(
					'name'		=> 'image',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_upload($data); ?>
				<?php echo br(); ?>
				<div class="description">The sponsor's logo</div>
				<?php echo br(); ?>
				
				<?php
				$data = array(
					'name'		=> 'description',
					'id'		=> 'wysiwyg',
					'rows'		=> '10',
					'cols'		=> '50'
				);
			
				echo form_textarea($data, set_value('description')); ?>
				<?php echo br(); ?>
				<div class="description">Describe the sponsor</div>
				
				<div class="label required">Priority</div>
				
				<?php 
				$data = array(
					'name'		=> 'priority',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('priority')); ?>
				<?php echo br(); ?>
				<div class="description">The order in which this sponsor should appear</div>
				
				<?php 
					$data = array(
						'name'		=> 'add_sponsor',
						'class'		=> 'submit',
						'value'		=> 'Add Sponsor'
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
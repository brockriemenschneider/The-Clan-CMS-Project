<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

<?php echo form_open_multipart(ADMINCP . 'squads/add'); ?>
<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'squads', 'Squads'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'squads/add', 'Add Squad'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Add Squad', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
				<?php if(validation_errors()): ?>
				<div class="alert">
					<?php echo validation_errors(); ?>
				</div>
				<?php endif; ?>
				
				<div class="required-field required">Required Field</div>
				<?php echo br(); ?>
				
				<div class="subheader">
					<?php echo heading('Squad Information', 4); ?>
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
				<div class="description">The name of your squad</div>
				
				<div class="label required">Tag Position</div>
				<?php
					$options = array(
						'0' => 'Left',
						'1'	=> 'Right'
					);
					
				echo form_dropdown('tag_position', $options, set_value('tag_position'), 'class="input"'); ?>
				<?php echo br(); ?>
				<div class="description">The position of the squad's tag</div>
				
				<div class="label">Tag</div>
				
				<?php 
				$data = array(
					'name'		=> 'tag',
					'size'		=> '10',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('tag')); ?>
				<?php echo br(); ?>
				<div class="description">The tag of your squad</div>
				
				<div class="label required">Status</div>
				<?php
					$options = array(
						'0' => 'Inactive',
						'1'	=> 'Active'
					);
					
				echo form_dropdown('status', $options, set_value('status', 1), 'class="input"'); ?>
				<?php echo br(); ?>
				<div class="description">The status of the squad</div>
				
				<div class="label required">Priority</div>
				
				<?php 
				$data = array(
					'name'		=> 'priority',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('priority')); ?>
				<?php echo br(); ?>
				<div class="description">The order in which this squad should appear</div>
				
				<?php 
					$data = array(
						'name'		=> 'add_squad',
						'class'		=> 'submit',
						'value'		=> 'Add Squad'
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
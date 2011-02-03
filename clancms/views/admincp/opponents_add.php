<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

<?php echo form_open(ADMINCP . 'opponents/add'); ?>
<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'opponents', 'Opponents'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'opponents/add', 'Add Opponent'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Add Opponent', 4); ?>
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
					<?php echo heading('Opponent Information', 4); ?>
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
				<div class="description">The name of the opponent</div>
				
				<div class="label">Link</div>
				<?php 
				$data = array(
					'name'		=> 'link',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('link')); ?>
				<?php echo br(); ?>
				<div class="description">The link to the opponent</div>
				
				<div class="label">Tag</div>
				
				<?php 
				$data = array(
					'name'		=> 'tag',
					'size'		=> '10',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('tag')); ?>
				<?php echo br(); ?>
				<div class="description">The opponent's clan tag</div>
				
				<?php 
					$data = array(
						'name'		=> 'add_opponent',
						'class'		=> 'submit',
						'value'		=> 'Add Opponent'
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
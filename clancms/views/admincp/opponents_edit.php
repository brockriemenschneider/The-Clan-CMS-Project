<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

<?php echo form_open(ADMINCP . 'opponents/edit/' . $opponent->opponent_id); ?>
<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'opponents', 'Opponents'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'opponents/add', 'Add Opponent'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'opponents/edit/' . $opponent->opponent_id, 'Edit Opponent: ' . $opponent->opponent_title); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Edit Opponent: ' . $opponent->opponent_title, 4); ?>
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

				echo form_input($data, set_value('title', $opponent->opponent_title)); ?>
				<?php echo br(); ?>
				<div class="description">The name of the opponent</div>
				
				<div class="label">Link</div>
				<?php 
				$data = array(
					'name'		=> 'link',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('link', $opponent->opponent_link)); ?>
				<?php echo br(); ?>
				<div class="description">The link to the opponent</div>
				
				<div class="label">Tag</div>
				
				<?php 
				$data = array(
					'name'		=> 'tag',
					'size'		=> '10',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('tag', $opponent->opponent_tag)); ?>
				<?php echo br(); ?>
				<div class="description">The opponent's clan tag</div>
				
				<?php 
					$data = array(
						'name'		=> 'update_opponent',
						'class'		=> 'submit',
						'value'		=> 'Update Opponent'
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
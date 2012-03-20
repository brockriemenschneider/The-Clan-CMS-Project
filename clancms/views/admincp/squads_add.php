<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

<?php echo form_open_multipart(ADMINCP . 'squads/add'); ?>
<div id="main">
<style>
.icons ul {
    height: 80px;
    list-style: none outside none;
    text-align: center;
    margin: 0 90px 0 275px;
    padding: 0;
}
.icons li {
    display: inline-block;
    float: left;
    width: 34px;
    border: 1px solid #444;
    margin: 0 2px 2px 0;
    padding: 0px 2px;
}
</style>
	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'squads', 'Squads'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'squads/add', 'Add Squad'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'squads/icons', 'Squad Icons'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Add Squad', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				<!-- Validation & Errors -->
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
				
				<!-- Squad Title -->
				<div class="label required">Title</div>
				
				<?php 
				$data = array(
					'name'		=> 'title',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('title')); ?>
				<div class="description">The name of the squad</div>
				
				<!-- Squad Status -->
				<div class="label required">Status</div>
				<?php
					$options = array(
						'0' => 'Inactive',
						'1'	=> 'Active'
					);
					
				echo form_dropdown('status', $options, set_value('status', 1), 'class="input"'); ?>
				<?php echo br(); ?>
				<div class="description">The status of the squad</div>
				
				
				<!-- Squad Priority -->
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
				
				<!-- Squad Icon selector -->
				<div class="label required">Squad Icon</div>
				<div class="icons">
					<?php if($icons): ?>
						<ul style="list-style:none;">
							<?php foreach($icons as $icon): ?>
								<li>
									<div><?php echo img(array('src'=> IMAGES. 'squad_icons/' . $icon->icon, 'height' =>32, 'width' =>32)); ?></div>
									<div><?php echo form_radio('icon', $icon->icon); ?></div>
								</li>
							<?php endforeach;?>
						</ul>
					<?php else: ?>
						<p>There are no squad icons. <?php echo anchor(ADMINCP . 'squads/icons', 'Add some here'); ?> </p>
					<?php endif; ?>
				</div>

				<div class="clear"></div>
		
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
</div>
<?php echo form_close(); ?>

<?php $this->load->view(ADMINCP . 'footer'); ?>
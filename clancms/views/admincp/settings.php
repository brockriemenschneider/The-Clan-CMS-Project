<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

<?php echo form_open(ADMINCP . 'settings'); ?>
<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'settings', 'Site Settings'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Edit Site Settings', 4); ?>
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
				
				<?php if($categories): ?>
				<?php foreach($categories as $category): ?>
				<div class="subheader">
					<?php echo heading($category->category_title, 4); ?>
				</div>
		
					<?php if($category->settings): ?>
					<?php foreach($category->settings as $setting): ?>
				<div class="label <?php if(strpos($setting->setting_rules,'required')): echo 'required'; endif; ?>"><?php echo $setting->setting_title; ?></div>
				
				<?php if($setting->setting_type == "text"): ?>
					<?php 
					$data = array(
						'name'		=> 'setting[' . $setting->setting_id . ']',
						'size'		=> '30',
						'class'		=> 'input'
					);

					echo form_input($data, set_value('setting[' . $setting->setting_id . ']', $setting->setting_value)); ?>
				<?php elseif($setting->setting_type == "timezone"): ?>
				
					<?php echo timezone_menu(set_value('setting[' . $setting->setting_id . ']', $setting->setting_value), 'input select', 'setting[' . $setting->setting_id . ']'); ?>
				
				<?php elseif($setting->setting_type == "select"): ?>
				
					<?php
					echo form_dropdown('setting[' . $setting->setting_id . ']', $setting->options, set_value('setting[' . $setting->setting_id . ']', $setting->setting_value), 'class="input select"'); ?>
				
				<?php elseif($setting->setting_type == "textarea"): ?>
				
					<?php
					$data = array(
						'name'		=> 'setting[' . $setting->setting_id . ']',
						'rows'		=> '20',
						'cols'		=> '50'
					);
			
					echo form_textarea($data, set_value('setting[' . $setting->setting_id . ']', $setting->setting_value)); ?>
				
				<?php endif; ?>
				
				<?php echo br(); ?>
				<div class="description"><?php echo $setting->setting_description; ?></div>
					<?php endforeach; ?>
					<?php else: ?>
						There are currently no settings for this category.
						<?php echo br(); ?>
					<?php endif; ?>
				<?php echo br(); ?>
				<?php endforeach; ?>
				<?php endif; ?>
				
				<?php 
					$data = array(
						'name'		=> 'update_settings',
						'class'		=> 'submit',
						'value'		=> 'Update Site Settings'
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
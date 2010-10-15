<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">
	
	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor('account/profile/' . $this->users->user_slug($user->user_name), $user->user_name); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('account/', 'My Account'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('My Account', 4); ?>
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
						<?php echo heading('Update Password', 4); ?>
				</div>
					
				<?php echo form_open('account'); ?>
				<div class="label required">Current Password</div> 
				<?php 
				$data = array(
					'name'		=> 'password',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_password($data); ?>
				<?php echo br(); ?>
				
				<div class="label required">New Password</div> 
				<?php 
				$data = array(
					'name'		=> 'new_password',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_password($data); ?>
				<?php echo br(); ?>
				<div class="description">Must be at least 8 characters long</div>
				
				<div class="label required">Re-type New Password</div> 
				<?php 
				$data = array(
					'name'		=> 'new_password_confirmation',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_password($data); ?>
				<?php echo br(); ?>
				
				<?php 
					$data = array(
						'name'		=> 'update_password',
						'class'		=> 'submit',
						'value'		=> 'Update Password'
					);
				
				echo form_submit($data); ?>
				<?php echo form_close(); ?>
				
				<div class="clear"></div>
				<?php echo br(); ?>
				
				<?php echo form_open('account'); ?>
				<div class="subheader">
						<?php echo heading('Update Email', 4); ?>
				</div>
				
				<div class="label">Current Email:</div>
				<div class="details"><?php echo $user->user_email; ?></div>
				<div class="clear"></div>
				
				<div class="label required">New Email</div>
				<?php 
				$data = array(
					'name'		=> 'new_email',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('new_email')); ?>
				<?php echo br(); ?>
				
				<div class="label required">Re-type New Email</div>
				<?php 
				$data = array(
					'name'		=> 'new_email_confirmation',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('new_email_confirmation')); ?>
				<?php echo br(); ?>
				
				<?php 
					$data = array(
						'name'		=> 'update_email',
						'class'		=> 'submit',
						'value'		=> 'Update Email'
					);
				
				echo form_submit($data); ?>
				<?php echo form_close(); ?>
				
				<div class="clear"></div>
				<?php echo br(); ?>
				
				<div class="subheader">
						<?php echo heading('Preferences', 4); ?>
				</div>
				
				<?php echo form_open('account'); ?>
				<div class="label required">Timezone</div> 
				<?php echo timezone_menu(set_value('timezone', $user->user_timezone), 'input select', 'timezone'); ?>
				<?php echo br(); ?>
				
				<div class="label required">Daylight Savings</div> 
				<?php 
				$options = array(
					'2'		=> 'Automatically Detect',
					'1'		=> 'Yes',
					'0'		=> 'No'
				);

				echo form_dropdown('daylight_savings', $options, set_value('daylight_savings', $user->user_daylight_savings), 'class="input select"'); ?>
				<?php echo br(); ?>
				
				<?php 
					$data = array(
						'name'		=> 'update_preferences',
						'class'		=> 'submit',
						'value'		=> 'Update Preferences'
					);
				
				echo form_submit($data); ?>
				
				<div class="clear"></div>
				<?php echo form_close(); ?>
	
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
</div>


<?php $this->load->view(THEME . 'footer'); ?>
<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<?php echo form_open('register'); ?>
<div id="main">
	
	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor('account/login', 'Login'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('register', 'Register'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor('account/forgot', 'Forgot Account Info'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Register', 4); ?>
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
						<?php echo heading('Account Information', 4); ?>
				</div>
					
				<div class="label required">Username:</div>
				<?php 
				$data = array(
					'name'		=> 'username',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('username')); ?>
				<?php echo br(); ?>
				<div class="description">Valid characters: A-Z, a-z, 0-9, space ( ), underscore (_), dash (-)</div>
				
				<div class="label required">Email:</div>
				<?php 
				$data = array(
					'name'		=> 'email',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('email')); ?>
				<?php echo br(); ?>
				<div class="description">We'll send a verification code to this e-mail address!</div>
				
				<div class="label required">Re-type Email:</div>
				<?php 
				$data = array(
					'name'		=> 'email_confirmation',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('email_confirmation')); ?>
				<?php echo br(); ?>
				
				<div class="label required">Password:</div> 
				<?php 
				$data = array(
					'name'		=> 'password',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_password($data); ?>
				<?php echo br(); ?>
				<div class="description">Must be at least 8 characters long</div>
				
				<div class="label required">Re-type Password:</div> 
				<?php 
				$data = array(
					'name'		=> 'password_confirmation',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_password($data); ?>
				<?php echo br(); ?>
				
				<div class="subheader">
						<?php echo heading('Preferences', 4); ?>
				</div>
				
				<div class="label required">Timezone:</div> 
				<?php echo timezone_menu(set_value('timezone', $this->ClanCMS->get_setting('default_timezone')), 'input select', 'timezone'); ?>
				<?php echo br(); ?>
				
				<div class="label required">Daylight Savings:</div> 
				<?php 
				$options = array(
					'2'		=> 'Automatically Detect',
					'1'		=> 'Yes',
					'0'		=> 'No'
				);

				echo form_dropdown('daylight_savings', $options, set_value('daylight_savings'), 'class="input select"'); ?>
				<?php echo br(); ?>
				
				<div class="subheader">
						<?php echo heading('Image Verification', 4); ?>
				</div>
				
				<div class="label required">Please enter the words to help prevent spam and fake registrations. This is NOT case sensitive.</div>
				<div class="details"><?php echo $captcha["image"]; ?></div>
				<div class="clear"></div>
				
				<div class="label required">Captcha:</div>
				<?php 
				$data = array(
					'name'		=> 'captcha',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('captcha')); ?>
				<?php echo br(); ?>
				
				<?php 
					$data = array(
						'name'		=> 'register',
						'class'		=> 'submit',
						'value'		=> 'Register'
					);
				
				echo form_submit($data); ?>
				
				<div class="clear"></div>
	
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
</div>
<?php echo form_close(); ?>

<?php $this->load->view(THEME . 'footer'); ?>
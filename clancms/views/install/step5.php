<?php $this->load->view('install/header'); ?>

<?php echo form_open('install/step5'); ?>
<div id="main">
	
	<div class="box">
		
		<div class="header">
			<?php echo heading('Step 5: Account Registration', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
				<?php if(validation_errors()): ?>
				<div class="alert">
					<?php echo validation_errors(); ?>
				</div>
				<?php endif; ?>
				
				<?php if($this->session->userdata('message')): ?>
				<div class="alert">
					<?php echo $this->session->userdata('message'); ?>
				</div>
				<?php endif; ?>
				
				<div class="required-field required">Required Field</div>
				<?php echo br(); ?>
				<div class="subheader">
						<?php echo heading('Account Information', 4); ?>
				</div>

				<div class="label required">User Name:</div>
				<?php 
				$data = array(
					'name'		=> 'username',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('username', '')); ?>
				<?php echo br(); ?>
				<div class="description">Valid characters: A-Z, a-z, 0-9, space ( ), underscore (_), dash (-)</div>
				
				<div class="label required">Email:</div>
				<?php 
				$data = array(
					'name'		=> 'email',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('email', '')); ?>
				<?php echo br(); ?>

				<div class="label required">Password:</div>
				<?php 
				$data = array(
					'name'		=> 'password',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_password($data, ''); ?>
				<?php echo br(); ?>
				<div class="description">Must be at least 8 characters long</div>
				
				<div class="label required">Re-type Password:</div>
				<?php 
				$data = array(
					'name'		=> 'password_confirmation',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_password($data, ''); ?>
				<?php echo br(); ?>
				
				<div class="label required">Default Timezone:</div>
				<?php echo timezone_menu(set_value('user_timezone', $this->session->userdata('timezone')), 'select input', 'user_timezone'); ?>
				<?php echo br(); ?>

				<div class="label required">Daylight Savings:</div>
				<?php 
				$options = array(
					'2'		=> 'Automatically Detect',
					'1'		=> 'Yes',
					'0'		=> 'No'
				);

				echo form_dropdown('user_daylight_savings', $options, set_value('daylight_savings'), 'class="select input"'); ?>
				<?php echo br(); ?>
			
				<?php 
					$data = array(
						'name'		=> 'step5',
						'class'		=> 'submit',
						'value'		=> 'Installation Completed!'
					);
				
				echo form_submit($data); ?>
				
				<div class="clear"></div>
	
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
</div>
<?php echo form_close(); ?>

<?php $this->load->view('install/footer'); ?>
<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">
	
	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor('account/login', 'Login'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor('register', 'Register'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('account/forgot', 'Forgot Account Info'); ?></span><span class="right"></span></li>
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
				
				<div class="required-field required">Required Field</div>
				<?php echo br(); ?>
				<div class="subheader">
						<?php echo heading('Reset Password', 4); ?>
				</div>
					
				<?php echo form_open('account/reset/' . $user->reset_code . '/user/' . $user->user_id); ?>
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
						'name'		=> 'reset_password',
						'class'		=> 'submit',
						'value'		=> 'Reset Password'
					);
				
				echo form_submit($data); ?>
				<?php echo form_close(); ?>
				<div class="clear"></div>
	
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
</div>


<?php $this->load->view(THEME . 'footer'); ?>
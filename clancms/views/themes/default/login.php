<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<?php echo form_open('account/login'); ?>
<div id="main">
	
	<div class="box">
		<div class="tabs">
		<ul>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('account/login', 'Login'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor('register', 'Register'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor('account/forgot', 'Forgot Account Info'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Login', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
				<?php if(validation_errors()): ?>
				<div class="alert">
					<?php echo validation_errors(); ?>
				</div>
				<?php endif; ?>
				
				<div class="required-field required">Required Field</div>
				<br />
		
				<div class="label required">Username:</div>
				<?php 
				$data = array(
					'name'		=> 'username',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('username')); ?>
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
				
				<div class="label"></div><?php
					$data = array(
						'name'		=> 'remember',
						'value'		=> '1',
						'class'		=> 'input'
					);
					
					echo form_checkbox($data); ?> Remember me?
				<?php echo br(); ?>
				<?php echo form_hidden('redirect', $this->session->userdata('previous')); ?>
				<?php 
					$data = array(
						'name'		=> 'login',
						'class'		=> 'submit',
						'value'		=> 'Login'
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
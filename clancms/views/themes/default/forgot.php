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
			<?php echo heading('Retrieve Account Info', 4); ?>
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
		
				<?php echo form_open('account/forgot'); ?>
				<div class="label required">Email:</div>
				<?php 
				$data = array(
					'name'		=> 'email',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('email')); ?>
				<?php echo br(); ?>
				<div class="description">Please provide the email address for your account and your login information will be sent to you.</div>

				<?php 
					$data = array(
						'name'		=> 'retrieve',
						'class'		=> 'submit',
						'value'		=> 'Retrieve Account Info'
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
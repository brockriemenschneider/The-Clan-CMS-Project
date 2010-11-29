<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

<script type="text/javascript">
$(function() {

	$("input[name='password_generate']").change( function() {
		if($("input[name='password_generate']:checked").val() == 1)
		{
			$('#passwords').hide();
		}
		else
		{
			$('#passwords').show();
		}
	});
	
	if($("input[name='password_generate']:checked").val() == 1)
	{
		$('#passwords').hide();
	}
});		
</script> 

<?php echo form_open_multipart(ADMINCP . 'users/add'); ?>
<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'users', 'Users'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'users/add', 'Add User'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Add User', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
				<?php if(validation_errors()): ?>
				<div class="alert">
					<?php echo validation_errors(); ?>
				</div>
				<?php endif; ?>
					
				<?php if(isset($upload->errors)): ?>
				<div class="alert">
					<?php echo $upload->errors; ?>
				</div>
				<?php endif; ?>
				
				<div class="required-field required">Required Field</div>
				<?php echo br(); ?>
				<div class="subheader">
						<?php echo heading('Account Information', 4); ?>
				</div>
				
				<div class="label required">User Group</div>
				<?php
					
					$options = array('' => 'Choose a User Group...',);
					if($groups):
						foreach($groups as $group):
							$options = $options + array($group->group_id	=>	$group->group_title);
						endforeach;
					endif;
					
				echo form_dropdown('usergroup', $options, set_value('usergroup'), 'class="input select"'); ?>
				<?php echo br(); ?>
				<div class="description">What user group should this user be in?</div>
				
				<div class="label required">Activated</div> 
				<?php 
				$options = array(
					'0'		=> 'No',
					'1'		=> 'Yes'
				);

				echo form_dropdown('activation', $options, set_value('activation'), 'class="input select"'); ?>
				<?php echo br(); ?>
				<div class="description">Has this user been verified?</div>
				
				<div class="label required">Username</div>
				<?php 
				$data = array(
					'name'		=> 'username',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('username')); ?>
				<?php echo br(); ?>
				<div class="description">Valid characters: A-Z, a-z, 0-9, space ( ), underscore (_), dash (-)</div>
				
				<div class="label required">Email</div>
				<?php 
				$data = array(
					'name'		=> 'email',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('email')); ?>
				<?php echo br(); ?>
				
				<div class="label required">Re-type Email</div>
				<?php 
				$data = array(
					'name'		=> 'email_confirmation',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('email_confirmation')); ?>
				<?php echo br(); ?>
				
				<div class="label required">Generate Password?</div>
				
				Yes
				<input type="radio" name="password_generate" value="1" <?php echo set_radio('password_generate', '1', TRUE); ?> class="input" />
				No
				<input type="radio" name="password_generate" value="0" <?php echo set_radio('password_generate', '0'); ?> class="input" />
				
				<?php echo br(); ?>
				<div class="description">Do you want to generate a password?</div>
				
				<div id="passwords">
				<div class="label required">Password</div> 
				<?php 
				$data = array(
					'name'		=> 'password',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_password($data); ?>
				<?php echo br(); ?>
				<div class="description">Must be at least 8 characters long</div>
				
				<div class="label required">Re-type Password</div> 
				<?php 
				$data = array(
					'name'		=> 'password_confirmation',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_password($data); ?>
				</div>
				<?php echo br(); ?>
				
				<div class="subheader">
						<?php echo heading('Preferences', 4); ?>
				</div>
				
				<div class="label">Avatar</div>
				
				<?php 
				$data = array(
					'name'		=> 'avatar',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_upload($data); ?>
				<?php echo br(); ?>
				
				<div class="label required">Timezone</div> 
				<?php echo timezone_menu(set_value('timezone', $this->ClanCMS->get_setting('default_timezone')), 'input select', 'timezone'); ?>
				<?php echo br(); ?>
				
				<div class="label required">Daylight Savings</div> 
				<?php 
				$options = array(
					'2'		=> 'Automatically Detect',
					'1'		=> 'Yes',
					'0'		=> 'No'
				);

				echo form_dropdown('daylight_savings', $options, set_value('daylight_savings'), 'class="input select"'); ?>
				<?php echo br(); ?>
				<?php 
					$data = array(
						'name'		=> 'add_user',
						'class'		=> 'submit',
						'value'		=> 'Add User'
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
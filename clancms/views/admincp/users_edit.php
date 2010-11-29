<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

<script type="text/javascript">
$(function() {

	$("input[name='new_password']").change( function() {
		if($("input[name='new_password']:checked").val() != 1)
		{
			$('#passwords').hide();
		}
		else
		{
			$('#passwords').show();
		}
	});
	
	if($("input[name='new_password']:checked").val() == 0)
	{
		$('#passwords').hide();
	}
});		
</script> 

<?php echo form_open_multipart(ADMINCP . 'users/edit/' . $user->user_id); ?>
<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'users', 'Users'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'users/add', 'Add User'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'users/edit/' . $user->user_id, 'Edit User: ' . $user->user_name); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Edit User: ' . $user->user_name, 4); ?>
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
					
				echo form_dropdown('usergroup', $options, set_value('usergroup', $user->group_id), 'class="input select"'); ?>
				<?php echo br(); ?>
				<div class="description">What user group should this user be in?</div>
				
				<div class="label required">Activated</div> 
				<?php 
				$options = array(
					'0'		=> 'No',
					'1'		=> 'Yes'
				);

				echo form_dropdown('activation', $options, set_value('activation', $user->user_activation), 'class="input select"'); ?>
				<?php echo br(); ?>
				<div class="description">Has this user been verified?</div>
				
				<div class="label required">Username</div>
				<div class="details"><?php echo $user->user_name; ?></div>
				<div class="clear"></div>
				
				<div class="label">New Username</div>
				<?php 
				$data = array(
					'name'		=> 'new_username',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('new_username')); ?>
				<?php echo br(); ?>
				<div class="description">Valid characters: A-Z, a-z, 0-9, space ( ), underscore (_), dash (-)</div>
				
				<div class="label required">Current Email</div>
				<div class="details"><?php echo $user->user_email; ?></div>
				<div class="clear"></div>
				
				<div class="label">New Email</div>
				<?php 
				$data = array(
					'name'		=> 'new_email',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('new_email')); ?>
				<?php echo br(); ?>
				
				<div class="label required">New Password?</div>
				
				<input type="radio" name="new_password" value="2" <?php echo set_radio('new_password', '2'); ?> class="input" />
				Yes (auto generate)
				<input type="radio" name="new_password" value="1" <?php echo set_radio('new_password', '1'); ?> class="input" />
				Yes (manual)
				<input type="radio" name="new_password" value="0" <?php echo set_radio('new_password', '0', TRUE); ?> class="input" />
				No
				<?php echo br(); ?>
				
				<div id="passwords">
				<div class="label">New Password</div> 
				<?php 
				$data = array(
					'name'		=> 'password',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_password($data); ?>
				<?php echo br(); ?>
				<div class="description">Must be at least 8 characters long</div>
				
				<div class="label">Re-type New Password</div> 
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
				
				<?php echo form_open_multipart('account'); ?>
				<div class="label">Avatar</div>
				
				<?php 
				$data = array(
					'name'		=> 'avatar',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_upload($data); ?>
				<?php echo br(); ?>
				<div class="description">
					<div id="avatar">
					<?php if($user->user_avatar): ?>
						<?php echo anchor('account/profile/' . $this->users->user_slug($this->session->userdata('username')), img(array('src' => IMAGES . 'avatars/' . $user->user_avatar, 'title' => $this->session->userdata('username'), 'alt' => $this->session->userdata('username'), 'width' => '57', 'height' => '57'))); ?>
					<?php else: ?>
						<?php echo anchor('account/profile/' . $this->users->user_slug($this->session->userdata('username')), img(array('src' => ADMINCP_URL . 'images/avatar_none.png', 'title' => $this->session->userdata('username'), 'alt' => $this->session->userdata('username'), 'width' => '57', 'height' => '57'))); ?>
					<?php endif; ?>
					</div>
				</div>
				<?php echo br(); ?>
				
				<div class="label required">Timezone</div> 
				<?php echo timezone_menu(set_value('timezone', $this->ClanCMS->get_setting('default_timezone'), $user->user_timezone), 'input select', 'timezone'); ?>
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
				
				<div class="label required">IP Address</div>
				<?php 
				$data = array(
					'name'		=> 'ipaddress',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('ipaddress', $user->user_ipaddress)); ?>
				<?php echo br(); ?>
				
				<div class="label">Joined</div>
				<div class="details"><?php echo mdate("%F %j%S, %Y", $user->joined); ?></div>
				<div class="clear"></div>
				
				<?php 
					$data = array(
						'name'		=> 'update_user',
						'class'		=> 'submit',
						'value'		=> 'Update User'
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
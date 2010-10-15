<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

<script type="text/javascript">
$(function() {

	$("input[name='administrator']").change( function() {
		if($("input[name='administrator']:checked").val() == 0)
		{
			$('#permissions').hide();
		}
		else
		{
			$('#permissions').show();
		}
	});
	
	if($("input[name='administrator']:checked").val() == 0)
	{
		$('#permissions').hide();
	}
	$("input[name='clan']").change( function() {
		if($("input[name='clan']:checked").val() == 0)
		{
			alert('All squad members in this user group will be removed!');
		}
	});
});		
</script> 

<?php echo form_open(ADMINCP . 'usergroups/edit/' . $group->group_id); ?>
<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'usergroups', 'User Groups'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'usergroups/add', 'Add User Group'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'usergroups/edit/' . $group->group_id, 'Edit User Group: ' . $group->group_title); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Edit User Group: ' . $group->group_title, 4); ?>
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
					<?php echo heading('User Group Information', 4); ?>
				</div>
		
				<div class="label required">Title</div>
				
				<?php 
				$data = array(
					'name'		=> 'title',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('title', $group->group_title)); ?>
				<?php echo br(); ?>
				<div class="description">The name of your user group</div>
		
				<div class="label required">User Title</div>
				
				<?php 
				$data = array(
					'name'		=> 'user_title',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('user_title', $group->group_user_title)); ?>
				<?php echo br(); ?>
				<div class="description">The user title for the users in this user group</div>
				
				<div class="label required">Is Administrator?</div>

				Yes
				<input type="radio" name="administrator" value="1" <?php if($group->group_default): if((bool) $group->group_administrator): echo 'checked="checked"'; endif; else: echo set_radio('administrator', '1', (bool) $group->group_administrator); endif; ?> class="input" <?php if($group->group_default): echo 'DISABLED'; endif; ?> />
				No
				<input type="radio" name="administrator" value="0" <?php if($group->group_default): if((bool) !$group->group_administrator): echo 'checked="checked"'; endif; else: echo set_radio('administrator', '0', (bool) !$group->group_administrator); endif; ?> class="input" <?php if($group->group_default): echo 'DISABLED'; endif; ?> />
				
				<?php echo br(); ?>
				<div class="description">Are the users in this user group administrators?</div>
				
				<div class="label required">Clan Members?</div>
				Yes
				<input type="radio" name="clan" value="1" <?php if($group->group_default): if((bool) $group->group_clan): echo 'checked="checked"'; endif; else: echo set_radio('clan', '1', (bool) $group->group_clan); endif; ?> class="input" <?php if($group->group_default): echo 'DISABLED'; endif; ?> />
				No
				<input type="radio" name="clan" value="0" <?php if($group->group_default): if((bool) !$group->group_clan): echo 'checked="checked"'; endif; else: echo set_radio('clan', '0', (bool) !$group->group_clan); endif; ?> class="input" <?php if($group->group_default): echo 'DISABLED'; endif; ?> />
				
				<?php echo br(); ?>
				<div class="description">Are the users in this user group clan members?</div>
				
				<div class="label required">Banned?</div>
				
				Yes
				<input type="radio" name="banned" value="1" <?php if($group->group_default): if((bool) $group->group_banned): echo 'checked="checked"'; endif; else: echo set_radio('banned', '1', (bool) $group->group_banned); endif; ?> class="input" <?php if($group->group_default): echo 'DISABLED'; endif; ?> />
				No
				<input type="radio" name="banned" value="0" <?php if($group->group_default): if((bool) !$group->group_banned): echo 'checked="checked"'; endif; else: echo set_radio('banned', '0', (bool) !$group->group_banned); endif; ?> class="input" <?php if($group->group_default): echo 'DISABLED'; endif; ?> />
				
				<?php echo br(); ?>
				<div class="description">Are the users in this user group banned?</div>
				
				<div id="permissions">
				<?php echo br(); ?>
				<div class="subheader">
					<?php echo heading('Administrator Permissions', 4); ?>
				</div>
				
				<?php if($permissions): ?>
					<?php foreach($permissions as $permission): ?>
					<div class="label required"><?php echo $permission->permission_title; ?></div>
				
					Yes
					<input type="radio" name="permission[<?php echo $permission->permission_id; ?>]" value="1" <?php if($group->group_default): if((bool) $permission->permission[$permission->permission_id]): echo 'checked="checked"'; endif; else: echo set_radio('permission[' . $permission->permission_id . ']', '1', (bool) $permission->permission[$permission->permission_id]); endif; ?> class="input" <?php if($group->group_default): echo 'DISABLED'; endif; ?> />
					No
					<input type="radio" name="permission[<?php echo $permission->permission_id; ?>]" value="0" <?php if($group->group_default): if((bool) !$permission->permission[$permission->permission_id]): echo 'checked="checked"'; endif; else: echo set_radio('permission[' . $permission->permission_id . ']', '0', (bool) !$permission->permission[$permission->permission_id]); endif; ?> class="input" <?php if($group->group_default): echo 'DISABLED'; endif; ?> />
				
					<?php echo br(); ?>
					<?php endforeach; ?>
				<?php endif; ?>
				</div>

				<?php 
					$data = array(
						'name'		=> 'update_group',
						'class'		=> 'submit',
						'value'		=> 'Update User Group'
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
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
});		
</script> 

<?php echo form_open(ADMINCP . 'usergroups/add'); ?>
<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'usergroups', 'User Groups'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'usergroups/add', 'Add User Group'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Add User Group', 4); ?>
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
					<?php echo heading('User Group Information', 4); ?>
				</div>
		
				<div class="label required">Title</div>
				
				<?php 
				$data = array(
					'name'		=> 'title',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('title')); ?>
				<?php echo br(); ?>
				<div class="description">The name of your user group</div>
		
				<div class="label required">User Title</div>
				
				<?php 
				$data = array(
					'name'		=> 'user_title',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('user_title')); ?>
				<?php echo br(); ?>
				<div class="description">The user title for the users in this user group</div>
				
				<div class="label required">Is Administrator?</div>
				
				Yes
				<input type="radio" name="administrator" value="1" <?php echo set_radio('administrator', '1'); ?> class="input" />
				No
				<input type="radio" name="administrator" value="0" <?php echo set_radio('administrator', '0', TRUE); ?> class="input" />
				
				<?php echo br(); ?>
				<div class="description">Are the users in this user group administrators?</div>
				
				<div class="label required">Clan Members?</div>
				
				Yes
				<input type="radio" name="clan" value="1" <?php echo set_radio('clan', '1'); ?> class="input" />
				No
				<input type="radio" name="clan" value="0" <?php echo set_radio('clan', '0', TRUE); ?> class="input" />
				
				<?php echo br(); ?>
				<div class="description">Are the users in this user group clan members?</div>
				
				<div class="label required">Banned?</div>
				
				Yes
				<input type="radio" name="banned" value="1" <?php echo set_radio('banned', '1'); ?> class="input" />
				No
				<input type="radio" name="banned" value="0" <?php echo set_radio('banned', '0', TRUE); ?> class="input" />
				
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
					<input type="radio" name="permission[<?php echo $permission->permission_id; ?>]" value="1" <?php echo set_radio('permission[' . $permission->permission_id . ']', '1'); ?> class="input" />
					No
					<input type="radio" name="permission[<?php echo $permission->permission_id; ?>]" value="0" <?php echo set_radio('permission[' . $permission->permission_id . ']', '0', TRUE); ?> class="input" />
				
					<?php echo br(); ?>
					<?php endforeach; ?>
				<?php endif; ?>
				</div>
				
				<?php 
					$data = array(
						'name'		=> 'add_group',
						'class'		=> 'submit',
						'value'		=> 'Add User Group'
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
<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

 <script type="text/javascript">
	function deleteConfirm()
	{
    	var answer = confirm("Are you sure you want to delete this user group? Once deleted, there will be no way to recover the user group and all users in this user group will be moved back to the default user group!")
    	if (answer)
		{
        	document.messages.submit();
    	}
    
    	return false;  
	} 
</script> 

<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'usergroups', 'User Groups'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'usergroups/add', 'Add User Group'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Default User Groups', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
			
			<?php if($this->session->flashdata('message')): ?>
				<div class="alert">
					<?php echo $this->session->flashdata('message'); ?>
				</div>
				<?php echo br(); ?>
			<?php endif; ?>
			
			<table>
				<thead>
					<tr>
						<th width="25%">Usergroup</th>
						<th width="25%">User Title</th>
						<th width="20%"># Of Users</th>
						<th width="20%">Is Administrator?</th>
						<th width="10%">Actions</th>
					</tr>
				</thead>
			
				<tbody>
					<?php if($default_groups): ?>
						<?php foreach($default_groups as $default_group): ?>
						<tr>
							<td><?php echo anchor(ADMINCP . 'usergroups/edit/' . $default_group->group_id, $default_group->group_title); ?></td>
							<td><?php echo $default_group->group_user_title; ?></td>
							<td><?php echo $default_group->total_users; ?></td>
							<td><?php if((bool) $default_group->group_administrator): echo 'Yes'; else: echo 'No'; endif; ?></td>
							<td><?php echo anchor(ADMINCP . 'usergroups/edit/' . $default_group->group_id, img(array('src' => ADMINCP_URL . 'images/edit.png', 'alt' => 'Edit')), array('title' => 'Edit')); ?></td>
						</tr>
						<?php endforeach; ?>
					<?php else: ?>
					<tr>
						<td colspan="5">There are currently no default usergroups. Click <?php echo anchor(ADMINCP . 'usergroups/add', 'Add User Group'); ?> to add one.</td>
					</tr>
					<?php endif; ?>
				</tbody>
			</table>
		
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
	<div class="space"></div>
	
	<div class="box">
		
		<div class="header">
			<?php echo heading('Custom User Groups', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
			
			<table>
				<thead>
					<tr>
						<th width="25%">Usergroup</th>
						<th width="25%">User Title</th>
						<th width="20%"># Of Users</th>
						<th width="20%">Is Administrator?</th>
						<th width="10%">Actions</th>
					</tr>
				</thead>
			
				<tbody>
					<?php if($custom_groups): ?>
						<?php foreach($custom_groups as $custom_group): ?>
						<tr>
							<td><?php echo anchor(ADMINCP . 'usergroups/edit/' . $custom_group->group_id, $custom_group->group_title); ?></td>
							<td><?php echo $custom_group->group_user_title; ?></td>
							<td><?php echo $custom_group->total_users; ?></td>
							<td><?php if((bool) $custom_group->group_administrator): echo 'Yes'; else: echo 'No'; endif; ?></td>
							<td><?php echo anchor(ADMINCP . 'usergroups/edit/' . $custom_group->group_id, img(array('src' => ADMINCP_URL . 'images/edit.png', 'alt' => 'Edit')), array('title' => 'Edit')); ?> <?php echo anchor(ADMINCP . 'usergroups/delete/' . $custom_group->group_id, img(array('src' => ADMINCP_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?></td>
						</tr>
						<?php endforeach; ?>
					<?php else: ?>
					<tr>
						<td colspan="5">There are currently no custom usergroups. Click <?php echo anchor(ADMINCP . 'usergroups/add', 'Add User Group'); ?> to add one.</td>
					</tr>
					<?php endif; ?>
				</tbody>
			</table>
		
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
</div>

<?php $this->load->view(ADMINCP . 'footer'); ?>
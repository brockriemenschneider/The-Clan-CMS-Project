<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'users', 'Users'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'users/add', 'Add User'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Users', 4); ?>
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
					<th width="20%">Username</th>
					<th width="25%">User Group</th>
					<th width="30%">Email</th>
					<th width="15%">IP Address</th>
					<th width="10%">Actions</th>
				</tr>
			</thead>
			
			<tbody>
				<?php if($users): ?>
					<?php foreach($users as $user): ?>
					<tr <?php if($user->user_id == $this->session->userdata('user_id')): echo 'class="selected"'; endif; ?>>
						<td><?php echo anchor(ADMINCP . 'users/edit/' . $user->user_id, $user->user_name); ?></td>
						<td><?php echo anchor(ADMINCP . 'usergroups/edit/' . $user->group_id, $user->group); ?></td>
						<td><?php echo safe_mailto($user->user_email); ?></td>
						<td><?php echo $user->user_ipaddress; ?></td>
						<td><?php if(($user->user_id != SUPERADMINISTRATOR OR ($user->user_id == SUPERADMINISTRATOR && $user->user_id == $this->session->userdata('user_id')))): echo anchor(ADMINCP . 'users/edit/' . $user->user_id, img(array('src' => ADMINCP_URL . 'images/edit.png', 'alt' => 'Edit')), array('title' => 'Edit')); ?> <?php echo anchor(ADMINCP . 'users/delete/' . $user->user_id, img(array('src' => ADMINCP_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete')); endif; ?></td>
					</tr>
					<?php endforeach; ?>
				<?php else: ?>
					<tr>
						<td colspan="5">There are currently no users. Click <?php echo anchor(ADMINCP . 'users/add', 'Add User'); ?> to add one.</td>
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
		<div class="pages">
			<?php echo heading($pages, 4); ?>
		</div>
	</div>
	
</div>

<?php $this->load->view(ADMINCP . 'footer'); ?>
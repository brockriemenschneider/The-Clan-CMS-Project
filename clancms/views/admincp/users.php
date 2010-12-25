<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

<script type="text/javascript">
	function deleteConfirm()
	{
    	var answer = confirm("Are you sure you want to delete this user? Once deleted there will be no way to recover the user and their stats!")
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
						<td><?php if(($user->user_id != SUPERADMINISTRATOR OR ($user->user_id == SUPERADMINISTRATOR && $user->user_id == $this->session->userdata('user_id')))): echo anchor(ADMINCP . 'users/edit/' . $user->user_id, img(array('src' => ADMINCP_URL . 'images/edit.png', 'alt' => 'Edit')), array('title' => 'Edit')); endif; ?><?php if($user->user_id != SUPERADMINISTRATOR): echo anchor(ADMINCP . 'users/delete/' . $user->user_id, img(array('src' => ADMINCP_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); endif; ?></td>
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
	
	<div class="box">
		<div class="pages">
		<ul>
			<?php if($pages): ?>
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'users/page/' . $pages->current_page, 'Page ' . $pages->current_page . ' of ' . $pages->total_pages); ?></span><span class="right"></span></li>
					<?php if($pages->first): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'users/page/1', '<<'); ?></span><span class="right"></span></li><?php endif; ?>
					<?php if($pages->previous): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'users/page/' . ($pages->current_page - 1), '<'); ?></span><span class="right"></span></li><?php endif; ?>
				
				<?php if($pages->before): ?>
					<?php foreach($pages->before as $before): ?>
						<li <?php if($pages->current_page == $before): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'users/page/' . $before, $before); ?></span><span class="right"></span></li>
					<?php endforeach; ?>
				<?php endif; ?>
				
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'users/page/' . $pages->current_page, $pages->current_page); ?></span><span class="right"></span></li>
				
				<?php if($pages->after): ?>
					<?php foreach($pages->after as $after): ?>
						<li <?php if($pages->current_page == $after): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'users/page/' . $after, $after); ?></span><span class="right"></span></li>
					<?php endforeach; ?>
				<?php endif; ?>
				
					<?php if($pages->next): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'users/page/' . ($pages->current_page + 1), '>'); ?></span><span class="right"></span></li><?php endif; ?>
					<?php if($pages->last): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'users/page/' . $pages->total_pages, '>>'); ?></span><span class="right"></span></li><?php endif; ?>
			<?php endif; ?>
		</ul>
		</div>
	</div>
	
</div>

<?php $this->load->view(ADMINCP . 'footer'); ?>
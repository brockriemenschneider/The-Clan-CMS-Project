<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

 <script type="text/javascript">
	function deleteConfirm()
	{
    	var answer = confirm("Are you sure you want to delete this widget area? Once deleted, there will be no way to recover the widget area!")
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
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets', 'Widgets'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/areas', 'Widget Areas'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/addarea', 'Add Widget Area'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/browse', 'Browse Widgets'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Widget Areas', 4); ?>
		</div>
		
		<div class="content">
			<div class="inside">
	
			<div id="move"></div>
			
			<?php if($this->session->flashdata('message')): ?>
				<div class="alert">
					<?php echo $this->session->flashdata('message'); ?>
				</div>
				<?php echo br(); ?>
			<?php endif; ?>
			
			<table id="widgets">
				<thead>
					<tr>
						<th width="50%">Area</th>
						<th width="40%">Slug</th>
						<th width="10%">Actions</th>
					</tr>
				</thead>
			
				<tbody>
					<?php if($areas): ?>
						<?php foreach($areas as $area): ?>
						<tr>
							<td><?php echo anchor(ADMINCP . 'widgets/editarea/' . $area->area_id, $area->area_title); ?></td>
							<td><?php echo $area->area_slug; ?></td>
							<td><?php echo anchor(ADMINCP . 'widgets/editarea/' . $area->area_id, img(ADMINCP_URL . 'images/edit.png', array('alt' => 'Edit')), array('title' => 'Edit')); ?> <?php echo anchor(ADMINCP . 'widgets/deletearea/' . $area->area_id, img(array('src' => ADMINCP_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?></td>
						</tr>
						<?php endforeach; ?>
					<?php else: ?>
					<tr>
						<td colspan="3">There are currently no widget areas. Click <?php echo anchor(ADMINCP . 'widgets/addarea', 'Add Widget Area'); ?> to add one.</td>
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
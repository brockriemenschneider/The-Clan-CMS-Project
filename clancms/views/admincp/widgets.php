<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

<script type="text/javascript">
	$(function() {
		var cct = $.cookie('ci_csrf_token');
		
		$("#widgets tbody").sortable({
			update:function(i) {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?><?php echo ADMINCP; ?>widgets/order",
					data: $(this).sortable("serialize") + '&ci_csrf_token=' + cct
				});
				
				$("#move").html('<div class="alert">The widget was successfully moved!</div><br />');
			}
		});

		$("#widgets tbody").disableSelection();

	});	

	function updateConfirm()
	{
    	var answer = confirm("Are you sure you want to update this widget?")
    	if (answer)
		{
        	document.messages.submit();
    	}
    
    	return false;  
	} 
	
	function uninstallConfirm()
	{
    	var answer = confirm("Are you sure you want to uninstall this widget? Once uninstalled, there will be no way to recover any instances created from this widget!")
    	if (answer)
		{
        	document.messages.submit();
    	}
    
    	return false;  
	} 
	
	function deleteConfirm()
	{
    	var answer = confirm("Are you sure you want to delete this widget? Once deleted, there will be no way to recover the widget!")
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
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets', 'Widgets'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/areas', 'Widget Areas'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/addarea', 'Add Widget Area'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/browse', 'Browse Widgets'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Installed Widgets', 4); ?>
		</div>
		
		<div class="content">
			<div class="inside">
			
			<div id="move"></div>
			
			<?php if($updates): ?>
				<?php foreach($updates as $update): ?>
				<div class="alert">
					There is an update available for <?php echo $update['title']; ?>. <?php echo anchor(ADMINCP . 'widgets/view/' . $update['slug'], 'View version ' . $update['version'] . ' details'); ?> or <?php echo anchor(ADMINCP . 'widgets/update/' . $update['slug'], 'update now', array('onclick' => "return updateConfirm();")); ?>
				</div>
				<br />
				<?php endforeach; ?>
			<?php endif; ?>
						
			<?php if($this->session->flashdata('message')): ?>
				<div class="alert">
					<?php echo $this->session->flashdata('message'); ?>
				</div>
				<?php echo br(); ?>
			<?php endif; ?>
			
			<table>
				<thead>
					<tr>
						<th width="50%">Widget</th>
						<th width="10%">Version</th>
						<th width="30%">Author</th>
						<th width="10%">Actions</th>
					</tr>
				</thead>
			
				<tbody>
					<?php if($widgets): ?>
					<?php foreach($widgets as $widget): ?>
						<tr>
							<td><br /><?php if($this->widgets->widget_slug($widget->slug)): echo anchor(ADMINCP . 'widgets/view/' . $widget->slug, $widget->title); else: echo anchor($widget->link, $widget->title); endif; ?><br /><?php if($widget->description): echo $widget->description; endif; ?><br /><br /></td>
							<td><?php echo $widget->version; ?></td>
							<td><?php if($widget->link): echo anchor($widget->link, $widget->author); else: echo $widget->author; endif; ?></td>
							<td><?php echo anchor(ADMINCP . 'widgets/add/' . $widget->slug, img(ADMINCP_URL . 'images/add.png', array('alt' => 'Add')), array('title' => 'Add')); ?> <?php echo anchor(ADMINCP . 'widgets/uninstall/' . $widget->slug, img(array('src' => ADMINCP_URL . 'images/delete.png', 'alt' => 'Uninstall')), array('title' => 'Uninstall', 'onclick' => "return uninstallConfirm();")); ?></td>
						</tr>
						<?php endforeach; ?>
					<?php else: ?>
					<tr>
						<td colspan="4">There are currently no installed widgets. Click <?php echo anchor(ADMINCP . 'widgets/browse', 'Browse Widgets'); ?> to install one.</td>
					</tr>
					<?php endif; ?>
				</tbody>
			</table>
		
			</div>
		</div>
		
		<div class="footer"></div>
	</div>
	
	<?php if($areas): ?>
	<?php foreach($areas as $area): ?>
	<div class="space"></div>
	<div class="box">
		
		<div class="header">
			<?php echo heading($area->area_title, 4); ?>
		</div>
		
		<div class="content">
			<div class="inside">
	
			<div id="move"></div>
			
			<table id="widgets">
				<thead>
					<tr>
						<th width="50%">Widget</th>
						<th width="40%">Type</th>
						<th width="10%">Actions</th>
					</tr>
				</thead>
			
				<tbody>
					<?php if($area->widgets): ?>
						<?php foreach($area->widgets as $widget): ?>
						<tr id="widget_<?php echo $widget->widget_id; ?>" class="move">
							<td><?php echo anchor(ADMINCP . 'widgets/edit/' . $widget->widget_id, $widget->widget_title); ?></td>
							<td><?php echo $widget->type; ?></td>
							<td><?php echo anchor(ADMINCP . 'widgets/edit/' . $widget->widget_id, img(ADMINCP_URL . 'images/edit.png', array('alt' => 'Edit')), array('title' => 'Edit')); ?> <?php echo anchor(ADMINCP . 'widgets/delete/' . $widget->widget_id, img(array('src' => ADMINCP_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?></td>
						</tr>
						<?php endforeach; ?>
					<?php else: ?>
					<tr>
						<td colspan="3">There are currently no widgets in this area. Click add on one of the above widgets.</td>
					</tr>
					<?php endif; ?>
				</tbody>
			</table>
		
			</div>
		</div>
		
		<div class="footer"></div>
	</div>
	<?php endforeach; ?>
	<?php endif; ?>
	
</div>

<?php $this->load->view(ADMINCP . 'footer'); ?>
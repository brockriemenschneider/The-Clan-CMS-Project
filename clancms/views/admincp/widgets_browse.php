<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

<script type="text/javascript">	
	function installConfirm()
	{
    	var answer = confirm("Are you sure you want to install this widget?")
    	if (answer)
		{
        	document.messages.submit();
    	}
    
    	return false;  
	} 
	
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
	
</script> 

<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets', 'Widgets'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/areas', 'Widget Areas'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/addarea', 'Add Widget Area'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/browse', 'Browse Widgets'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Browse Widgets', 4); ?>
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
						<th width="50%">Widget</th>
						<th width="10%">Version</th>
						<th width="25%">Author</th>
						<th width="15%">Actions</th>
					</tr>
				</thead>
			
				<tbody>
					<?php if($widgets): ?>
						<?php foreach($widgets as $widget): ?>
						<tr <?php if($this->widgets->check_updates($widget['widget_slug'])): echo 'class="selected"'; endif; ?>>
							<td><br /><?php echo anchor(ADMINCP . 'widgets/view/' . $widget['widget_slug'], $widget['widget_title']); ?><br /><?php if($widget['widget_description']): echo $widget['widget_description']; endif; ?><br /><br /></td>
							<td><?php echo $widget['widget_version']; ?></td>
							<td><?php echo $widget['widget_author']; ?></td>
							<td><?php echo anchor(ADMINCP . 'widgets/view/' . $widget['widget_slug'], img(ADMINCP_URL . 'images/view.png', array('alt' => 'View')), array('title' => 'View')); ?> <?php if(!$this->widgets->is_installed($widget['widget_slug'])): echo anchor(ADMINCP . 'widgets/install/' . $widget['widget_slug'], img(ADMINCP_URL . 'images/add.png', array('alt' => 'Install')), array('title' => 'Install', 'onclick' => "return installConfirm();")); endif; ?> <?php if($this->widgets->check_updates($widget['widget_slug'])): echo anchor(ADMINCP . 'widgets/update/' . $widget['widget_slug'], img(array('src' => ADMINCP_URL . 'images/update.png', 'alt' => 'Update')), array('title' => 'Update', 'onclick' => "return updateConfirm();")); endif; ?> <?php if($this->widgets->is_installed($widget['widget_slug'])): echo anchor(ADMINCP . 'widgets/uninstall/' . $widget['widget_slug'], img(array('src' => ADMINCP_URL . 'images/delete.png', 'alt' => 'Uninstall')), array('title' => 'Uninstall', 'onclick' => "return uninstallConfirm();")); endif; ?></td>
						</tr>
						<?php endforeach; ?>
					<?php else: ?>
					<tr>
						<td colspan="4">There are currently no widgets to browse. Please try again later.</td>
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
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/browse/page/' . $pages->current_page, 'Page ' . $pages->current_page . ' of ' . $pages->total_pages); ?></span><span class="right"></span></li>
					<?php if($pages->first): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/browse/page/1', '<<'); ?></span><span class="right"></span></li><?php endif; ?>
					<?php if($pages->previous): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/browse/page/' . ($pages->current_page - 1), '<'); ?></span><span class="right"></span></li><?php endif; ?>
				
				<?php if($pages->before): ?>
					<?php foreach($pages->before as $before): ?>
						<li <?php if($pages->current_page == $before): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/browse/page/' . $before, $before); ?></span><span class="right"></span></li>
					<?php endforeach; ?>
				<?php endif; ?>
				
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/browse/page/' . $pages->current_page, $pages->current_page); ?></span><span class="right"></span></li>
				
				<?php if($pages->after): ?>
					<?php foreach($pages->after as $after): ?>
						<li <?php if($pages->current_page == $after): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/browse/page/' . $after, $after); ?></span><span class="right"></span></li>
					<?php endforeach; ?>
				<?php endif; ?>
				
					<?php if($pages->next): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/browse/page/' . ($pages->current_page + 1), '>'); ?></span><span class="right"></span></li><?php endif; ?>
					<?php if($pages->last): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/browse/page/' . $pages->total_pages, '>>'); ?></span><span class="right"></span></li><?php endif; ?>
			<?php endif; ?>
		</ul>
		</div>
	</div>
</div>

<?php $this->load->view(ADMINCP . 'footer'); ?>
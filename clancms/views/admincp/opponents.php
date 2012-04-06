<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

 <script type="text/javascript">
	function deleteConfirm()
	{
    	var answer = confirm("Are you sure you want to delete this opponent? Once deleted, there will be no way to recover the opponent and matches!")
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
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'opponents', 'Opponents'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'opponents/add', 'Add Opponent'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Opponents', 4); ?>
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
			
			<table id="opponents">
				<thead>
					<tr>
						<th width="35%">Opponent</th>
						<th width="30%">Link</th>
						<th width="10%">Tag</th>
						<th width="15%"># Of Matches</th>
						<th width="10%">Actions</th>
					</tr>
				</thead>
			
				<tbody>
					<?php if($opponents): ?>
						<?php foreach($opponents as $opponent): ?>
						<tr>
							<td><?php echo anchor(ADMINCP . 'opponents/edit/' . $opponent->opponent_id, $opponent->opponent_title); ?></td>
							<td><?php if($opponent->opponent_link): echo anchor($opponent->opponent_link, $opponent->opponent_link); else: echo 'N/A'; endif; ?></td>
							<td><?php if($opponent->opponent_tag): echo $opponent->opponent_tag; else: echo 'N/A'; endif; ?></td>
							<td><?php echo $opponent->total_matches; ?></td>
							<td><?php echo anchor(ADMINCP . 'opponents/edit/' . $opponent->opponent_id, img(ADMINCP_URL . 'images/edit.png', array('alt' => 'Edit')), array('title' => 'Edit')); ?> <?php echo anchor(ADMINCP . 'opponents/delete/' . $opponent->opponent_id, img(array('src' => ADMINCP_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?></td>
						</tr>
						<?php endforeach; ?>
					<?php else: ?>
					<tr>
						<td colspan="5">There are currently no opponents. Click <?php echo anchor(ADMINCP . 'opponents/add', 'Add Opponent'); ?> to add one.</td>
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
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'opponents/page/' . $pages->current_page, 'Page ' . $pages->current_page . ' of ' . $pages->total_pages); ?></span><span class="right"></span></li>
					<?php if($pages->first): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'opponents/page/1', '<<'); ?></span><span class="right"></span></li><?php endif; ?>
					<?php if($pages->previous): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'opponents/page/' . ($pages->current_page - 1), '<'); ?></span><span class="right"></span></li><?php endif; ?>
				
				<?php if($pages->before): ?>
					<?php foreach($pages->before as $before): ?>
						<li <?php if($pages->current_page == $before): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'opponents/page/' . $before, $before); ?></span><span class="right"></span></li>
					<?php endforeach; ?>
				<?php endif; ?>
				
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'opponents/page/' . $pages->current_page, $pages->current_page); ?></span><span class="right"></span></li>
				
				<?php if($pages->after): ?>
					<?php foreach($pages->after as $after): ?>
						<li <?php if($pages->current_page == $after): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'opponents/page/' . $after, $after); ?></span><span class="right"></span></li>
					<?php endforeach; ?>
				<?php endif; ?>
				
					<?php if($pages->next): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'opponents/page/' . ($pages->current_page + 1), '>'); ?></span><span class="right"></span></li><?php endif; ?>
					<?php if($pages->last): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'opponents/page/' . $pages->total_pages, '>>'); ?></span><span class="right"></span></li><?php endif; ?>
			<?php endif; ?>
		</ul>
		</div>
	</div>
</div>

<?php $this->load->view(ADMINCP . 'footer'); ?>
<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

 <script type="text/javascript">
	$(function() {
		$("#squads tbody").sortable({stop:function(i) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?><?php echo ADMINCP; ?>/squads/order",
				data: $("#squads tbody").sortable("serialize")
			});
			$("#move").html('<div class="alert">The squad was successfully moved!</div><br />');
		}});

		$("#squads tbody").disableSelection();

	});		
	
	function deleteConfirm()
	{
    	var answer = confirm("Are you sure you want to delete this squad? Once deleted, there will be no way to recover the squad's members, news articles, and matches!")
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
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'squads', 'Squads'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'squads/add', 'Add Squad'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Squads', 4); ?>
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
			
			<table id="squads">
				<thead>
					<tr>
						<th width="45%">Squad</th>
						<th width="15%"># of Articles</th>
						<th width="15%"># of Matches</th>
						<th width="15%"># of Members</th>
						<th width="10%">Actions</th>
					</tr>
				</thead>
			
				<tbody>
					<?php if($squads): ?>
						<?php foreach($squads as $squad): ?>
						<tr id="squad_<?php echo $squad->squad_id; ?>" class="move">
							<td><?php if($squad->squad_tag && (bool) !$squad->squad_tag_position): echo '[' . $squad->squad_tag . '] '; endif; ?><?php echo anchor(ADMINCP . 'squads/edit/' . $squad->squad_id, $squad->squad_title); ?><?php if($squad->squad_tag && (bool) $squad->squad_tag_position): echo ' [' . $squad->squad_tag . ']'; endif; ?></td>
							<td><?php echo $squad->article_total; ?></td>
							<td><?php echo $squad->match_total; ?></td>
							<td><?php echo $squad->member_total; ?></td>
							<td><?php echo anchor(ADMINCP . 'squads/edit/' . $squad->squad_id, img(array('src' => ADMINCP_URL . 'images/edit.png', 'alt' => 'Edit')), array('title' => 'Edit')); ?> <?php echo anchor(ADMINCP . 'squads/delete/' . $squad->squad_id, img(array('src' => ADMINCP_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?></td>
						</tr>
						<?php endforeach; ?>
					<?php else: ?>
					<tr>
						<td colspan="5">There are currently no squads. Click <?php echo anchor(ADMINCP . 'squads/add', 'Add Squad'); ?> to add one.</td>
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
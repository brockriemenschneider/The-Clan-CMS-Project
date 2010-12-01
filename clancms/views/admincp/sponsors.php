<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

 <script type="text/javascript">
	$(function() {
		$("#sponsors tbody").sortable({stop:function(i) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?><?php echo ADMINCP; ?>sponsors/order",
				data: $("#sponsors tbody").sortable("serialize")
			});
			$("#move").html('<div class="alert">The sponsor was successfully moved!</div><br />');
		}});

		$("#sponsors tbody").disableSelection();

	});		
		
	function deleteConfirm()
	{
    	var answer = confirm("Are you sure you want to delete this sponsor? Once deleted, there will be no way to recover the sponsor!")
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
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'sponsors', 'Sponsors'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'sponsors/add', 'Add Sponsor'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Sponsors', 4); ?>
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
			
			<table id="sponsors">
				<thead>
					<tr>
						<th width="20%">Sponsor</th>
						<th width="30%">Link</th>
						<th width="40%">Image</th>
						<th width="10%">Actions</th>
					</tr>
				</thead>
			
				<tbody>
					<?php if($sponsors): ?>
						<?php foreach($sponsors as $sponsor): ?>
						<tr id="sponsor_<?php echo $sponsor->sponsor_id; ?>" class="move">
							<td><?php echo anchor(ADMINCP . 'sponsors/edit/' . $sponsor->sponsor_id, $sponsor->sponsor_title); ?></td>
							<td><?php if($sponsor->sponsor_link): echo anchor($sponsor->sponsor_link, $sponsor->sponsor_link); else: echo 'N/A'; endif; ?></td>
							<td><?php echo img(array('src' =>  IMAGES . 'sponsors/' . $sponsor->sponsor_image, 'title' => $sponsor->sponsor_title, 'alt' => $sponsor->sponsor_title)); ?></td>
							<td><?php echo anchor(ADMINCP . 'sponsors/edit/' . $sponsor->sponsor_id, img(ADMINCP_URL . 'images/edit.png', array('alt' => 'Edit')), array('title' => 'Edit')); ?> <?php echo anchor(ADMINCP . 'sponsors/delete/' . $sponsor->sponsor_id, img(array('src' => ADMINCP_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?></td>
						</tr>
						<?php endforeach; ?>
					<?php else: ?>
					<tr>
						<td colspan="4">There are currently no sponsors. Click <?php echo anchor(ADMINCP . 'sponsors/add', 'Add Sponsor'); ?> to add one.</td>
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
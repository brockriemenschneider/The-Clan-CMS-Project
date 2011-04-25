<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

 <script type="text/javascript">
	$(function() {
		$("#pages tbody").sortable({stop:function(i) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?><?php echo ADMINCP; ?>pages/order",
				data: $("#pages tbody").sortable("serialize")
			});
			$("#move").html('<div class="alert">The page was successfully moved!</div><br />');
		}});

		$("#pages tbody").disableSelection();

	});		
		
	function deleteConfirm()
	{
    	var answer = confirm("Are you sure you want to delete this page? Once deleted, there will be no way to recover the page!")
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
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'pages', 'Pages'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'pages/add', 'Add Page'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Pages', 4); ?>
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
			
			<table id="pages">
				<thead>
					<tr>
						<th width="40%">Page</th>
						<th width="40%">Slug</th>
						<th width="10%">Actions</th>
					</tr>
				</thead>
			
				<tbody>
					<?php if($pages): ?>
						<?php foreach($pages as $page): ?>
						<tr id="page_<?php echo $page->page_id; ?>" class="move">
							<td><?php echo anchor(ADMINCP . 'pages/edit/' . $page->page_id, $page->page_title); ?></td>
							<td><?php echo anchor('pages/' . $page->page_slug, $page->page_slug); ?></td>
							<td><?php echo anchor(ADMINCP . 'pages/edit/' . $page->page_id, img(ADMINCP_URL . 'images/edit.png', array('alt' => 'Edit')), array('title' => 'Edit')); ?> <?php echo anchor(ADMINCP . 'pages/delete/' . $page->page_id, img(array('src' => ADMINCP_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?></td>
						</tr>
						<?php endforeach; ?>
					<?php else: ?>
					<tr>
						<td colspan="3">There are currently no pages. Click <?php echo anchor(ADMINCP . 'pages/add', 'Add Page'); ?> to add one.</td>
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
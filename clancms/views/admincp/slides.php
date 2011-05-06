<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

 <script type="text/javascript">
	$(function() {
		var cct = $.cookie('ci_csrf_token');
		
		$("#slides tbody").sortable({
			update:function(i) {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?><?php echo ADMINCP; ?>slider/order",
					data: $(this).sortable("serialize") + '&ci_csrf_token=' + cct
				});
				
				$("#move").html('<div class="alert">The slide was successfully moved!</div><br />');
			}
		});

		$("#slides tbody").disableSelection();

	});	
		
	function deleteConfirm()
	{
    	var answer = confirm("Are you sure you want to delete this slide? Once deleted, there will be no way to recover the slide!")
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
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'slider', 'News Slider'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'slider/add', 'Add Slide'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('News Slider', 4); ?>
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
			
			<table id="slides">
				<thead>
					<tr>
						<th width="30%">Title</th>
						<th width="20%">Article</th>
						<th width="40%">Image</th>
						<th width="10%">Actions</th>
					</tr>
				</thead>
			
				<tbody>
					<?php if($slides): ?>
						<?php foreach($slides as $slide): ?>
						<tr id="slides_<?php echo $slide->slider_id; ?>" class="move">
							<td><?php echo anchor(ADMINCP . 'slider/edit/' . $slide->slider_id, $slide->slider_title); ?></td>
							<td><?php if((bool) $slide->article_id): echo anchor(ADMINCP . 'articles/edit/' . $slide->article_id, $slide->slider_title); else: echo '-'; endif; ?></td>
							<td><?php echo anchor($slide->slider_link, img(array('src' => IMAGES . 'slider/slides/' . $slide->slider_image, 'width' => 200, 'height' => 60))); ?></td>
							<td><?php echo anchor(ADMINCP . 'slider/edit/' . $slide->slider_id, img(ADMINCP_URL . 'images/edit.png', array('alt' => 'Edit')), array('title' => 'Edit')); ?> <?php echo anchor(ADMINCP . 'slider/delete/' . $slide->slider_id, img(array('src' => ADMINCP_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?></td>
						</tr>
						<?php endforeach; ?>
					<?php else: ?>
					<tr>
						<td colspan="3">There are currently no slides. Click <?php echo anchor(ADMINCP . 'slider/add', 'Add Slide'); ?> to add one.</td>
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
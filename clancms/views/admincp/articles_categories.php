<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

 <script type="text/javascript">
	var cct = $.cookie('ci_csrf_token');
	
	$("#members tbody").disableSelection();

	});
	function deleteConfirm()
	{
    	var answer = confirm("Are you sure you want to delete this category? Once deleted, there will be no way to recover the article, it's slides or it's comments!")
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
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles', 'Published'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/drafts', 'Drafts'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/add', 'Add News Article'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/headers', 'News Headers'); ?></span><span class="right"></span></li>
			<li <?php if($this->uri->segment(3, '') == 'categories'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/categories', 'News Categories'); ?></span><span class="right"></span></li>
		</ul>
		</div>


		<div class="header">
			<?php echo heading('Article Categories', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
			
			<?php if($this->session->flashdata('message')): ?>
				<div class="alert">
					<?php echo $this->session->flashdata('message'); ?>
				</div>
				<?php echo br(); ?>
			<?php endif; ?>
			
			<?php echo form_open(ADMINCP . 'articles/check_category', "id='add_category'"); ?>
			
			<!-- Add Category Title -->
				<div class="label required">New Category Name</div>
				<?php 
					$data = array (
						'name'	=>	'category_title',
						'size'		=>	25,
						'class'	=>	'input'
						);
					
					echo form_input($data); 
					
					$data = array(
						'name'	=>	'add_category',
						'class'	=>	'submit',
						'value'	=>	'Add Category'
						);
						
					echo form_submit($data);
					
					?>
				<?php echo br(); ?>
				<div class="description">What is the title of this category?</div>
				
			<?php echo form_close(); ?>
			
			<?php echo br(2); ?>
			
			<!-- Existing Categories -->
			<?php if($categories): ?>
				<?php foreach($categories as $category): ?>
					<div class="label"><?php echo anchor(ADMINCP . 'articles/delete_category/' . $category->category_id, img(array('src' => ADMINCP_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?></div>
					<span class="category_title"><?php echo $category->category_title; ?></span>
					<?php echo br(); ?>
					<div class="clear"></div>
				<?php endforeach; ?>
			<?php endif; ?>
			</div>
		</div>
		<div class="footer"></div>
	</div>
</div>

<?php $this->load->view(ADMINCP . 'footer'); ?>
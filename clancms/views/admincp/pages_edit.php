<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

<?php echo form_open(ADMINCP . 'pages/edit/' . $page->page_id); ?>
<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'pages', 'Pages'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'pages/add', 'Add Page'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'pages/edit/' . $page->page_id, 'Edit Page: ' . $page->page_title); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Edit Page: ' . $page->page_title, 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
				<?php if(validation_errors()): ?>
				<div class="alert">
					<?php echo validation_errors(); ?>
				</div>
				<?php endif; ?>
				
				<?php if($this->session->flashdata('message')): ?>
				<div class="alert">
					<?php echo $this->session->flashdata('message'); ?>
				</div>
				<?php endif; ?>
				
				<div class="required-field required">Required Field</div>
				<?php echo br(); ?>
				
				<div class="subheader">
					<?php echo heading('Page Information', 4); ?>
				</div>
		
				<div class="label required">Title</div>
				<?php 
				$data = array(
					'name'		=> 'title',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('title', $page->page_title)); ?>
				<?php echo br(); ?>
				<div class="description">The title of the page</div>
				
				<div class="label required">Slug</div>
				<?php 
				$data = array(
					'name'		=> 'slug',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('slug', $page->page_slug)); ?>
				<?php echo br(); ?>
				<div class="description">The link to the page</div>
				
				<?php
				$data = array(
					'name'		=> 'content',
					'id'		=> 'wysiwyg',
					'rows'		=> '20',
					'cols'		=> '50'
				);
			
				echo form_textarea($data, set_value('content', $page->page_content)); ?>
				<?php echo br(); ?>
				<div class="description">The content of the page</div>
				
				<div class="label required">Priority</div>
				
				<?php 
				$data = array(
					'name'		=> 'priority',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('priority', $page->page_priority)); ?>
				<?php echo br(); ?>
				<div class="description">The order in which this page should appear</div>
				
				<?php 
					$data = array(
						'name'		=> 'update_page',
						'class'		=> 'submit',
						'value'		=> 'Update Page'
					);
				
				echo form_submit($data); ?>
				<div class="clear"></div>
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
</div>
<?php echo form_close(); ?>

<?php $this->load->view(ADMINCP . 'footer'); ?>
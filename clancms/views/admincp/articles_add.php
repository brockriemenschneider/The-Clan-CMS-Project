<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

<?php echo form_open(ADMINCP . 'articles/add'); ?>
<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles', 'Published'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/drafts', 'Drafts'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/add', 'Add News Article'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Add News Article', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
				<?php if(validation_errors()): ?>
				<div class="alert">
					<?php echo validation_errors(); ?>
				</div>
				<?php endif; ?>
				
				<div class="required-field required">Required Field</div>
				<?php echo br(); ?>
				
				<div class="subheader">
					<?php echo heading('Article Information', 4); ?>
				</div>
				
				<div class="label required">Status</div>
				<?php
					
					$options = array(
						'0' => 'Draft',
						'1' => 'Published'
					);
					
				echo form_dropdown('status', $options, set_value('status'), 'class="input select"'); ?>
				<?php echo br(); ?>
				<div class="description">What is the status of this article?</div>
				
				<div class="label required">Squad</div>
				<?php
					
					$options = array('0' => 'None',);
					if($squads):
						foreach($squads as $squad):
							$options = $options + array($squad->squad_id	=>	$squad->squad_title);
						endforeach;
					endif;
					
				echo form_dropdown('squad', $options, set_value('squad'), 'class="input select"'); ?>
				<?php echo br(); ?>
				<div class="description">What squad is this article for?</div>
		
				<div class="label required">Title</div>
				
				<?php 
				$data = array(
					'name'		=> 'title',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('title')); ?>
				<?php echo br(); ?>
				<div class="description">The subject of the article</div>
				
				<?php
				$data = array(
					'name'		=> 'article',
					'id'		=> 'wysiwyg',
					'rows'		=> '20',
					'cols'		=> '50'
				);
			
				echo form_textarea($data, set_value('article')); ?>
				<?php echo br(); ?>
				<div class="description">The content of the article</div>
				
				<?php echo br(); ?>
				<div class="subheader">
					<?php echo heading('Article Settings', 4); ?>
				</div>
				
				<div class="label required">Comments</div> 
				<?php 
					$data = array(
						'name'		=> 'comments',
						'class'		=> 'input',
						);
				
				echo form_radio($data, '1', set_radio('comments', '1', TRUE)); ?> Allow
				
				<?php 
					$data = array(
						'name'		=> 'comments',
						'class'		=> 'input',
						);
				
				echo form_radio($data, '0', set_radio('comments', '0', FALSE)); ?> Disallow
				<?php echo br(); ?>
		
				<?php 
					$data = array(
						'name'		=> 'add_article',
						'class'		=> 'submit',
						'value'		=> 'Add News Article'
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
<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

<script type="text/javascript">
$(function() {

	$("input[name='type']").change( function() {
		if($("input[name='type']:checked").val() == 1)
		{
			$('#article').show();
			$('#custom').hide();
		}
		else
		{
			$('#article').hide();
			$('#custom').show();
		}
	});
	
	if($("input[name='type']:checked").val() == 1)
	{
		$('#article').show();
		$('#custom').hide();
	}
});		
</script> 

<?php echo form_open_multipart(ADMINCP . 'slider/add'); ?>
<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'slider', 'News Slider'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'slider/add', 'Add Slide'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Add Slide', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
				<?php if(validation_errors()): ?>
				<div class="alert">
					<?php echo validation_errors(); ?>
				</div>
				<?php endif; ?>
				
				<?php if(isset($upload->errors)): ?>
				<div class="alert">
					<?php echo $upload->errors; ?>
				</div>
				<?php endif; ?>
				
				<div class="required-field required">Required Field</div>
				<?php echo br(); ?>
				
				<div class="subheader">
					<?php echo heading('Slide Information', 4); ?>
				</div>
				
				<div class="label required">Type:</div>
				
				News Article
				<input type="radio" name="type" value="1" <?php echo set_radio('type', '1', TRUE); ?> class="input" />
				Custom
				<input type="radio" name="type" value="0" <?php echo set_radio('type', '0'); ?> class="input" />
				
				<?php echo br(); ?>
				<div class="description">What type of slide is it?</div>
				
				<div id="article">
				<div class="label required">Article</div>
				<?php
					
					$options = array('' => 'Choose an Article...',);
					if($articles):
						foreach($articles as $article):
							$options = $options + array($article->article_id	=>	$article->article_title);
						endforeach;
					endif;
					
				echo form_dropdown('article', $options, set_value('article'), 'class="input select"'); ?>
				<?php echo br(); ?>
				<div class="description">What article is the slide about?</div>
				</div>
				
				<div id="custom">
				<div class="label required">Title</div>
				
				<?php 
				$data = array(
					'name'		=> 'title',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('title')); ?>
				<?php echo br(); ?>
				<div class="description">The title of the slide</div>
		
				<div class="label">Link</div>
				
				<?php 
				$data = array(
					'name'		=> 'link',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('link')); ?>
				<?php echo br(); ?>
				<div class="description">The link of the slide</div>
				</div>
				
				<div class="label">Content</div>
				<?php
				$data = array(
					'name'		=> 'content',
					'rows'		=> '20',
					'cols'		=> '50'
				);
			
				echo form_textarea($data, set_value('content')); ?>
				<?php echo br(); ?>
				<div class="description">The content of the slide</div>
				
				<div class="label required">Image</div>
				<?php 
				$data = array(
					'name'		=> 'image',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_upload($data); ?>
				<?php echo br(); ?>
				<div class="description">The slide's image</div>
				<?php echo br(); ?>
				
				<div class="label required">Priority</div>
				
				<?php 
				$data = array(
					'name'		=> 'priority',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('priority')); ?>
				<?php echo br(); ?>
				<div class="description">The order in which this slide should appear</div>
				
				<?php 
					$data = array(
						'name'		=> 'add_slide',
						'class'		=> 'submit',
						'value'		=> 'Add Slide'
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
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
	else
	{
		$('#article').hide();
		$('#custom').show();
	}
	
	$('#counter').html(<?php echo $this->ClanCMS->get_setting('slide_content_limit'); ?> - <?php echo strlen($slide->slider_content); ?>);
	
	$("textarea[name='content']").keydown(function() {
		var max = <?php echo $this->ClanCMS->get_setting('slide_content_limit'); ?>;
		var length = $(this).val().length;
		
		if(length > max)
		{
			var text = $(this).val();
			text = text.substring(0, max);
			$(this).val(text);
		}
		else
		{
			$('#counter').html(max - length);
		}
	});
	
	$("textarea[name='content']").keyup(function() {
		var max = <?php echo $this->ClanCMS->get_setting('slide_content_limit'); ?>;
		var length = $(this).val().length;
		
		if(length > max)
		{
			var text = $(this).val();
			text = text.substring(0, max);
			$(this).val(text);
		}
		else
		{
			$('#counter').html(max - length);
		}
	});
});		
</script> 

<?php echo form_open_multipart(ADMINCP . 'slider/edit/' . $slide->slider_id); ?>
<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'slider', 'News Slider'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'slider/add', 'Add Slide'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'slider/edit/' . $slide->slider_id, 'Edit Slide: ' . $slide->slider_title); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Edit Slide: ' . $slide->slider_title, 4); ?>
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
				<input type="radio" name="type" value="1" <?php if((bool) $slide->article_id): echo 'checked="checked"'; else: echo set_radio('type', '1', (bool) $slide->article_id); endif; ?> class="input" />
				Custom
				<input type="radio" name="type" value="0" <?php if((bool) !$slide->article_id): echo 'checked="checked"'; else: echo set_radio('type', '1', (bool) !$slide->article_id); endif; ?> class="input" />
				
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
					
				echo form_dropdown('article', $options, set_value('article', $slide->article_id), 'class="input select"'); ?>
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

				echo form_input($data, set_value('title', $slide->slider_title)); ?>
				<?php echo br(); ?>
				<div class="description">The title of the slide</div>
		
				<div class="label">Link</div>
				
				<?php 
				$data = array(
					'name'		=> 'link',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('link', $slide->slider_link)); ?>
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
			
				echo form_textarea($data, set_value('content', $slide->slider_content)); ?>
				<?php echo br(); ?>
				<div class="description">The content of the slide <span class="red"><strong><span id="counter"><?php echo $this->ClanCMS->get_setting('slide_content_limit'); ?></span> Characters Left</span></strong></div>
				
				<div class="label <?php if($slide->slider_image): echo ''; else: echo 'required'; endif; ?>">Image</div>
				<?php 
				$data = array(
					'name'		=> 'image',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_upload($data); ?>
				<?php echo br(); ?>
				<?php if($slide->slider_image): ?>
					<div class="description"><?php echo img(array('src' => IMAGES . 'slider/slides/' . $slide->slider_image, 'alt' => $slide->slider_title, 'title' => $slide->slider_title, 'width' => 400, 'height' => 120)); ?></div>
				<?php endif; ?>
				<div class="description">The slide's logo</div>
				<?php echo br(); ?>
				
				<div class="label required">Priority</div>
				
				<?php 
				$data = array(
					'name'		=> 'priority',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('priority', $slide->slider_priority)); ?>
				<?php echo br(); ?>
				<div class="description">The order in which this slide should appear</div>
				
				<?php 
					$data = array(
						'name'		=> 'update_slide',
						'class'		=> 'submit',
						'value'		=> 'Update Slide'
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
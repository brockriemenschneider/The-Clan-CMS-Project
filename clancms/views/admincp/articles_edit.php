<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

 <script type="text/javascript">
	function deleteConfirm()
	{
    	var answer = confirm("Are you sure you want to delete this comment? Once deleted, there will be no way to recover the comment!")
    	if (answer)
		{
        	document.messages.submit();
    	}
    
    	return false;  
	} 
</script> 

<?php echo form_open(ADMINCP . 'articles/edit/' . $article->article_id); ?>
<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles', 'Published'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/drafts', 'Drafts'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/add', 'Add News Article'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/edit/' . $article->article_id, 'Edit Article: ' . $article->article_title); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Edit Article: ' . $article->article_title, 4); ?>
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
					<?php echo heading('Article Information', 4); ?>
				</div>
				
				<div class="label">Author</div>
				<div class="details"><?php echo anchor(ADMINCP . 'users/edit/' . $article->user_id, $article->author); ?></div>
				<div class="clear"></div>
				
				<div class="label required">Status</div>
				<?php
					
					$options = array(
						'0' => 'Draft',
						'1' => 'Published'
					);
					
				echo form_dropdown('status', $options, set_value('status', $article->article_status), 'class="input select"'); ?>
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
					
				echo form_dropdown('squad', $options, set_value('squad', $article->squad_id), 'class="input select"'); ?>
				<?php echo br(); ?>
				<div class="description">What squad is this article for?</div>
		
				<div class="label required">Title</div>
				
				<?php 
				$data = array(
					'name'		=> 'title',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('title', $article->article_title)); ?>
				<?php echo br(); ?>
				<div class="description">The subject of the article</div>
				
				<?php
				$data = array(
					'name'		=> 'article',
					'id'		=> 'wysiwyg',
					'rows'		=> '20',
					'cols'		=> '50'
				);
			
				echo form_textarea($data, set_value('article', $article->article_content)); ?>
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
				
				echo form_radio($data, '1', set_radio('comments', '1', (bool) $article->article_comments)); ?> Allow
				
				<?php 
					$data = array(
						'name'		=> 'comments',
						'class'		=> 'input',
						);
				
				echo form_radio($data, '0', set_radio('comments', '0', (bool) !$article->article_comments)); ?> Disallow
				<?php echo br(); ?>
		
				<?php 
					$data = array(
						'name'		=> 'update_article',
						'class'		=> 'submit',
						'value'		=> 'Update News Article'
					);
				
				echo form_submit($data); ?>
				<div class="clear"></div>
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
	<div class="space"></div>
	
	<div id="comments"></div>
	<div class="box">
		
		<div class="header">
			<?php echo heading('Comments', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
			<?php if($comments): ?>
			<?php foreach($comments as $comment): ?>
				<div class="subheader">
				<?php if($this->user->is_administrator()): ?>
					<?php $actions = anchor(ADMINCP . 'articles/delete_comment/' . $comment->comment_id, img(array('src' => THEME_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?>
				<?php else: ?>
					<?php $actions = ""; ?>
				<?php endif; ?>
					<?php echo heading(anchor(ADMINCP . 'users/edit/' . $comment->user_id, $comment->author) . ' Posted ' . mdate("%M %d, %Y at %h:%i %a", $comment->date) . $actions, 4); ?>
				</div>
		<div id="avatar" class="left">
		<?php if($comment->avatar): ?>
			<?php echo anchor('account/profile/' . $this->users->user_slug($comment->author), img(array('src' => IMAGES . 'avatars/' . $comment->avatar, 'title' => $comment->author, 'alt' => $comment->author, 'width' => '57', 'height' => '57'))); ?>
		<?php else: ?>
			<?php echo anchor('account/profile/' . $this->users->user_slug($comment->author), img(array('src' => ADMINCP_URL . 'images/avatar_none.png', 'title' => $comment->author, 'alt' => $comment->author, 'width' => '57', 'height' => '57'))); ?>
		<?php endif; ?>
		</div>
		<p class="comment"><?php echo $comment->comment_title; ?></p>
		<div class="clear"></div>
		<?php echo br(); ?>
			
			<?php endforeach; ?>
			<?php else: ?>
				There are currently on comments for this article.
			<?php endif; ?>
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
	<?php if($comments): ?>
	<div class="box">
		<div class="pages">
		<ul>
			<?php if($pages): ?>
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/edit/' . $article->article_id . '/page/' . $pages->current_page, 'Page ' . $pages->current_page . ' of ' . $pages->total_pages); ?></span><span class="right"></span></li>
					<?php if($pages->first): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/edit/' . $article->article_id . '/page/1', '<<'); ?></span><span class="right"></span></li><?php endif; ?>
					<?php if($pages->previous): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/edit/' . $article->article_id . '/page/' . ($pages->current_page - 1), '<'); ?></span><span class="right"></span></li><?php endif; ?>
				
				<?php if($pages->before): ?>
					<?php foreach($pages->before as $before): ?>
						<li <?php if($pages->current_page == $before): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/edit/' . $article->article_id . '/page/' . $before, $before); ?></span><span class="right"></span></li>
					<?php endforeach; ?>
				<?php endif; ?>
				
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/edit/' . $article->article_id . '/page/' . $pages->current_page, $pages->current_page); ?></span><span class="right"></span></li>
				
				<?php if($pages->after): ?>
					<?php foreach($pages->after as $after): ?>
						<li <?php if($pages->current_page == $after): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/edit/' . $article->article_id . '/page/' . $after, $after); ?></span><span class="right"></span></li>
					<?php endforeach; ?>
				<?php endif; ?>
				
					<?php if($pages->next): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/edit/' . $article->article_id . '/page/' . ($pages->current_page + 1), '>'); ?></span><span class="right"></span></li><?php endif; ?>
					<?php if($pages->last): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/edit/' . $article->article_id . '/page/' . $pages->total_pages, '>>'); ?></span><span class="right"></span></li><?php endif; ?>
			<?php endif; ?>
		</ul>
		</div>
	</div>
	<?php endif; ?>
	
</div>
<?php echo form_close(); ?>

<?php $this->load->view(ADMINCP . 'footer'); ?>
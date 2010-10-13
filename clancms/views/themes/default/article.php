<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

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

<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor('articles', 'News Articles'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle">
			<?php if($article->squad): ?>
				<?php echo anchor('articles/view/' . $article->article_slug, $article->squad . ': ' . $article->article_title); ?>
			<?php else: ?>
				<?php echo anchor('articles/view/' . $article->article_slug, $article->article_title); ?>
			<?php endif; ?>
			</span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php if($article->squad): ?>
				<?php echo heading($article->squad . ': ' . $article->article_title, 4); ?>
			<?php else: ?>
				<?php echo heading($article->article_title, 4); ?>
			<?php endif; ?>
		</div>
		<div class="content">
			<div class="inside">
			
				<div class="subheader">
			<?php echo heading('Posted on ' . mdate("%M %d, %Y at %h:%i %a", $article->date) . ' by ' . anchor('account/profile/' . $this->users->user_slug($article->author), $article->author), 4); ?>
				</div>
			<?php echo $article->article; ?>
			</div>
		</div>
		<div class="footer"></div>
	</div>
	<div class="space"></div>
	
	<?php if($this->user->logged_in() && (bool) $article->article_comments): ?>
	<div class="box">
		<div class="header">
			<?php echo heading('Post A Comment', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
			
			<?php if(validation_errors()): ?>
				<div class="alert">
					<?php echo validation_errors(); ?>
				</div>
				<?php echo br(); ?>
			<?php endif; ?>
				
			<?php if($this->session->flashdata('message')): ?>
				<div class="alert">
					<?php echo $this->session->flashdata('message'); ?>
				</div>
				<?php echo br(); ?>
			<?php endif; ?>
			
			<?php echo form_open('articles/view/' . $article->article_slug); ?>
			<?php
				$data = array(
					'name'		=> 'comment',
					'rows'		=> '10',
					'cols'		=> '85'
				);
			
			echo form_textarea($data); ?>
			<?php 
					$data = array(
						'name'		=> 'add_comment',
						'class'		=> 'submit',
						'value'		=> 'Comment'
					);
				
				echo form_submit($data); ?>
				<div class="clear"></div>
			<?php echo form_close(); ?>
			</div>
		</div>
		<div class="footer"></div>
	</div>
	<div class="space"></div>
	<?php endif; ?>
	
	<div id="comments" class="box">
		
		<div class="header">
			<?php echo heading('Comments', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
			
			<?php if($comments): ?>
			<?php foreach($comments as $comment): ?>
				<div class="subheader">
				<?php if($this->user->is_administrator() OR $this->session->userdata('user_id') == $comment->user_id): ?>
					<?php $actions = anchor('articles/delete_comment/' . $comment->comment_id, img(array('src' => THEME_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?>
				<?php else: ?>
					<?php $actions = ""; ?>
				<?php endif; ?>
					<?php echo heading(anchor('account/profile/' . $this->users->user_slug($comment->author), $comment->author) . ' Posted ' . mdate("%M %d, %Y at %h:%i %a", $comment->date) . $actions, 4); ?>
				</div>
			<?php echo $comment->comment_title; ?><br /><br />
			
			<?php endforeach; ?>
			<?php else: ?>
				<?php if((bool) $article->article_comments): ?>
					No one has yet commented on this article. <?php if(!$this->user->logged_in()): echo 'Please ' . anchor('account/login', 'login') . ' to post comments.'; endif; ?>
				<?php else: ?>
					Comments are not allowed on this article.
				<?php endif; ?>
			<?php endif; ?>
			</div>
		</div>
		<div class="footer"></div>
	</div>
	<div class="space"></div>
	
	<?php if($comments): ?>
	<div class="box">
		<div class="pages">
			<?php echo heading($pages, 4); ?>
		</div>
	</div>
	<?php endif; ?>

</div>

<?php $this->load->view(THEME . 'footer'); ?>
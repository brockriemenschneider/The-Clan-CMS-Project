<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">

<?php $this->load->widget_area('dashboard'); ?>

<?php if($articles): ?>
	<?php foreach($articles as $article): ?>
	<div class="box">
		<div class="tabs">
		<ul>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('#', 'Summary'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor('articles/view/' . $article->article_slug . '#comments', $article->total_comments . ' Comment(s)'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor('articles/view/' . $article->article_slug, 'Read More'); ?></span><span class="right"></span></li>
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
					<?php echo $article->summary; ?>
			</div>
		</div>
		<div class="footer"></div>
	</div>
	<div class="space"></div>
	<?php endforeach; ?>
<?php endif; ?>

</div>

<?php $this->load->view(THEME . 'footer'); ?>
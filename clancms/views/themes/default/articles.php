<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">
	
<?php if($articles): ?>
<?php $article_count = 0; ?>
	<?php foreach($articles as $article): ?>
	<?php $article_count++; ?>
	<?php if($article_count > 1): ?>
		<div class="space"></div>
	<?php endif; ?>
	<div class="box">
		<div class="tabs">
		<ul>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('articles/#', 'Summary'); ?></span><span class="right"></span></li>
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
	<?php endforeach; ?>
<?php else: ?>
	<div class="box">
		<div class="header">
			<?php echo heading('News Articles', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				There are currently no news articles for this page.
			</div>
		</div>
		<div class="footer"></div>
	</div>
<?php endif; ?>
<?php if($articles): ?>
	<div class="box">
		<div class="pages">
		<ul>
			<?php if($pages): ?>
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('articles/page/' . $pages->current_page, 'Page ' . $pages->current_page . ' of ' . $pages->total_pages); ?></span><span class="right"></span></li>
					<?php if($pages->first): ?><li><span class="left"></span><span class="middle"><?php echo anchor('articles/page/1', '<<'); ?></span><span class="right"></span></li><?php endif; ?>
					<?php if($pages->previous): ?><li><span class="left"></span><span class="middle"><?php echo anchor('articles/page/' . ($pages->current_page - 1), '<'); ?></span><span class="right"></span></li><?php endif; ?>
				
				<?php if($pages->before): ?>
					<?php foreach($pages->before as $before): ?>
						<li <?php if($pages->current_page == $before): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor('articles/page/' . $before, $before); ?></span><span class="right"></span></li>
					<?php endforeach; ?>
				<?php endif; ?>
				
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('articles/page/' . $pages->current_page, $pages->current_page); ?></span><span class="right"></span></li>
				
				<?php if($pages->after): ?>
					<?php foreach($pages->after as $after): ?>
						<li <?php if($pages->current_page == $after): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor('articles/page/' . $after, $after); ?></span><span class="right"></span></li>
					<?php endforeach; ?>
				<?php endif; ?>
				
					<?php if($pages->next): ?><li><span class="left"></span><span class="middle"><?php echo anchor('articles/page/' . ($pages->current_page + 1), '>'); ?></span><span class="right"></span></li><?php endif; ?>
					<?php if($pages->last): ?><li><span class="left"></span><span class="middle"><?php echo anchor('articles/page/' . $pages->total_pages, '>>'); ?></span><span class="right"></span></li><?php endif; ?>
			<?php endif; ?>
		</ul>
		</div>
	</div>
<?php endif; ?>
</div>

<?php $this->load->view(THEME . 'footer'); ?>
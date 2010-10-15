<?php if($articles): ?>
	<ul id="ticker">
	<?php foreach($articles as $article): ?>
		<li><?php echo $article->article_title; ?> - <?php echo anchor('articles/view/' . $article->article_slug, 'View Article', array('class' => 'yellow')); ?></li>
	<?php endforeach; ?>
	</ul>
<?php else: ?>
	There are currently no articles
<?php endif; ?>
<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">

<?php if($slides): ?>
	<div id="slider-wrapper">
		<div id="slider" class="nivoSlider">
		<?php foreach($slides as $slide): ?>
				<?php if($slide->slider_link): echo anchor($slide->slider_link, img(array('src' => IMAGES . 'slider/slides/' . $slide->slider_image, 'title' => '#slide' . $slide->slider_id, 'rel' => IMAGES . 'slider/previews/' . $slide->slider_image))); else: echo img(array('src' => IMAGES . 'slider/slides/' . $slide->slider_image, 'title' => '#slide' . $slide->slider_id, 'rel' => IMAGES . 'slider/previews/' . $slide->slider_image)); endif;?>
		<?php endforeach; ?>
		</div>
		
		<?php foreach($slides as $slide): ?>
		<div id="slide<?php echo $slide->slider_id; ?>" class="nivo-html-caption">
				<h4><?php echo $slide->slider_title; ?></h4> <?php echo $slide->slider_content; ?> <?php if($slide->slider_link): echo anchor($slide->slider_link, 'Read More'); endif; ?>
		</div>
		<?php endforeach; ?>
	</div>
	
	<div class="space"></div>
<?php endif; ?>

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
			<?php if($this->user->logged_in() && !$article->tracked): ?>
				<?php echo img(array('src' => THEME_URL . 'images/new.png', 'alt' => 'new', 'height' => 32, 'width' => 32, 'class' => 'new')); ?>
			<?php endif; ?>
			<?php if($article->squad): ?>
				<?php echo heading($article->squad . ': ' . $article->article_title, 4); ?>
			<?php else: ?>
				<?php echo heading($article->article_title, 4); ?>
			<?php endif; ?>
		</div>
		<div class="content">
			<div class="inside">
			
			<div><?php if($article->article_game): echo img(IMAGES . 'headers/' . $article->article_game); else: echo img(IMAGES . 'headers/default.png'); endif; ?></div>
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
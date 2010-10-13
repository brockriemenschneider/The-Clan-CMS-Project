<?php echo doctype('xhtml1-trans'); ?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head> 
	<title><?php echo CLAN_NAME; ?> - Powered By Clan CMS v<?php echo CLANCMS_VERSION; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php echo link_tag('favicon.ico', 'shortcut icon', 'image/ico'); ?>
	<?php echo link_tag(THEME_URL . 'style.css'); ?>
	<?php echo link_tag(THEME_URL . 'js/jquery-ui-1.8.4.custom.css'); ?>
	<script type="text/javascript" src="<?php echo THEME_URL; ?>js/jquery-1.4.2.min.js"></script> 
	<script type="text/javascript" src="<?php echo THEME_URL; ?>js/jquery-ui-1.8.2.custom.min.js"></script>
	<script type="text/javascript" src="<?php echo THEME_URL; ?>js/jquery.newsticker.js"></script>
	<script type="text/javascript"> 
        $(function(){
			$(".submit").button();
			
			$("ul#ticker").liScroll();
		});
	</script>
	
	
</head>

<body>
<div id="header">
	<div id="top">
		<div class="left">Welcome to <?php echo anchor('', CLAN_NAME, array('class' => 'orange')); ?></div>
		<?php if($this->user->logged_in()): ?>
		<div class="right">Welcome back, <?php echo anchor('account/profile/' . $this->users->user_slug($this->session->userdata('username')), $this->session->userdata('username'), array('class' => 'orange')); ?> | <?php if($this->user->is_administrator()): echo anchor('admincp','Admin CP', array( 'class' => 'orange')) . ' | '; endif; ?><?php echo anchor('account/logout', 'Logout', array('class' => 'orange')); ?></div>
		<?php else: ?>
		<div class="right"><?php echo img(array('src' => THEME_URL . 'images/controller.png', 'alt' => 'Controller')); ?><?php echo nbs(2); ?> <?php echo anchor('register', 'Register', array('class' => 'orange')); ?> | <?php echo anchor('account/login', 'Login', array('class' => 'orange')); ?></div>
		<?php endif; ?>
		<div class="middle"><span class="title">Just In:</span> 
			<?php $this->load->widget('articles'); ?>
		</div>

	</div>
	<div id="banner"><?php if((bool) $this->ClanCMS->get_setting('logo')): ?><?php echo img(array('src' => THEME_URL . 'images/logo.png', 'alt' => 'Logo', 'id' => 'logo')); ?><?php else: ?><h1><?php echo CLAN_NAME; ?></h1><h2><?php echo $this->ClanCMS->get_Setting('clan_slogan'); ?></h2><?php endif; ?></div>
	<div id="navigation">
	<ul>
		<li <?php if($this->uri->segment(1) == ''): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor('', 'Home'); ?></span><span class="right"></span></li>
		<li <?php if($this->uri->segment(1) == 'account' OR $this->uri->segment(1) == 'register'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php if($this->user->logged_in()): echo anchor('account', 'My Account'); else: echo anchor('register', 'My Account'); endif; ?></span><span class="right"></span></li>
		<?php if($this->ClanCMS->get_setting('forum_link')): ?><li><span class="left"></span><span class="middle"><?php echo anchor($this->ClanCMS->get_setting('forum_link'), 'Forums'); ?></span><span class="right"></span></li><?php endif; ?>
		<li <?php if($this->uri->segment(1) == 'articles'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor('articles', 'News Articles'); ?></span><span class="right"></span></li>
		<li <?php if($this->uri->segment(1) == 'roster'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor('roster', 'Team Roster'); ?></span><span class="right"></span></li>
		<li <?php if($this->uri->segment(1) == 'matches'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor('matches', 'Matches'); ?></span><span class="right"></span></li>
		<li <?php if($this->uri->segment(1) == 'sponsors'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor('sponsors', 'Sponsors'); ?></span><span class="right"></span></li>
		<li <?php if($this->uri->segment(1) == 'about'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor('about', 'About ' . CLAN_NAME); ?></span><span class="right"></span></li>		
	</ul>
	</div>
</div>
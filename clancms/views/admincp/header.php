<?php echo doctype('xhtml1-trans'); ?>
<html>

<head> 
	<title><?php echo CLAN_NAME; ?> Admin CP - Powered By Clan CMS v<?php echo CLANCMS_VERSION; ?></title>
	<?php echo link_tag('favicon.ico', 'shortcut icon', 'image/ico'); ?>
	<?php echo link_tag(ADMINCP_URL . 'style.css'); ?>
	<?php echo link_tag(ADMINCP_URL . 'js/jquery-ui-1.8.4.custom.css'); ?>
	<script type="text/javascript" src="<?php echo ADMINCP_URL; ?>js/jquery-1.4.2.min.js"></script> 
	<script type="text/javascript" src="<?php echo ADMINCP_URL; ?>js/jquery-ui-1.8.2.custom.min.js"></script>
	<script type="text/javascript" src="<?php echo THEME_URL; ?>js/jquery.newsticker.js"></script>
	<script type="text/javascript" src="<?php echo ADMINCP_URL; ?>js/markitup/markitup/jquery.markitup.js"></script>
	<script type="text/javascript" src="<?php echo ADMINCP_URL; ?>js/markitup/markitup/sets/bbcode/set.js"></script> 
	<script type="text/javascript"> 
        $(function(){
			$(".submit").button();
			
			$(".datepicker").datepicker({
				showOn: 'button',
				buttonImage: '<?php echo ADMINCP_URL; ?>images/calendar.png',
				buttonImageOnly: true,
				dateFormat: 'yy-mm-dd'
			});

			$("ul#ticker").liScroll();
			
			$('#wysiwyg').markItUp(mySettings);

			$('#emoticons a').click(function() {
				emoticon = $(this).attr("title");
				$.markItUp( { replaceWith:emoticon } );
			});
	
		});
	</script>
</head>

<body>
<div id="header">
	<div id="top">
		<div class="left"><?php echo anchor('', CLAN_NAME, array('class' => 'orange')); ?> Admin Control Panel</div>
		<div class="right">Welcome to the Admin CP, <?php echo anchor('account/profile/' . $this->users->user_slug($this->session->userdata('username')), $this->session->userdata('username'), array('class' => 'orange')); ?> | <?php echo anchor('account/logout', 'Logout', array('class' => 'orange')); ?></div>
		
		<div class="middle"><span class="title">Alerts:</span>
			<?php $this->load->widget(ADMINCP . 'alerts'); ?>
		</div>
	</div>
	<div id="banner"><?php if((bool) $this->ClanCMS->get_setting('logo')): ?><?php echo anchor(ADMINCP, img(array('src' => ADMINCP_URL . 'images/logo.png', 'alt' => 'Logo', 'id' => 'logo'))); ?><?php else: ?><?php echo anchor(ADMINCP, '<h1>' . CLAN_NAME . '</h1><h2>Admin Control Panel</h2>'); ?><?php endif; ?></div>
	<div id="navigation">
	<ul>
		<li <?php if($this->uri->segment(2, '') == ''): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP, 'Dashboard'); ?></span><span class="right"></span></li>
		<li <?php if($this->uri->segment(2, '') == 'settings'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'settings', 'Site Settings'); ?></span><span class="right"></span></li>
		<li <?php if($this->uri->segment(2, '') == 'articles'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles', 'News Articles'); ?></span><span class="right"></span>
			<ul>
				<li <?php if($this->uri->segment(2, '') == 'articles' && $this->uri->segment(3, '') == 'drafts'): echo 'class="selected"'; endif; ?>><?php echo anchor(ADMINCP . 'articles/drafts', 'Drafts'); ?></li>
				<li <?php if($this->uri->segment(2, '') == 'articles' && $this->uri->segment(3, '') == 'add'): echo 'class="selected"'; endif; ?>><?php echo anchor(ADMINCP . 'articles/add', 'Add News Article'); ?></li>
			</ul>
		</li>
		<li <?php if($this->uri->segment(2, '') == 'matches'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'matches', 'Matches'); ?></span><span class="right"></span>
			<ul>
				<li <?php if($this->uri->segment(2, '') == 'matches' && $this->uri->segment(3, '') == 'add'): echo 'class="selected"'; endif; ?>><?php echo anchor(ADMINCP . 'matches/add', 'Add Match'); ?></li>
			</ul>
		</li>
		<li <?php if($this->uri->segment(2, '') == 'squads'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'squads', 'Squads'); ?></span><span class="right"></span>
			<ul>
				<li <?php if($this->uri->segment(2, '') == 'squads' && $this->uri->segment(3, '') == 'add'): echo 'class="selected"'; endif; ?>><?php echo anchor(ADMINCP . 'squads/add', 'Add Squad'); ?></li>
			</ul>
		</li>
		<li <?php if($this->uri->segment(2, '') == 'sponsors'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'sponsors', 'Sponsors'); ?></span><span class="right"></span>
			<ul>
				<li <?php if($this->uri->segment(2, '') == 'sponsors' && $this->uri->segment(3, '') == 'add'): echo 'class="selected"'; endif; ?>><?php echo anchor(ADMINCP . 'sponsors/add', 'Add Sponsor'); ?></li>
			</ul>
		</li>
		<li <?php if($this->uri->segment(2, '') == 'users'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'users', 'Users'); ?></span><span class="right"></span>
			<ul>
				<li <?php if($this->uri->segment(2, '') == 'users' && $this->uri->segment(3, '') == 'add'): echo 'class="selected"'; endif; ?>><?php echo anchor(ADMINCP . 'users/add', 'Add User'); ?></li>
			</ul>
		</li>
		<li <?php if($this->uri->segment(2, '') == 'usergroups'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'usergroups', 'User Groups'); ?></span><span class="right"></span>
			<ul>
				<li <?php if($this->uri->segment(2, '') == 'usergroups' && $this->uri->segment(3, '') == 'add'): echo 'class="selected"'; endif; ?>><?php echo anchor(ADMINCP . 'usergroups/add', 'Add User Group'); ?></li>
			</ul>
		</li>
		<li <?php if($this->uri->segment(2, '') == 'polls'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'polls', 'Polls'); ?></span><span class="right"></span>
			<ul>
				<li <?php if($this->uri->segment(2, '') == 'polls' && $this->uri->segment(3, '') == 'add'): echo 'class="selected"'; endif; ?>><?php echo anchor(ADMINCP . 'polls/add', 'Add Poll'); ?></li>
			</ul>
		</li>
		<li <?php if($this->uri->segment(2, '') == 'pages' OR $this->uri->segment(2, '') == 'themes' OR $this->uri->segment(2, '') == 'widgets'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(uri_string() . '#', 'Customize'); ?></span><span class="right"></span>
			<ul>
				<li <?php if($this->uri->segment(2, '') == 'pages'): echo 'class="selected"'; endif; ?>><?php echo anchor(ADMINCP . 'pages', 'Pages'); ?>
					<ul class="subnav">
						<li <?php if($this->uri->segment(2, '') == 'pages' && $this->uri->segment(3, '') == 'add'): echo 'class="selected"'; endif; ?>><?php echo anchor(ADMINCP . 'pages/add', 'Add Page'); ?></li>
					</ul>
				</li>
			</ul>
		</li>
	</ul>
	</div>
</div>
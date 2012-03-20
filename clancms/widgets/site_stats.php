<div id="site_stats">
	<ul class="cats">
		<li>Articles</li>
		<li>Matches</li>
		<li>Opponents</li>
		<li>Squads</li>
		<li>Sponsors</li>
		<li>Users</li>
		<li>User Groups</li>
		<li>Polls</li>
		<li>Pages</li>
		<li>Images</li>
		<li>Shouts</li>
		<li>Widgets</li>
	</ul>
	<ul class="links">
		<li><?php echo anchor(ADMINCP . 'articles', $total_articles_published . ' Published'); ?>, <?php echo anchor(ADMINCP . 'articles/drafts', $total_articles_drafts . ' Drafts'); ?></li>
		<li><?php echo anchor(ADMINCP . 'matches', $total_matches . ' Matches'); ?></li>
		<li><?php echo anchor(ADMINCP . 'opponents', $total_opponents . ' Opponents'); ?></li>
		<li><?php echo anchor(ADMINCP . 'squads', $total_squads . ' Squads'); ?></li>
		<li><?php echo anchor(ADMINCP . 'sponsors', $total_sponsors . ' Sponsors'); ?></li>
		<li><?php echo anchor('roster/users', $total_users . ' Users'); ?></li>
		<li><?php echo anchor(ADMINCP . 'usergroups', $total_usergroups_default . ' Default'); ?>, <?php echo anchor(ADMINCP . 'usergroups', $total_usergroups_custom . ' Custom'); ?></li>
		<li><?php echo anchor('polls', $total_polls . ' Polls'); ?>
		<li><?php echo anchor(ADMINCP . 'pages', $total_pages . ' Pages'); ?></li>
		<li><?php echo anchor('gallery', $total_images . ' images'); ?></li>
		<li><?php echo anchor('shouts', $total_shouts . ' shouts'); ?></li>
		<li><?php echo anchor(ADMINCP . 'widgets', $total_widgets . ' Installed'); ?></li>
	</ul>
	<div class="clear"></div>
</div>
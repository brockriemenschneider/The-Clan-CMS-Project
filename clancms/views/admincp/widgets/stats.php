<div class="widget">
	<div class="header"></div>
	<div class="content">
		<div class="inside">
				
			<div class="subheader">
				<?php echo heading('Site Stats', 4); ?>
			</div>
			Articles: <?php echo anchor(ADMINCP . 'articles', $total_articles_published . ' Published'); ?>, <?php echo anchor(ADMINCP . 'articles/drafts', $total_articles_drafts . ' Drafts'); ?>
			<?php echo br(); ?>
			Matches: <?php echo anchor(ADMINCP . 'matches', $total_matches . ' Matches'); ?>
			<?php echo br(); ?>
			Squads: <?php echo anchor(ADMINCP . 'squads', $total_squads . ' Squads'); ?>
			<?php echo br(); ?>
			Sponsors: <?php echo anchor(ADMINCP . 'sponsors', $total_sponsors . ' Sponsors'); ?>
			<?php echo br(); ?>
			Users: <?php echo anchor(ADMINCP . 'users', $total_users . ' Users'); ?>
			<?php echo br(); ?>
			User Groups: <?php echo anchor(ADMINCP . 'usergroups', $total_usergroups_default . ' Default'); ?>, <?php echo anchor(ADMINCP . 'usergroups', $total_usergroups_custom . ' Custom'); ?>
			<?php echo br(); ?>
			Pages: <?php echo anchor(ADMINCP . 'pages', $total_pages . ' Pages'); ?>
			<?php echo br(); ?>
		</div>
	</div>
	<div class="footer"></div>
</div>
<div id="site_stats">
	<ul class="cats">
		<li>Articles</li>
		<li>Matches</li>
		<li>Opponents</li>
		<li>Squads</li>
		<li>Users</li>
		<li>Polls</li>
		<li>Images</li>
		<li>Videos</li>
		<li>Shouts</li>
		<li>Events</li>
	</ul>
	<ul class="links">
		<li><?php echo anchor('articles', $total_articles_published . ' Published'); ?></li>
		<li><?php echo anchor('matches', $total_matches . ' Matches'); ?></li>
		<li><?php echo anchor('opponents', $total_opponents . ' Opponents'); ?></li>
		<li><?php echo anchor('squads', $total_squads . ' Squads'); ?></li>
		<li><?php echo anchor('roster/users', $total_users . ' Users'); ?></li>
		<li><?php echo anchor('polls', $total_polls . ' Polls'); ?>
		<li><?php echo anchor('gallery/images', $total_images . ' Images'); ?></li>
		<li><?php echo anchor('gallery/videos', $total_videos . ' Videos'); ?></li>
		<li><?php echo anchor('shouts', $total_shouts . ' Shouts'); ?></li>
		<li><?php echo anchor('events', $total_events . ' Events'); ?></li>
	</ul>
	<div class="clear"></div>
</div>
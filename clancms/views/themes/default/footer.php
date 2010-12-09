<div class="clear"></div>

<div id="footer"> 
	<div class="copyright">Copyright &copy; <?php echo mdate('%Y'); ?> <?php echo anchor('', CLAN_NAME); ?> All Rights Reserved. Powered By <?php echo anchor('http://www.xcelgaming.com', 'Clan CMS v' . CLANCMS_VERSION); ?></div> 
	<div class="links"> 
		<?php echo anchor('', 'Home'); ?> | 
		<?php if($this->user->logged_in()): echo anchor('account', 'My Account'); else: echo anchor('register', 'Register'); endif; ?> |
		<?php if($this->ClanCMS->get_setting('forum_link')): ?><?php echo anchor($this->ClanCMS->get_setting('forum_link'), 'Forums'); ?> | <?php endif; ?>
		<?php echo anchor('articles', 'News Articles'); ?> | 
		<?php echo anchor('roster', 'Team Roster'); ?> | 
		<?php echo anchor('matches', 'Matches'); ?> | 
		<?php echo anchor('sponsors', 'Sponsors'); ?> |
		<?php echo anchor('polls', 'Polls'); ?>
	</div> 
</div> 

</body>

</html>
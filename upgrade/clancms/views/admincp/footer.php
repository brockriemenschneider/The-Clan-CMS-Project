<div class="clear"></div>

<div id="footer"> 
	<div class="copyright">Copyright &copy; <?php echo mdate('%Y'); ?> <?php echo anchor('', $this->ClanCMS->get_setting('clan_name')); ?> All Rights Reserved. Powered By <?php echo anchor('http://www.xcelgaming.com', 'Clan CMS v' . CLANCMS_VERSION); ?></div> 
	<div class="links"> 
		<?php echo anchor(ADMINCP, 'Dashboard'); ?> | 
		<?php echo anchor(ADMINCP . 'settings', 'Site Settings'); ?> | 
		<?php echo anchor(ADMINCP . 'articles', 'News Articles'); ?> | 
		<?php echo anchor(ADMINCP . 'matches', 'Matches'); ?> | 
		<?php echo anchor(ADMINCP . 'squads', 'Squads'); ?> | 
		<?php echo anchor(ADMINCP . 'sponsors', 'Sponsors'); ?> | 
		<?php echo anchor(ADMINCP . 'users', 'Users'); ?> | 
		<?php echo anchor(ADMINCP . 'usergroups', 'User Groups'); ?>
	</div> 
</div> 

</body>

</html>
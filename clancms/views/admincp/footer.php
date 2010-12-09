<div class="clear"></div>

<div id="footer"> 
	<div class="copyright">Copyright &copy; <?php echo mdate('%Y'); ?> <?php echo anchor('', $this->ClanCMS->get_setting('clan_name')); ?> All Rights Reserved. Powered By <?php echo anchor('http://www.xcelgaming.com', 'Clan CMS v' . CLANCMS_VERSION); ?></div> 
	<div class="links"> 
		<?php echo anchor(ADMINCP, 'Admin CP Dashboard'); ?> | 
		<?php echo anchor('', CLAN_NAME); ?> | 
		<?php echo anchor(uri_string() . '#', 'Back To Top'); ?>
	</div> 
</div> 

</body>

</html>
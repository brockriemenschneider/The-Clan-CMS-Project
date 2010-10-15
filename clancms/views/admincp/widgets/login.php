<div class="widget">
		<div class="header"></div>
		<div class="content">
			<div class="inside">
				
				Welcome to the Admin CP, <?php echo anchor('account/profile/' . $this->users->user_slug($this->session->userdata('username')), $this->session->userdata('username')); ?>!
				<?php echo br(); ?>
				<?php echo anchor('', CLAN_NAME); ?> | <?php echo anchor('account', 'My Account'); ?> | <?php echo anchor('account/logout', 'Logout'); ?>
				
			</div>
		</div>
		<div class="footer"></div>
		
		<div class="tabs">
		<ul>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('account', 'MY ACCOUNT'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor('account/logout', 'LOGOUT'); ?></span><span class="right"></span></li>
		</ul>
		</div>
	</div>
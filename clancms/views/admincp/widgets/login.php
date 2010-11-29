<div class="widget">
		<div class="header"></div>
		<div class="content">
			<div class="inside">
				<div id="avatar" class="left">
					<?php if($user->user_avatar): ?>
						<?php echo anchor('account/profile/' . $this->users->user_slug($this->session->userdata('username')), img(array('src' => IMAGES . 'avatars/' . $user->user_avatar, 'title' => $this->session->userdata('username'), 'alt' => $this->session->userdata('username'), 'width' => '57', 'height' => '57'))); ?>
					<?php else: ?>
						<?php echo anchor('account/profile/' . $this->users->user_slug($this->session->userdata('username')), img(array('src' => ADMINCP_URL . 'images/avatar_none.png', 'title' => $this->session->userdata('username'), 'alt' => $this->session->userdata('username'), 'width' => '57', 'height' => '57'))); ?>
					<?php endif; ?>
				</div>
				<div id="login">
					<?php echo anchor('account/profile/' . $this->users->user_slug($this->session->userdata('username')), $this->session->userdata('username')); ?>
					<?php echo br(2); ?>
					<?php echo anchor('', CLAN_NAME); ?>
					<?php echo br(); ?>
					<?php echo anchor('account', 'My Account'); ?> | <?php echo anchor('account/logout', 'Logout'); ?>
				</div>
			<div class="clear"></div>
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
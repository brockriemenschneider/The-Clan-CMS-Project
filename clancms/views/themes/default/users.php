<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">
	
	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor('roster', 'All Squads'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('roster/users', 'All Users'); ?></span><span class="right"></span></li>
			<?php if($squads): ?>
				<?php foreach($squads as $squad): ?>
					<li><span class="left"></span><span class="middle">
						<?php if($squad->squad_icon): echo img(array('src' => IMAGES . 'squad_icons/'.$squad->squad_icon, 'alt' => $squad->squad_title, 'height' => '24px', 'width' => '24px', 'title' => $squad->squad_title)); else: echo img(array('src' => IMAGES . 'squad_icons/no_icon.png', 'alt' => $squad->squad_title, 'height' => '24px', 'width' => '24px', 'title' => $squad->squad_title)); endif; ?>
						<?php echo anchor('roster/squad/' . $squad->squad_slug, $squad->squad_title); ?>
						</span><span class="right"></span></li>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('User List', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
			<?php if($users): ?>
				<ul class="memberlist">
					<li>
						<ul class="member_head">
							<li class="icon"></li>
							<li class="icon"></li>
							<li class="icon">ID</li>
							<li class="name">User Name</li>
							<li class="name">User Group</li>
							<li class="social">Social IDs</li>
							<li>Badges</li>
							<li>Level</li>
							<li>DKP</li>
							<li>EXP</li>
						</ul>
					</li>
				<?php foreach($users as $user): ?>
				<li>
					<ul class="member">
						<li class="icon"><?php if($user->user_avatar): echo img(array('src' => IMAGES . 'avatars/'.$user->user_avatar, 'alt' => $user->user_name, 'height' => '24px', 'width' => '24px', 'title' => $user->user_name)); else: echo img(array('src' => IMAGES . 'avatars/avatar_none.png', 'alt' => $user->user_name, 'height' => '24px', 'width' => '24px', 'title' => $user->user_name)); endif;?></li>
						<li class="icon"><?php if($user->online ==1): echo img(array('src' => THEME_URL . 'images/online.png', 'alt' => $user->user_name . ' is online', 'title' => $user->user_name . ' is online')); else: echo img(array('src' => THEME_URL . 'images/offline.png', 'alt' => $user->user_name . ' is offline', 'title' => $user->user_name . ' is offline')); endif;?></li>
						<li class="icon"><?php echo $user->user_id;?></li>
						<li class="name"><?php echo $user->user_name;?></li>
						<li class="name">User Group</li>
					</ul>
				</li>
				<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			</div>
		</div>
		
		
	</div>
	
</div>

<?php $this->load->view(THEME . 'footer'); ?>
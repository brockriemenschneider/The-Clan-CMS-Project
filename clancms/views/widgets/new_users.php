<?php if($new_users): ?>
<div id="newusers">
	<?php foreach($new_users as $new_user): ?>
		<div class="user">
		<div id="avatar">
		<?php if($new_user->user_avatar): ?>
			<?php echo anchor('account/profile/' . $this->users->user_slug($new_user->user_name), img(array('src' => IMAGES . 'avatars/' . $new_user->user_avatar, 'title' => $new_user->user_name, 'alt' => $new_user->user_name, 'width' => '57', 'height' => '57')) . '<span class="username orange">' . $new_user->user_name . '</span>'); ?>
		<?php else: ?>
			<?php echo anchor('account/profile/' . $this->users->user_slug($new_user->user_name), img(array('src' => THEME_URL . 'images/avatar_none.png', 'title' => $new_user->user_name, 'alt' => $new_user->user_name, 'width' => '57', 'height' => '57')) . '<div class="username orange">' . $new_user->user_name . '</div>'); ?>
		<?php endif; ?>
		</div>
		</div>
	<?php endforeach; ?>
</div>
<?php endif; ?>
<div class="space"></div>
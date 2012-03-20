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
				<table id="userTable" class="tablesorter"> 
					<thead> 
						<tr> 
						    <th class="icon">&nbsp;</th> 
						    <th class="name">User Name</th> 
						    <th class="name">User Group</th>
						    <th class="squads">Squads</th>
						    <th class="social">Social IDs</th> 
						    <th class="exp">Badges</th> 
						    <th class="exp">DKP</th> 
						    <th class="exp">EXP</th>
						</tr> 
					</thead> 
					<tbody> 
					
					<?php foreach($users as $user): ?>
						<tr class="item">
							<td class="icon">
								<ul class="member">
									<li><?php if($user->user_avatar): echo img(array('src' => IMAGES . 'avatars/'.$user->user_avatar, 'alt' => $user->user_name, 'height' => '24px', 'width' => '24px', 'title' => $user->user_name)); else: echo img(array('src' => IMAGES . 'avatars/avatar_none.png', 'alt' => $user->user_name, 'height' => '24px', 'width' => '24px', 'title' => $user->user_name)); endif;?></li>
									<li><?php if($user->online ==1): echo img(array('src' => THEME_URL . 'images/online.png', 'alt' => $user->user_name . ' is online', 'title' => $user->user_name . ' is online')); else: echo img(array('src' => THEME_URL . 'images/offline.png', 'alt' => $user->user_name . ' is offline', 'title' => $user->user_name . ' is offline')); endif;?></li>
								</ul>
							</td>
							<td class="name"><?php echo $user->user_name;?></td>
							<td class="name"><?php echo $user->group; ?></td>
							<td class="squads">
								<?php if($user->member): ?>
									<?php foreach($user->member as $squad):
								//	print_r($squad);
										echo anchor('roster/squad' . $squad->squad->squad_slug, img(array('src'=>IMAGES . 'squad_icons/' . $squad->squad->squad_icon, 'title'=>$squad->squad->squad_title, 'height'=>24, 'width'=>24)));
									endforeach; ?>
								<?php endif; ?>
											
							</td>
							<td class="social">
								<?php if($user->social): ?>
									<ul class="social">
										<?php if($user->social->facebook): ?>
											<li class="soc"><?php echo anchor('http://facebook.com/' . $user->social->facebook, img(array('src'=> IMAGES . '24/fb.png'))); ?></li>
										<?php endif; ?>
										<?php if($user->social->twitter): ?>
											<li class="soc"><?php echo anchor('http://facebook.com/' . $user->social->facebook, img(array('src'=> IMAGES . '24/twitter-icon.png'))); ?></li>
										<?php endif; ?>
										<?php if($user->social->steam): ?>
											<li class="soc"><?php echo anchor('http://facebook.com/' . $user->social->facebook, img(array('src'=> IMAGES . '24/steam_icon.png'))); ?></li>
										<?php endif; ?>
										<?php if($user->social->xbox_live): ?>
											<li class="soc"><?php echo anchor('http://facebook.com/' . $user->social->facebook,  img(array('src'=> IMAGES . '24/xbox.png'))); ?></li>
										<?php endif; ?>
										<?php if($user->social->ps_online): ?>
											<li class="soc"><?php echo anchor('http://facebook.com/' . $user->social->facebook, img(array('src'=> IMAGES . '24/ps_online.png'))); ?></li>
										<?php endif; ?>
										<?php if($user->social->skype): ?>
											<li class="soc"><?php echo anchor('http://facebook.com/' . $user->social->facebook, img(array('src'=> IMAGES . '24/skype.png'))); ?></li>
										<?php endif; ?>
										<?php if($user->social->bf3): ?>
											<li class="soc"><?php echo anchor('http://facebook.com/' . $user->social->facebook, img(array('src'=> IMAGES . '24/bf3.png'))); ?></li>
										<?php endif; ?>
										<?php if($user->social->mw3): ?>
											<li class="soc"><?php echo anchor('http://facebook.com/' . $user->social->facebook,  img(array('src'=> IMAGES . '24/mw3.png'))); ?></li>
										<?php endif; ?>
										<?php if($user->social->youtube): ?>
											<li class="soc"><?php echo anchor('http://facebook.com/' . $user->social->facebook, img(array('src'=> IMAGES . '24/youtube.png'))); ?></li>
										<?php endif; ?>
									</ul>
								<?php endif; ?>
							</td>
							<td class="exp">0</td>
							<td class="exp">0</td>
							<td class="exp">0</td>
						</tr>
					<?php endforeach; ?>
					
					</tbody>
				</table>
			<?php endif; ?>
			</div>
		</div>
		<div class="footer"></div>
		
	</div>
</div>

<script type="text/javascript" src="<?php echo THEME_URL; ?>js/tablesorter/jquery.tablesorter.js"></script>
<script type="text/javascript" >
	$(document).ready(function(){ 
	        $("#userTable").tablesorter({
	        	
	        	//sort table on first column
	        	sortList:[[0,0]],
	        	
	        	//disable fixed width
	        	widthFixed: true,
	        	
	        	// non selectable headers
	        	cancelSelection: true,
	        	
	        	// disable options, link, and article sorting
	        	headers: {
	        		0:{sorter: false},
	        		3:{sorter: false},
	        		4:{sorter: false}
	        		}
	        	
		});
	}); 
	
</script>
<?php $this->load->view(THEME . 'footer'); ?>
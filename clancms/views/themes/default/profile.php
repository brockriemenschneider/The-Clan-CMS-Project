<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('account/profile/' . $user->user_name, $user->user_name); ?></span><span class="right"></span></li>
			<?php if($user->user_id == $this->session->userdata('user_id')): ?>
				<li><span class="left"></span><span class="middle"><?php echo anchor('account', 'My Account'); ?></span><span class="right"></span></li>
			<?php endif; ?>
		</ul>
		</div>
	
		<div class="header">
			<?php echo heading($user->user_name . "'s Profile", 4); ?>
		</div>
		<div class="content">
			<div class="inside">
			
				<div class="subheader">
					<?php echo heading('Personal Information', 4); ?>
				</div>
					
				<div class="label"></div>
				<div class="details">
					<div id="avatar">
						<?php if($user->user_avatar): ?>
							<?php echo anchor('account/profile/' . $this->users->user_slug($user->user_name), img(array('src' => IMAGES . 'avatars/' . $user->user_avatar, 'title' => $user->user_name, 'alt' => $user->user_name, 'width' => '57', 'height' => '57'))); ?>
						<?php else: ?>
							<?php echo anchor('account/profile/' . $this->users->user_slug($user->user_name), img(array('src' => THEME_URL . 'images/avatar_none.png', 'title' => $user->user_name, 'alt' => $user->user_name, 'width' => '57', 'height' => '57'))); ?>
						<?php endif; ?>
					</div>
				</div>
				<div class="clear"></div>
				
				<div class="label">Username:</div>
				<div class="details"><?php echo anchor('account/profile/' . $this->users->user_slug($user->user_name), $user->user_name); ?></div>
				<div class="clear"></div>
				
				<div class="label">User Group:</div>
				<div class="details"><?php echo $user->group; ?></div>
				<div class="clear"></div>
				
				<div class="label">Joined:</div>
				<div class="details"><?php echo mdate("%F %j%S, %Y", $user->joined); ?></div>
				<div class="clear"></div>
				
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
	<?php if($members): ?>
	<div class="space"></div>
	
	<div class="box">
		
		<div class="header">
			<?php echo heading('Squad Stats', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
			
		<table>
			<thead>
				<tr>
					<th width="26%">Squad</th>
					<th width="20%">Matches Played</th>
					<th width="8%">W</th>
					<th width="8%">L</th>
					<th width="8%">T</th>
					<th width="10%">Kills</th>
					<th width="10%">Deaths</th>
					<th width="10%">K/D Ratio</th>
				</tr>
			</thead>
			
			<tbody>
				<?php foreach($members as $member): ?>
				<tr>
					<td><?php echo anchor('roster/squad/' . $member->squad_slug, $member->squad_title); ?></td>
					<td><?php echo $member->total_matches_played; ?> out of <?php echo $member->total_matches; ?> (<?php echo $member->matches_percent; ?>%)</td>
					<td class="green"><?php echo $member->total_wins; ?></td>
					<td class="red"><?php echo $member->total_losses; ?></td>
					<td class="yellow"><?php echo $member->total_ties; ?></td>
					<td><?php echo $member->total_kills; ?></td>
					<td><?php echo $member->total_deaths; ?></td>
					<td class="<?php if($member->kd < '1.00'): echo 'red'; elseif($member->kd > '2.00'): echo 'green'; else: echo 'yellow'; endif; ?>"><?php echo $member->kd; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	
			</div>
		</div>
		<div class="footer"></div>
		
	</div>
	
	<div class="space"></div>
	
	<div class="box">
		
		<div class="header">
			<?php echo heading('Recent Matches', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
			
		<table>
			<thead>
				<tr>
					<th width="30%">Opponent</th>
					<th width="30%">Squad</th>
					<th width="10%">Kills</th>
					<th width="10%">Deaths</th>
					<th width="10%">K/D Ratio</th>
					<th width="10%">View</th>
				</tr>
			</thead>
			
			<tbody>
				<?php if($matches): ?>
				<?php foreach($matches as $match): ?>
				<tr>
					<td><?php if($match->opponent): echo anchor('opponents/view/' . $match->opponent_slug, $match->opponent); else: echo 'N/A'; endif; ?></td>
					<td><?php echo anchor('roster/squad/' . $match->squad_slug, $match->squad); ?></td>
					<td><?php echo $match->kills; ?></td>
					<td><?php echo $match->deaths; ?></td>
					<td class="<?php if($match->kd < '1.00'): echo 'red'; elseif($match->kd > '2.00'): echo 'green'; else: echo 'yellow'; endif; ?>"><?php echo $match->kd; ?></td>
					<td><?php echo anchor('matches/view/' . $match->match_slug, img(array('src' => THEME_URL . 'images/view.png', 'alt' => 'View Match', 'title' => 'View Match'))); ?></td>
				</tr>
				<?php endforeach; ?>
				<?php else: ?>
				<tr>
					<td colspan="6">This user has not participated in any matches.</td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	
			</div>
		</div>
		<div class="footer"></div>
		
	</div>
	<?php endif; ?>
	
</div>

<?php $this->load->view(THEME . 'footer'); ?>
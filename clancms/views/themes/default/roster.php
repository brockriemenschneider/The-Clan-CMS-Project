<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">
	
	<div class="box">
		<div class="tabs">
		<ul>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('roster', 'All Squads'); ?></span><span class="right"></span></li>
			<?php if($squads): ?>
				<?php foreach($squads as $squad): ?>
					<li><span class="left"></span><span class="middle"><?php echo anchor('roster/squad/' . $squad->squad_slug, $squad->squad_title); ?></span><span class="right"></span></li>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>
		</div>
		
		<?php if($squads): ?>
		<?php foreach($squads as $squad): ?>
		<div class="header">
			<?php echo heading($squad->squad_title, 4); ?>
		</div>
		<div class="content">
			<div class="inside">
			
		<table>
			<thead>
				<tr class="top">
					<th width="5%"></th>
					<th width="30%">Member</th>
					<th width="25%">Role</th>
					<th width="10%">Kills</th>
					<th width="10%">Deaths</th>
					<th width="10%">K/D Ratio</th>
					<th width="10%">Stats</th>
				</tr>
			</thead>
			
			<tbody>
			<?php if ($squad->members): ?>
				<?php foreach($squad->members as $member): ?>
				<tr class="row">
					<td><?php if($member->online): echo anchor('account/profile/' . $this->users->user_slug($member->user_name), img(array('src' => THEME_URL . 'images/online.png', 'alt' => $member->user_name . ' is online', 'title' => $member->user_name . ' is online'))); else: echo anchor('account/profile/' . $this->users->user_slug($member->user_name), img(array('src' => THEME_URL . 'images/offline.png', 'alt' => $member->user_name . ' is offline', 'title' => $member->user_name . ' is offline'))); endif; ?></td>
					<td><?php if($squad->squad_tag && (bool) !$squad->squad_tag_position): echo '[' . $squad->squad_tag . '] '; endif; ?><?php if($member->member_title): echo anchor('account/profile/' . $this->users->user_slug($member->user_name), $member->member_title); else: echo anchor('account/profile/' . $this->users->user_slug($member->user_name), $member->user_name); endif; ?><?php if($squad->squad_tag && (bool) $squad->squad_tag_position): echo ' [' . $squad->squad_tag . ']'; endif; ?></td>
					<td><?php if($member->member_role): echo $member->member_role; else: echo 'N/A'; endif; ?></td>
					<td><?php echo $member->total_kills; ?></td>
					<td><?php echo $member->total_deaths; ?></td>
					<td class="<?php if($member->kd < '1.00'): echo 'red'; elseif($member->kd > '2.00'): echo 'green'; else: echo 'yellow'; endif; ?>"><?php echo $member->kd; ?></td>
					<td><?php echo anchor('account/profile/' . $this->users->user_slug($member->user_name), img(array('src' => THEME_URL . 'images/stats.png', 'alt' => $member->user_name . "'s stats", 'title' => $member->user_name . "'s stats"))); ?></td>
				</tr>
				<?php endforeach; ?>
				<?php else: ?>
				<tr class="row">
					<td colspan="7">This squad currently has no members.</td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	
			</div>
		</div>
		<div class="footer"></div>
		<div class="space"></div>
		<?php endforeach; ?>
		<?php else: ?>
		<div class="header">
			<?php echo heading(CLAN_NAME . ' Squads', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				<?php echo CLAN_NAME; ?> currently has no squads.
			</div>
		</div>
		<div class="footer"></div>
		<div class="space"></div>
		<?php endif; ?>
		
	</div>
	
</div>

<?php $this->load->view(THEME . 'footer'); ?>
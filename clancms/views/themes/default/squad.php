<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">
	
	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor('roster', 'All Squads'); ?></span><span class="right"></span></li>
			<?php if($squads): ?>
				<?php foreach($squads as $tab): ?>
					<li <?php if($squad->squad_id == $tab->squad_id): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor('roster/squad/' . $tab->squad_slug, $tab->squad_title); ?></span><span class="right"></span></li>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Roster', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
			
		<table>
			<thead>
				<tr>
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
			<?php if($squad->members): ?>
				<?php foreach($squad->members as $member): ?>
				<tr>
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
				<tr>
					<td colspan="7">This squad currently has no members.</td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	
			</div>
		</div>
		<div class="footer"></div>
		
	</div>
	
	<div class="space"></div>
	
	<div class="box">
		
		<div class="header">
			<?php echo heading('News Articles', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
			
		<table>
			<thead>
				<tr>
					<th width="45%">Title</th>
					<th width="20%">Author</th>
					<th width="25%">Date & Time</th>
					<th width="10%">View</th>
				</tr>
			</thead>
			
			<tbody>
				<?php if($articles): ?>
				<?php foreach($articles as $article): ?>
				<tr>
					<td><?php echo anchor('articles/view/' . $article->article_slug, $article->article_title); ?></td>
					<td><?php echo anchor('account/profile/' . $this->users->user_slug($article->author), $article->author); ?></td>
					<td><?php echo mdate("%M %d, %Y at %h:%i %a", $article->date); ?></td>
					<td><?php echo anchor('articles/view/' . $article->article_slug, img(array('src' => THEME_URL . 'images/view.png', 'alt' => 'View Article', 'title' => 'View Article'))); ?></td>
				</tr>
				<?php endforeach; ?>
				<?php else: ?>
				<tr>
					<td colspan="4">There are currently no articles for this squad.</td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	
			</div>
		</div>
		<div class="footer"></div>
		
	</div>
	
	<div class="space"></div>
	
	<div class="box">
		
		<div class="header">
			<?php echo heading('Matches', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
			
		<table>
			<thead>
				<tr>
					<th width="40%">Opponent</th>
					<th width="20%">Score</th>
					<th width="30%">Date & Time</th>
					<th width="10%">View</th>
				</tr>
			</thead>
			
			<tbody>
				<?php if($matches): ?>
				<?php foreach($matches as $match): ?>
				<tr class="row">
					<td><?php if($match->opponent): echo anchor('opponents/view/' . $match->opponent_slug, $match->opponent); else: echo 'N/A'; endif; ?></td>
					<td <?php if($match->match_score > $match->match_opponent_score): echo 'class="green"'; elseif($match->match_score < $match->match_opponent_score): echo 'class="red"'; elseif($match->match_score == $match->match_opponent_score && $match->match_date < mdate('%Y-%m-%d %H:%i:%s', local_to_gmt(time()))): echo 'class="yellow"'; else: echo ''; endif;?>><?php if($match->match_date < mdate('%Y-%m-%d %H:%i:%s', local_to_gmt(time()))): echo $match->match_score . ' - ' . $match->match_opponent_score; else: echo '-'; endif; ?></td>
					<td><?php echo mdate("%M %d, %Y at %h:%i %a", $match->date); ?></td>
					<td><?php echo anchor('matches/view/' . $match->match_slug, img(array('src' => THEME_URL . 'images/view.png', 'alt' => 'View Match', 'title' => 'View Match'))); ?></td>
				</tr>
				<?php endforeach; ?>
				<?php else: ?>
				<tr>
					<td colspan="4">There are currently no matches for this squad.</td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	
			</div>
		</div>
		<div class="footer"></div>
		
	</div>
	
</div>

<?php $this->load->view(THEME . 'footer'); ?>
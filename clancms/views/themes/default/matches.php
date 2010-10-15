<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">
	
	<div class="box">
		<div class="tabs">
		<ul>
			<li <?php if($this->uri->segment(2, '') != 'upcoming'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor('matches', 'Latest Matches'); ?></span><span class="right"></span></li>
			<li <?php if($this->uri->segment(2, '') == 'upcoming'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor('matches/upcoming', 'Upcoming Matches'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
		<?php if($this->uri->segment(2) == 'upcoming'): ?>
			<?php echo heading('Upcoming Matches', 4); ?>
		<?php else: ?>
			<?php echo heading('Latest Matches', 4); ?>
		<?php endif; ?>
		</div>
		<div class="content">
			<div class="inside">
			
		<table>
			<thead>
				<tr>
					<th width="30%">Opponent</th>
					<th width="25%">Squad</th>
					<th width="10%">Score</th>
					<th width="25%">Date & Time</th>
					<th width="10%">View</th>
				</tr>
			</thead>
			
			<tbody>
				<?php if($matches): ?>
				<?php foreach($matches as $match): ?>
				<tr>
					<td><?php if($match->match_opponent_link): echo anchor($match->match_opponent_link, $match->match_opponent); else: echo $match->match_opponent; endif; ?></td>
					<td><?php if($match->squad): echo $match->squad; else: echo "N/A"; endif; ?></td>
					<td <?php if($match->match_score > $match->match_opponent_score): echo 'class="green"'; elseif($match->match_score < $match->match_opponent_score): echo 'class="red"'; else: echo 'class="yellow"'; endif;?>><?php echo $match->match_score . ' - ' . $match->match_opponent_score; ?></td>
					<td><?php echo mdate("%M %d, %Y  at %h:%i %a", $match->date); ?></td>
					<td><?php echo anchor('matches/view/' . $match->match_slug, img(array('src' => THEME_URL . 'images/view.png', 'alt' => 'View Match', 'title' => 'View Match'))); ?></td>
				</tr>
				<?php endforeach; ?>
				<?php else: ?>
				<tr>
					<td colspan="5">There are currently no <?php if($this->uri->segment(2, '') == 'upcoming'): echo 'upcoming'; else: echo 'recent'; endif; ?> matches.</td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	
			</div>
		</div>
		<div class="footer"></div>
		
	</div>
	
	<?php if($matches): ?>
	<div class="space"></div>
	
	<div class="box">
		<div class="pages">
			<?php echo heading($pages, 4); ?>
		</div>
	</div>
	<?php endif; ?>
	
</div>

<?php $this->load->view(THEME . 'footer'); ?>
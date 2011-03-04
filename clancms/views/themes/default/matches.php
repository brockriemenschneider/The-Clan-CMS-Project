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
					<td><?php if($match->opponent): echo anchor('opponents/view/' . $match->opponent_slug, $match->opponent); else: echo 'N/A'; endif; ?></td>
					<td><?php if($match->squad): echo $match->squad; else: echo "N/A"; endif; ?></td>
					<td <?php if($match->match_date < mdate('%Y-%m-%d %H:%i:%s', local_to_gmt(time()))): if($match->match_score > $match->match_opponent_score): echo 'class="green"'; elseif($match->match_score < $match->match_opponent_score): echo 'class="red"'; elseif($match->match_score == $match->match_opponent_score): echo 'class="yellow"'; endif; endif; ?>><?php if($match->match_date < mdate('%Y-%m-%d %H:%i:%s', local_to_gmt(time()))): echo $match->match_score . ' - ' . $match->match_opponent_score; else: echo '-'; endif; ?></td>
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
	<div class="box">
		<div class="pages">
		<ul>
			<?php if($pages): ?>
			<?php if($this->uri->segment(2, '') == 'upcoming'): $pages->upcoming = 'upcoming/'; else: $pages->upcoming = ''; endif; ?>
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('matches/' .  $pages->upcoming . 'page/' . $pages->current_page, 'Page ' . $pages->current_page . ' of ' . $pages->total_pages); ?></span><span class="right"></span></li>
					<?php if($pages->first): ?><li><span class="left"></span><span class="middle"><?php echo anchor('matches/' .  $pages->upcoming . 'page/1', '<<'); ?></span><span class="right"></span></li><?php endif; ?>
					<?php if($pages->previous): ?><li><span class="left"></span><span class="middle"><?php echo anchor('matches/' .  $pages->upcoming . 'page/' . ($pages->current_page - 1), '<'); ?></span><span class="right"></span></li><?php endif; ?>
				
				<?php if($pages->before): ?>
					<?php foreach($pages->before as $before): ?>
						<li <?php if($pages->current_page == $before): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor('matches/' .  $pages->upcoming . 'page/' . $before, $before); ?></span><span class="right"></span></li>
					<?php endforeach; ?>
				<?php endif; ?>
				
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('matches/' .  $pages->upcoming . 'page/' . $pages->current_page, $pages->current_page); ?></span><span class="right"></span></li>
				
				<?php if($pages->after): ?>
					<?php foreach($pages->after as $after): ?>
						<li <?php if($pages->current_page == $after): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor('matches/' .  $pages->upcoming . 'page/' . $after, $after); ?></span><span class="right"></span></li>
					<?php endforeach; ?>
				<?php endif; ?>
				
					<?php if($pages->next): ?><li><span class="left"></span><span class="middle"><?php echo anchor('matches/' .  $pages->upcoming . 'page/' . ($pages->current_page + 1), '>'); ?></span><span class="right"></span></li><?php endif; ?>
					<?php if($pages->last): ?><li><span class="left"></span><span class="middle"><?php echo anchor('matches/' .  $pages->upcoming . 'page/' . $pages->total_pages, '>>'); ?></span><span class="right"></span></li><?php endif; ?>
			<?php endif; ?>
		</ul>
		</div>
	</div>
	<?php endif; ?>
	
</div>

<?php $this->load->view(THEME . 'footer'); ?>
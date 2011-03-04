<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor('opponents', 'Opponents'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('opponents/view/' . $opponent->opponent_slug, $opponent->opponent_title); ?></span><span class="right"></span></li>
		</ul>
		</div>
	
		<div class="header">
			<?php echo heading($opponent->opponent_title, 4); ?>
		</div>
		<div class="content">
			<div class="inside">
			
				<div class="subheader">
					<?php echo heading('Opponent Details', 4); ?>
				</div>
				
				<div class="label">Tag:</div>
				<div class="details"><?php if($opponent->opponent_tag): echo $opponent->opponent_tag; else: echo 'N/A'; endif; ?></div>
				<div class="clear"></div>
				
				<div class="label">Website:</div>
				<div class="details"><?php if($opponent->opponent_link): echo anchor($opponent->opponent_link, $opponent->opponent_link); else: echo 'N/A'; endif; ?></div>
				<div class="clear"></div>
				
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
					<th width="40%">Squad</th>
					<th width="20%">Score</th>
					<th width="30%">Date & Time</th>
					<th width="10%">View</th>
				</tr>
			</thead>
			
			<tbody>
				<?php if($matches): ?>
				<?php foreach($matches as $match): ?>
				<tr class="row">
					<td><?php if($match->squad): echo anchor('roster/squad/' . $match->squad_slug, $match->squad); else: echo 'N/A'; endif; ?></td>
					<td <?php if($match->match_date < mdate('%Y-%m-%d %H:%i:%s', local_to_gmt(time()))): if($match->match_score > $match->match_opponent_score): echo 'class="green"'; elseif($match->match_score < $match->match_opponent_score): echo 'class="red"'; elseif($match->match_score == $match->match_opponent_score): echo 'class="yellow"'; endif; endif; ?>><?php if($match->match_date < mdate('%Y-%m-%d %H:%i:%s', local_to_gmt(time()))): echo $match->match_opponent_score . ' - ' . $match->match_score; else: echo '-'; endif; ?></td>
					<td><?php echo mdate("%M %d, %Y at %h:%i %a", $match->date); ?></td>
					<td><?php echo anchor('matches/view/' . $match->match_slug, img(array('src' => THEME_URL . 'images/view.png', 'alt' => 'View Match', 'title' => 'View Match'))); ?></td>
				</tr>
				<?php endforeach; ?>
				<?php else: ?>
				<tr>
					<td colspan="4">There are currently no matches for this opponent.</td>
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
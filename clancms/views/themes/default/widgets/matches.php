<div class="widget">

	<div class="header"></div>
		
	<div class="content">
		<div class="inside">
				
			<table>
				<thead>
					<tr class="top">
						<th>Date</th>
						<th>Opponent</th>
						<th>Result</th>
					</tr>
				</thead>
			
				<tbody>	
				<?php if($matches): ?>
					<?php foreach($matches as $match): ?>
					<tr>
						<td><?php echo mdate("%m/%d/%y", $match->date); ?></td>
						<td><?php if($match->opponent): echo anchor('opponents/view/' . $match->opponent_slug, $match->opponent); else: echo 'N/A'; endif; ?></td>
						<td <?php if($match->match_score > $match->match_opponent_score): echo 'class="green"'; elseif($match->match_score < $match->match_opponent_score): echo 'class="red"'; else: echo 'class="yellow"'; endif;?>><?php echo $match->match_score . ' - ' . $match->match_opponent_score; ?></td>
					</tr>
					<?php endforeach; ?>
				<?php else: ?>
					<tr class="row">
						<td colspan="3"><?php echo CLAN_NAME; ?> has not played any matches.</td>
					</tr>
				<?php endif; ?>
				</tbody>
			</table>
				
		</div>
	</div>
		
	<div class="footer"></div>
	
	<div class="tabs">
	<ul>
		<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('matches', 'MATCHES'); ?></span><span class="right"></span></li>
		<li><span class="left"></span><span class="middle"><?php echo anchor('matches/upcoming', 'UPCOMING MATCHES'); ?></span><span class="right"></span></li>
	</ul>
	</div>
</div>
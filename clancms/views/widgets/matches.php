			<table>
				<thead>
					<tr>
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
					<tr>
						<td colspan="3"><?php if((bool) $setting['matches_type']): ?><?php echo CLAN_NAME; ?> has no upcoming matches.<?php else: ?><?php echo CLAN_NAME; ?> has not played any matches.<?php endif; ?></td>
					</tr>
				<?php endif; ?>
				</tbody>
			</table>
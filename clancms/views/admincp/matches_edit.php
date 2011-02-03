<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

 <script type="text/javascript">
	$(function() {
	
	$("input[name='new_opponent']").change( function() {
		if($("input[name='new_opponent']:checked").val() == 1)
		{
			$('#opponents').hide();
			$('#new_opponent').show();
		}
		else
		{
			$('#opponents').show();
			$('#new_opponent').hide();
		}
	});
	
	if($("input[name='new_opponent']:checked").val() == 0)
	{
		$('#new_opponent').hide();
	}
	
	
		$("input[name=players]").keyup(function() {
			var vs = $(this).val();
			var length = vs.length;
			
			$("#players").html(vs);
		});
		
		$('input[name^=kills]').keyup(function() {
			var member = $(this).attr("id");
			var kills = $("input[name=kills[" + member + "]]").val();
			var deaths = $("input[name=deaths[" + member + "]]").val();
			
			if(deaths == '' || deaths == 0)
			{
				var kd = (kills / 1).toFixed(2);
			}
			else
			{
				var kd = (kills / deaths).toFixed(2);
			}
			
			$("#playerkd_" + member).html(kd);
		});
		
		$('input[name^=deaths]').keyup(function() {
			var member = $(this).attr("id");
			var kills = $("input[name=kills[" + member + "]]").val();
			var deaths = $("input[name=deaths[" + member + "]]").val();
			
			if(deaths == '' || deaths == 0)
			{
				var kd = (kills / 1).toFixed(2);
			}
			else
			{
				var kd = (kills / deaths).toFixed(2);
			}
			
			$("#playerkd_" + member).html(kd);
		});
		
			
		$('input[name^=member_kills]').keyup(function() {
			var member = $(this).attr("id");
			var kills = $("input[name=member_kills[" + member + "]]").val();
			var deaths = $("input[name=member_deaths[" + member + "]]").val();
			
			if(deaths == '' || deaths == 0)
			{
				var kd = (kills / 1).toFixed(2);
			}
			else
			{
				var kd = (kills / deaths).toFixed(2);
			}
			
			$("#memberkd_" + member).html(kd);
		});
		
		$('input[name^=member_deaths]').keyup(function() {
			var member = $(this).attr("id");
			var kills = $("input[name=member_kills[" + member + "]]").val();
			var deaths = $("input[name=member_deaths[" + member + "]]").val();
			
			if(deaths == '' || deaths == 0)
			{
				var kd = (kills / 1).toFixed(2);
			}
			else
			{
				var kd = (kills / deaths).toFixed(2);
			}
			
			$("#memberkd_" + member).html(kd);
		});
	});		
	
	function integer(evt) {
		var charCode = ( evt.which ) ? evt.which : event.keyCode;
		return ( charCode >= 48 && charCode <= 57 );
	}
</script> 
<?php echo form_open(ADMINCP . 'matches/edit/' . $match->match_id); ?>
<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'matches', 'Matches'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'matches/add', 'Add Match'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'matches/edit/' . $match->match_id, 'Edit Match: ' . $match->squad . ' vs ' . $match->opponent); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Edit Match: ' . $match->squad . ' vs ' . $match->opponent, 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
				<?php if(validation_errors()): ?>
				<div class="alert">
					<?php echo validation_errors(); ?>
				</div>
				<?php endif; ?>
				
				<?php if($this->session->flashdata('message')): ?>
				<div class="alert">
					<?php echo $this->session->flashdata('message'); ?>
				</div>
				<?php endif; ?>
				
				<div class="required-field required">Required Field</div>
				<?php echo br(); ?>
				
				<div class="subheader">
					<?php echo heading('Opponent Information', 4); ?>
				</div>
		
				<div class="label required">New Opponent?</div>
				
				Yes
				<input type="radio" name="new_opponent" value="1" <?php echo set_radio('new_opponent', '1'); ?> class="input" />
				No
				<input type="radio" name="new_opponent" value="0" <?php echo set_radio('new_opponent', '0', TRUE); ?> class="input" />
				
				<?php echo br(); ?>
				<div class="description">Do you want to create a new opponent?</div>
				
				<div id="opponents">
				<div class="label">Opponent</div>
				<?php
					
					$options = array('0' => '',);
					if($opponents):
						foreach($opponents as $opponent):
							$options = $options + array($opponent->opponent_id	=>	$opponent->opponent_title);
						endforeach;
					endif;
					
				echo form_dropdown('opponent_id', $options, set_value('opponent_id', $match->opponent_id), 'class="input select"'); ?>
				<?php echo br(); ?>
				<div class="description">What opponent played this match?</div>
				</div>
				
				<div id="new_opponent">
				<div class="label required">Opponent</div> 
				<?php 
				$data = array(
					'name'		=> 'opponent',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data); ?>
				<?php echo br(); ?>
				<div class="description">Your opponent's team name</div>
				
				<div class="label">Opponent's Link</div>
				
				<?php 
				$data = array(
					'name'		=> 'opponent_link',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('opponent_link')); ?>
				<?php echo br(); ?>
				<div class="description">The link to your opponent</div>
				
				<div class="label">Opponent's Tag</div>
				
				<?php 
				$data = array(
					'name'		=> 'opponent_tag',
					'size'		=> '10',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('opponent_tag')); ?>
				<?php echo br(); ?>
				<div class="description">The opponent's clan tag</div>
				
				</div>
				<?php echo br(); ?>
				
				<div class="subheader">
					<?php echo heading('Match Information', 4); ?>
				</div>
		
				<div class="label required">Squad</div>
				<div class="details"><?php echo anchor(ADMINCP . 'squads/edit/' . $match->squad_id, $match->squad); ?></div>
				<div class="clear"></div>
				
				<div class="label">Type</div>
				
				<?php 
				$data = array(
					'name'		=> 'type',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('type', $match->match_type)); ?>
				<?php echo br(); ?>
				<div class="description">The type of match played</div>
				
				<div class="label">Players</div>
				
				<?php 
				$data = array(
					'name'		=> 'players',
					'size'		=> '1',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('players', $match->match_players), 'onkeypress="return integer(event)"'); ?> v <span id="players"><?php echo $match->match_players; ?></span>
				<div class="description">The number of players on each team</div>
				
				<div class="label">Score</div>
				
				<?php 
				$data = array(
					'name'		=> 'score',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('score', $match->match_score)); ?>
				<?php echo br(); ?>
				<div class="description">Your squad's score</div>
				
				<div class="label">Opponent's Score</div>
				
				<?php 
				$data = array(
					'name'		=> 'opponent_score',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('opponent_score', $match->match_opponent_score)); ?>
				<?php echo br(); ?>
				<div class="description">Your opponent's score</div>
				
				<div class="label">Maps</div>
				
				<?php 
				$data = array(
					'name'		=> 'maps',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('maps', $match->match_maps)); ?>
				<?php echo br(); ?>
				<div class="description">The maps that were played</div>
				
				<div class="label required">Date</div>
				
				<?php 
				$data = array(
					'name'		=> 'date',
					'size'		=> '28',
					'class'		=> 'input datepicker'
				);

				echo form_input($data, set_value('date', mdate('%Y-%m-%d', $match->date))); ?>
				<?php echo br(); ?>
				<div class="description">The date the match was played on</div>
				
				<div class="label required">Time</div>
				
				<?php
					
					$options = array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
						'7' => '7',
						'8' => '8',
						'9' => '9',
						'10' => '10',
						'11' => '11',
						'12' => '12'
					);
					
				echo form_dropdown('hour', $options, set_value('hour', mdate('%g', $match->date)), 'class="input"'); ?>
				:
				<?php
					
					$options = array(
						'00' => '00',
						'15' => '15',
						'30' => '30',
						'45' => '45'
					);
					
				echo form_dropdown('minutes', $options, set_value('minutes', mdate('%i', $match->date)), 'class="input"'); ?>
				
				<?php
					
					$options = array(
						'AM' => 'AM',
						'PM' => 'PM'
					);
					
				echo form_dropdown('ampm', $options, set_value('ampm', mdate('%A', $match->date)), 'class="input"'); ?>
				<?php echo br(); ?>
				<div class="description">The time the match was played</div>
				
				<?php
				$data = array(
					'name'		=> 'report',
					'id'		=> 'wysiwyg',
					'rows'		=> '10',
					'cols'		=> '50'
				);
			
				echo form_textarea($data, set_value('report', $match->match_report)); ?>
				<?php echo br(); ?>
				<div class="description">A report on the match</div>
				
				<?php echo br(); ?>
				<div class="subheader">
					<?php echo heading('Match Settings', 4); ?>
				</div>
				
				<div class="label required">Comments</div> 
				<?php 
					$data = array(
						'name'		=> 'comments',
						'class'		=> 'input',
						);
				
				echo form_radio($data, '1', set_radio('comments', '1', (bool) $match->match_comments)); ?> Allow
			
				<?php 
					$data = array(
						'name'		=> 'comments',
						'class'		=> 'input',
						);
				
				echo form_radio($data, '0', set_radio('comments', '0', (bool) !$match->match_comments)); ?> Disallow
				<?php echo br(); ?>
				
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
	<div class="space"></div>
	
	<div class="box">
		
		<div class="header">
			<?php echo heading('Match Players', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
			<div id="move"></div>
			
			<table id="players">
				<thead>
					<tr>
						<th width="25%">Username</th>
						<th width="25%">Player</th>
						<th width="13%">Kills</th>
						<th width="13%">Deaths</th>
						<th width="14%">K/D Ratio</th>
						<th width="10%">Actions</th>
					</tr>
				</thead>
			
				<tbody>
					<?php if($players): ?>
						<?php foreach($players as $player): ?>
						<tr id="player_<?php echo $player->player_id; ?>">
							<td><?php echo br(); ?><?php echo anchor(ADMINCP . 'users/edit/'. $player->user_id, $player->user_name); ?><?php echo br(2); ?></td>
							<td><?php echo br(); ?><?php if($player->member_title): echo $player->member_title; else: echo $player->user_name; endif; ?><?php echo br(2); ?></td>
							<td><?php
									$data = array(
										'name'		=> 'kills[' . $player->player_id . ']',
										'size'		=> '2',
										'id'		=> $player->player_id
									);

									echo form_input($data, set_value('kills[' . $player->player_id . ']', $player->player_kills), 'onkeypress="return integer(event)"'); ?></td>
							<td><?php
									$data = array(
										'name'		=> 'deaths[' . $player->player_id . ']',
										'size'		=> '2',
										'id'		=> $player->player_id
									);

									echo form_input($data, set_value('deaths[' . $player->player_id . ']', $player->player_deaths), 'onkeypress="return integer(event)"'); ?></td>
							<td id="playerkd_<?php echo $player->player_id; ?>"><?php echo br(); ?><?php echo $player->kd; ?><?php echo br(2); ?></td>
							<td><?php echo anchor(ADMINCP . 'matches/delete_player/' . $player->player_id, img(array('src' => ADMINCP_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?></td>
						</tr>
						<?php endforeach; ?>
					<?php else: ?>
					<tr>
						<td colspan="6">There are currently no players for this match.</td>
					</tr>
					<?php endif; ?>
				</tbody>
			</table>
				<?php 
					$data = array(
						'name'		=> 'update_match',
						'class'		=> 'submit',
						'value'		=> 'Update Match'
					);
				
				echo form_submit($data); ?>
				<div class="clear"></div>
		
			</div>
		</div>
		<div class="footer"></div>
	</div>
	<?php echo form_close(); ?>
	
	<div class="space"></div>
	
	<div class="box">
		
		<div class="header">
			<?php echo heading('Available Members', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
			<table>
				<thead>
					<tr>
						<th width="25%">Username</th>
						<th width="25%">Player</th>
						<th width="13%">Kills</th>
						<th width="13%">Deaths</th>
						<th width="14%">K/D Ratio</th>
						<th width="10%">Actions</th>
					</tr>
				</thead>
			
				<tbody>
					<?php if($members): ?>
						<?php foreach($members as $member): ?>
						<?php echo form_open(ADMINCP . 'matches/add_player/' . $member->member_id); ?>
						<?php echo form_hidden('match_id', $match->match_id); ?>
						<?php echo form_hidden('member_id', $member->member_id); ?>
						<tr>
							<td><?php echo br(); ?><?php echo anchor(ADMINCP . 'users/edit/'. $member->user_id, $member->user_name); ?><?php echo br(2); ?></td>
							<td><?php echo br(); ?><?php if($member->member_title): echo $member->member_title; else: echo $member->user_name; endif; ?><?php echo br(2); ?></td>
							<td><?php
									$data = array(
										'name'		=> 'member_kills[' . $member->member_id . ']',
										'size'		=> '2',
										'id'		=> $member->member_id
									);

									echo form_input($data, set_value('member_kills[' . $member->member_id . ']', ''), 'onkeypress="return integer(event)"'); ?></td>
							<td><?php
									$data = array(
										'name'		=> 'member_deaths[' . $member->member_id . ']',
										'size'		=> '2',
										'id'		=> $member->member_id
									);

									echo form_input($data, set_value('member_deaths[' . $member->member_id . ']', ''), 'onkeypress="return integer(event)"'); ?></td>
							<td id="memberkd_<?php echo $member->member_id; ?>"><?php echo br(); ?>-<?php echo br(2); ?></td>
							<td><input type="image" name="add_player" src="<?php echo ADMINCP_URL . 'images/add.png'; ?>" title="Add" alt="Add" /></td>
						</tr>
						<?php echo form_close(); ?>
						<?php endforeach; ?>
					<?php else: ?>
					<tr>
						<td colspan="6">There are currently no members avaialable to add.</td>
					</tr>
					<?php endif; ?>
				</tbody>
			</table>
			
				<div class="clear"></div>
		
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
	<div class="space"></div>
	
	<div id="comments"></div>
	<div class="box">
		
		<div class="header">
			<?php echo heading('Comments', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
			<?php if($comments): ?>
			<?php foreach($comments as $comment): ?>
				<div class="subheader">
				<?php if($this->user->is_administrator()): ?>
					<?php $actions = anchor(ADMINCP . 'matches/delete_comment/' . $comment->comment_id, img(array('src' => THEME_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?>
				<?php else: ?>
					<?php $actions = ""; ?>
				<?php endif; ?>
					<?php echo heading(anchor(ADMINCP . 'users/edit/' . $comment->user_id, $comment->author) . ' Posted ' . mdate("%M %d, %Y at %h:%i %a", $comment->date) . $actions, 4); ?>
				</div>
		<div id="avatar" class="left">
		<?php if($comment->avatar): ?>
			<?php echo anchor('account/profile/' . $this->users->user_slug($comment->author), img(array('src' => IMAGES . 'avatars/' . $comment->avatar, 'title' => $comment->author, 'alt' => $comment->author, 'width' => '57', 'height' => '57'))); ?>
		<?php else: ?>
			<?php echo anchor('account/profile/' . $this->users->user_slug($comment->author), img(array('src' => ADMINCP_URL . 'images/avatar_none.png', 'title' => $comment->author, 'alt' => $comment->author, 'width' => '57', 'height' => '57'))); ?>
		<?php endif; ?>
		</div>
		<p class="comment"><?php echo $comment->comment_title; ?></p>
		<div class="clear"></div>
		<?php echo br(); ?>
			
			<?php endforeach; ?>
			<?php else: ?>
				There are currently on comments for this match.
			<?php endif; ?>
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
<?php if($comments): ?>
	<div class="box">
		<div class="pages">
		<ul>
			<?php if($pages): ?>
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'matches/edit/' . $match->match_id . '/page/' . $pages->current_page, 'Page ' . $pages->current_page . ' of ' . $pages->total_pages); ?></span><span class="right"></span></li>
					<?php if($pages->first): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'matches/edit/' . $match->match_id . '/page/1', '<<'); ?></span><span class="right"></span></li><?php endif; ?>
					<?php if($pages->previous): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'matches/edit/' . $match->match_id . '/page/' . ($pages->current_page - 1), '<'); ?></span><span class="right"></span></li><?php endif; ?>
				
				<?php if($pages->before): ?>
					<?php foreach($pages->before as $before): ?>
						<li <?php if($pages->current_page == $before): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'matches/edit/' . $match->match_id . '/page/' . $before, $before); ?></span><span class="right"></span></li>
					<?php endforeach; ?>
				<?php endif; ?>
				
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'matches/edit/' . $match->match_id . '/page/' . $pages->current_page, $pages->current_page); ?></span><span class="right"></span></li>
				
				<?php if($pages->after): ?>
					<?php foreach($pages->after as $after): ?>
						<li <?php if($pages->current_page == $after): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'matches/edit/' . $match->match_id . '/page/' . $after, $after); ?></span><span class="right"></span></li>
					<?php endforeach; ?>
				<?php endif; ?>
				
					<?php if($pages->next): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'matches/edit/' . $match->match_id . '/page/' . ($pages->current_page + 1), '>'); ?></span><span class="right"></span></li><?php endif; ?>
					<?php if($pages->last): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'matches/edit/' . $match->match_id . '/page/' . $pages->total_pages, '>>'); ?></span><span class="right"></span></li><?php endif; ?>
			<?php endif; ?>
		</ul>
		</div>
	</div>
<?php endif; ?>
	
</div>
<?php echo form_close(); ?>

<?php $this->load->view(ADMINCP . 'footer'); ?>
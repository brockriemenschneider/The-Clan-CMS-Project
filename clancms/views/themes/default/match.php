<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<script type="text/javascript">
	function deleteConfirm()
	{
    	var answer = confirm("Are you sure you want to delete this comment? Once deleted, there will be no way to recover the comment!")
    	if (answer)
		{
        	document.messages.submit();
    	}
    
    	return false;  
	} 
</script> 

<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor('matches', 'Latest Matches'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor('matches/upcoming', 'Upcoming Matches'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('matches/view/' . $match->match_slug, $match->squad . ' vs ' . $match->match_opponent); ?></span><span class="right"></span></li>
		</ul>
		</div>
	
		<div class="header">
			<?php echo heading($match->squad . ' vs ' . $match->match_opponent, 4); ?>
		</div>
		<div class="content">
			<div class="inside">
			
				<div class="subheader">
					<?php echo heading('Match Details', 4); ?>
				</div>
				
				<div class="label">Squad:</div>
				<div class="details"><?php echo anchor('roster/squad/' . $match->squad_slug, $match->squad); ?></div>
				<div class="clear"></div>
				
				<div class="label">Opponent:</div>
				<div class="details"><?php if($match->match_opponent_link): echo anchor($match->match_opponent_link, $match->match_opponent); else: echo $match->match_opponent; endif; ?></div>
				<div class="clear"></div>
				
				<div class="label">Date &amp; Time:</div>
				<div class="details"><?php echo mdate("%M %d, %Y at %h:%i %A", $match->date); ?></div>
				<div class="clear"></div>
				
				<div class="label">Type:</div>
				<div class="details"><?php if($match->match_type): echo $match->match_type; else: echo '-'; endif; ?></div>
				<div class="clear"></div>
				
				<div class="label">Players:</div>
				<div class="details"><?php if($match->match_players): echo $match->match_players . ' v ' . $match->match_players; else: echo '-'; endif; ?></div>
				<div class="clear"></div>
				
				<div class="label">Result:</div>
				<div class="details <?php if($match->match_score > $match->match_opponent_score): echo 'green"'; elseif($match->match_score < $match->match_opponent_score): echo 'red"'; else: echo 'yellow"'; endif;?>><?php if($match->match_score > $match->match_opponent_score): echo 'Win'; elseif($match->match_score < $match->match_opponent_score): echo 'Loss'; else: echo 'Tie'; endif;?></div>
				<div class="clear"></div>
				
				<div class="label">Score:</div>
				<div class="details <?php if($match->match_score > $match->match_opponent_score): echo 'green"'; elseif($match->match_score < $match->match_opponent_score): echo 'red"'; else: echo 'yellow"'; endif;?>><?php echo $match->match_score . ' - ' . $match->match_opponent_score; ?></div>
				<div class="clear"></div>
				
				<div class="label">Report:</div>
				<div class="details"><?php if($match->match_report): echo $match->match_report; else: echo '-'; endif; ?></div>
				<div class="clear"></div>
				
			</div>
		</div>
		<div class="footer"></div>
	</div>
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
							<th width="10%"></th>
							<th width="30%">Player Name</th>
							<th width="15%">Kills</th>
							<th width="15%">Deaths</th>
							<th width="20%">K/D Ratio</th>
							<th width="10%">Stats</th>
						</tr>
					</thead>
			
					<tbody>
					<?php if($players): ?>
						<?php foreach($players as $player): ?>
						<tr>
							<td><?php if($player->online): echo anchor('account/profile/' . $this->users->user_slug($player->user_name), img(array('src' => THEME_URL . 'images/online.png', 'alt' => $player->user_name . ' is online')), array('title' => $player->user_name . ' is online')); else: echo anchor('account/profile/' . $player->user_name, img(array('src' => THEME_URL . 'images/offline.png', 'alt' => $player->user_name . ' is offline')), array('title' => $player->user_name . ' is offline')); endif; ?></td>
							<td><?php if($player->member_title): echo anchor('account/profile/' . $this->users->user_slug($player->user_name), $player->member_title); else: echo anchor('account/profile/' . $this->users->user_slug($player->user_name), $player->user_name); endif; ?></td>
							<td><?php echo $player->kills; ?></td>
							<td><?php echo $player->deaths; ?></td>
							<td><?php echo $player->kd; ?></td>
							<td><?php echo anchor('account/profile/' . $this->users->user_slug($player->user_name), img(array('src' => THEME_URL . 'images/stats.png', 'alt' => $player->user_name . "'s stats")), array('title' => $player->user_name . "'s stats")); ?></td>
						</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="6">No member's from this squad played in this match.</td>
						</tr>
					<?php endif; ?>
					</tbody>
				</table>
		
			</div>
		</div>
		<div class="footer"></div>
	</div>
	<div class="space"></div>
	
	<?php if($this->user->logged_in() && (bool) $match->match_comments): ?>
	<div class="box">
		<div class="header">
			<?php echo heading('Post A Comment', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
			
			<?php if(validation_errors()): ?>
				<div class="alert">
					<?php echo validation_errors(); ?>
				</div>
				<?php echo br(); ?>
			<?php endif; ?>
				
			<?php if($this->session->flashdata('message')): ?>
				<div class="alert">
					<?php echo $this->session->flashdata('message'); ?>
				</div>
				<?php echo br(); ?>
			<?php endif; ?>
			
			<?php echo form_open('matches/view/' . $match->match_slug); ?>
			<?php
				$data = array(
					'name'		=> 'comment',
					'rows'		=> '10',
					'cols'		=> '85'
				);
			
			echo form_textarea($data); ?>
			<?php 
					$data = array(
						'name'		=> 'add_comment',
						'class'		=> 'submit',
						'value'		=> 'Comment'
					);
				
				echo form_submit($data); ?>
				<div class="clear"></div>
			<?php echo form_close(); ?>
			</div>
		</div>
		<div class="footer"></div>
	</div>
	<div class="space"></div>
	<?php endif; ?>
	
	<div id="comments" class="box">
		
		<div class="header">
			<?php echo heading('Comments', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
			
			<?php if($comments): ?>
			<?php foreach($comments as $comment): ?>
				<div class="subheader">
				<?php if($this->user->is_administrator() OR $this->session->userdata('user_id') == $comment->user_id): ?>
					<?php $actions = anchor('matches/delete_comment/' . $comment->comment_id, img(array('src' => THEME_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?>
				<?php else: ?>
					<?php $actions = ""; ?>
				<?php endif; ?>
					<?php echo heading(anchor('account/profile/' . $comment->author, $comment->author) . ' Posted ' . mdate("%M %d, %Y at %h:%i %a", $comment->date) . $actions, 4); ?>
				</div>
			<?php echo $comment->comment_title; ?><br /><br />
			
			<?php endforeach; ?>
			<?php else: ?>
				<?php if((bool) $match->match_comments): ?>
					No one has yet commented on this match. <?php if(!$this->user->logged_in()): echo 'Please ' . anchor('account/login', 'login') . ' to post comments.'; endif; ?>
				<?php else: ?>
					Comments are not allowed on this match.
				<?php endif; ?>
			<?php endif; ?>
			</div>
		</div>
		<div class="footer"></div>
	</div>
	<div class="space"></div>
	
	<?php if($comments): ?>
	<div class="box">
		<div class="pages">
			<?php echo heading($pages, 4); ?>
		</div>
	</div>
	<?php endif; ?>

</div>

<?php $this->load->view(THEME . 'footer'); ?>
<div class="widget">

	<div class="header"></div>
		
	<div class="content">
		<div class="inside">
				
			<div class="subheader">
				<?php echo heading('Poll', 4); ?>
			</div>
			
			<?php if($poll): ?>
				<?php echo form_open('polls'); ?>
					<?php echo $poll->poll_title; ?>
					<?php echo br(2); ?>
					<?php if($poll->options && !$poll->voted): ?>
						<?php foreach($poll->options as $option): ?>
							<?php $data = array(
									'name'        => 'option',
									'value'       => $option->option_id,
									);

								echo form_radio($data); ?>
							<?php echo $option->option_title . br(); ?>
						<?php endforeach; ?>
					<?php else: ?>
						<?php if($poll->options): ?>
							<?php foreach($poll->options as $option): ?>
								<div class="poll" style="width:<?php echo $option->percent; ?>%"><div class="percent"><?php echo $option->percent; ?>%</div></div> <?php echo $option->option_title; ?> (<?php echo $option->total_votes; ?> Votes)
								<?php echo br(); ?>
							<?php endforeach; ?>
						<?php endif; ?>
					<?php endif; ?>
		
					<?php if($this->user->logged_in() && !$poll->voted && $poll->options): ?>
						<?php 
							$data = array(
								'name'		=> 'add_vote',
								'class'		=> 'submit',
								'value'		=> 'Vote'
							);
				
						echo form_submit($data); ?>
						<div class="clear"></div>
					<?php elseif(!$poll->voted): ?>
						<?php echo br() . 'Please ' . anchor('account/login', 'login') . ' to vote.'; ?>
					<?php endif; ?>
				<?php echo form_close(); ?>
			<?php else: ?>
				<?php echo CLAN_NAME; ?> currently has no active poll.
			<?php endif; ?>
				
		</div>
	</div>
		
	<div class="footer"></div>
		
	<div class="tabs">
	<ul>
		<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('polls', 'POLL'); ?></span><span class="right"></span></li>
		<li><span class="left"></span><span class="middle"><?php echo anchor('polls', 'OTHER POLLS'); ?></span><span class="right"></span></li>
	</ul>
	</div>
</div>
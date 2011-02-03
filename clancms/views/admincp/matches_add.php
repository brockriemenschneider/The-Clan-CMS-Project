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
});
	
	function integer(evt) {
		var charCode = ( evt.which ) ? evt.which : event.keyCode;
		return ( charCode >= 48 && charCode <= 57 );
	}
</script> 

<?php echo form_open(ADMINCP . 'matches/add'); ?>
<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'matches', 'Matches'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'matches/add', 'Add Match'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Add Match', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
				<?php if(validation_errors()): ?>
				<div class="alert">
					<?php echo validation_errors(); ?>
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
					
				echo form_dropdown('opponent_id', $options, set_value('opponent_id'), 'class="input select"'); ?>
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
				<?php
					
					$options = array('' => '',);
					if($squads):
						foreach($squads as $squad):
							$options = $options + array($squad->squad_id	=>	$squad->squad_title);
						endforeach;
					endif;
					
				echo form_dropdown('squad', $options, set_value('squad'), 'class="input select"'); ?>
				<?php echo br(); ?>
				<div class="description">What squad played this match?</div>
				
				<div class="label">Type</div>
				
				<?php 
				$data = array(
					'name'		=> 'type',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('type')); ?>
				<?php echo br(); ?>
				<div class="description">The type of match played</div>
				
				<div class="label">Players</div>
				
				<?php 
				$data = array(
					'name'		=> 'players',
					'size'		=> '1',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('players'), 'onkeypress="return integer(event)"'); ?> v <span id="players"></span>
				<div class="description">The number of players on each team</div>
				
				<div class="label">Score</div>
				
				<?php 
				$data = array(
					'name'		=> 'score',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('score')); ?>
				<?php echo br(); ?>
				<div class="description">Your squad's score</div>
				
				<div class="label">Opponent's Score</div>
				
				<?php 
				$data = array(
					'name'		=> 'opponent_score',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('opponent_score')); ?>
				<?php echo br(); ?>
				<div class="description">Your opponent's score</div>
				
				<div class="label">Maps</div>
				
				<?php 
				$data = array(
					'name'		=> 'maps',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('maps')); ?>
				<?php echo br(); ?>
				<div class="description">The maps that were played</div>
				
				<div class="label required">Date</div>
				
				<?php 
				$data = array(
					'name'		=> 'date',
					'size'		=> '28',
					'class'		=> 'input datepicker'
				);

				echo form_input($data, set_value('date')); ?>
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
					
				echo form_dropdown('hour', $options, set_value('hour'), 'class="input"'); ?>
				:
				<?php
					
					$options = array(
						'00' => '00',
						'15' => '15',
						'30' => '30',
						'45' => '45'
					);
					
				echo form_dropdown('minutes', $options, set_value('minutes'), 'class="input"'); ?>
				
				<?php
					
					$options = array(
						'AM' => 'AM',
						'PM' => 'PM'
					);
					
				echo form_dropdown('ampm', $options, set_value('ampm'), 'class="input"'); ?>
				<?php echo br(); ?>
				<div class="description">The time the match was played</div>
				
				<?php
				$data = array(
					'name'		=> 'report',
					'id'		=> 'wysiwyg',
					'rows'		=> '10',
					'cols'		=> '50'
				);
			
				echo form_textarea($data, set_value('report')); ?>
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
				
				echo form_radio($data, '1', set_radio('comments', '1', TRUE)); ?> Allow
				
				<?php 
					$data = array(
						'name'		=> 'comments',
						'class'		=> 'input',
						);
				
				echo form_radio($data, '0', set_radio('comments', '0', FALSE)); ?> Disallow
				<?php echo br(); ?>
				
				<?php 
					$data = array(
						'name'		=> 'add_match',
						'class'		=> 'submit',
						'value'		=> 'Add Match'
					);
				
				echo form_submit($data); ?>
				<div class="clear"></div>
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
</div>
<?php echo form_close(); ?>

<?php $this->load->view(ADMINCP . 'footer'); ?>
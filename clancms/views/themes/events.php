<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">
	<div class="box">
		<div class="header"><?php echo heading('Events for ' . date('F \'y', $time), 4); ?></div>
		<div class="content">
			<div class="inside">
			
			<?php if(validation_errors()): ?>
				<div class="alert">
					<?php echo validation_errors(); ?>
				</div>
				<?php echo br(); ?>
			<?php endif; ?>
				
			<?php if($this->session->flashdata('events')): ?>
				<div class="alert">
					<?php echo $this->session->flashdata('events'); ?>
				</div>
				<?php echo br(); ?>
			<?php endif; ?>
			
			
			<?php echo $calendar; ?>
			
			<div id="events">
				<div class="subheader center"><?php echo heading('All events for ' . date('F', $time), 4); ?></div>
				<?php if($events): foreach($events as $event): 
					echo $event->event_title . ' : ' . $event->event_summary . br();
				endforeach; endif; ?>
			</div>
			<div class="clear"></div>
			
			<?php if($this->user->is_administrator()): ?>
			<div class="add">
				<div class="subheader center"><?php echo heading('Add events for ' . date('F', $time), 4); ?></div>
				
				<?php echo form_open('events/add'); ?>
				
				<?php echo form_label('Date', 'date'); ?>
				<?php 
						$data = array(
							'name'	=>	'date',
							'class'	=>	'input',
							'id'		=>	'datepicker',
							'size'		=>	10
							);
							
						echo form_input($data); ?>
				
				<?php echo form_label('Time', 'time'); ?>
				<?php 
						$options = array();
						$r = range(0, 23);
						
						foreach($r as $hour=>$key):
							$options = $options + array($key => ($hour > 11 ? $hour = ($hour > 12 ? $hour = ($hour - 12) : $hour) . ' pm' : ($hour == 0 ? $hour = '12' : $hour)  . ' am'));
						endforeach;
						
						echo form_dropdown('hour', $options, set_value('hour'), 'class="input"');
						
						 ?>
				<?php 
						$options = array();
						$minutes = array(0, 15, 30, 45);
						
						foreach($minutes as $mins=>$key):
							$options = $options + array($key => ($mins == 0 ? $mins = ':00' : ':' . $key));
						endforeach;
						
						echo form_dropdown('mins', $options, set_value('mins'), 'class="input"');
						
						 ?>
				
				<?php echo form_label('Event Title', 'title'); ?>
				<?php 
						$data = array(
							'name'	=>	'title',
							'class'	=>	'input',
							'size'		=>	20
							);
							
						echo form_input($data); ?>
				
				<?php echo form_label('Summary', 'summary'); ?>
				<?php 
						$data = array(
							'name'	=>	'summary',
							'class'	=>	'input',
							'rows'	=>	3,
							'cols'		=>	15,
							);
							
						echo form_textarea($data); ?>
				
				<?php echo form_label('Enable Signups', 'signups'); ?>
				<?php 
						$data = array(
							'name'	=>	'signups',
							'class'	=>	'input',
							'value'	=>	1
							);
							
						echo form_checkbox($data, set_value('year', FALSE)); ?>
						
				<?php 
						$data = array(
							'name'	=>	'add_event',
							'class'	=>	'submit',
							'value'	=>	'Add Event'
							);
						
						echo form_submit($data); ?>
						
				<?php echo form_close(); ?>
			</div>
			<?php endif; ?>
			
			<div class="current_events">
				<div class="subheader center"><?php echo heading('Todays events', 4); ?></div>
				<?php if($current_events): foreach($current_events as $event): 
					echo $event->event_title . ' : ' . $event->event_summary . br();
				endforeach; endif; ?>
			</div>
			
			<div class="upcoming_events">
				<div class="subheader center"><?php echo heading('Upcoming events for ' . date('F', $time), 4); ?></div>
				<?php if($past_events): foreach($past_events as $event): 
					echo $event->event_title . ' : ' . $event->event_summary . br();
				endforeach; endif; ?>
			</div>

			<div class="past_events">
				<div class="subheader center"><?php echo heading('Past events for ' . date('F', $time), 4); ?></div>
				<?php if($future_events): foreach($future_events as $event): 
					echo $event->event_title . ' : ' . $event->event_summary . br();
				endforeach; endif; ?>
			</div>

			</div>
		</div>
		<div class="footer"></div>
	</div>
	<div class="space"></div>
</div>
<script>
	$(function() {
		$( "#datepicker" ).datepicker({
			showOn: "button",
			buttonImage: "http://clancms.codezyne.me/clancms/views/images/24/icon_calendar.gif",
			buttonImageOnly: true,
			buttonText: 'Calendar',
			gotoCurrent: true,
		});
	});
	</script>
<?php $this->load->view(THEME . 'footer'); ?>
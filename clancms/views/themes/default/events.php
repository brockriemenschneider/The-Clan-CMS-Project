<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">
	<div class="box">
		<div class="header"><?php echo heading('Events for ' . $this_month, 4); ?></div>
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
				<?php if($events): ?>
					<?php echo heading($this_month . '\'s Events and Matches', 4); ?>
					<ul class="heading">
						<li>Event</li>
						<li>Summary</li>
					</ul>
					<?php 
						foreach($events as $event):
						echo 	'<ul>
								<li style="color: red;">' . $event->event_title . '</li>
								<li>' . $event->event_summary . '</li>
								</ul>';
						endforeach; 
						
						foreach($matches as $match):
						echo 	'<ul>
								<li style="color: green;">' . $match->event_title . '</li>
								<li>' . $match->event_summary . '</li>
								</ul>';
						endforeach; 
					?> 
				<?php else: ?>
					<?php echo 'No events this month'; ?> 
				<?php endif; ?> 
				</div>
				
				<div class="clear"></div>
				
				<?php if($this_month == date('F', $time)): ?>
				<div class="current_events">
				<?php if($current_events): ?>
					<table>
						<caption><?php echo heading('Todays events', 4); ?></caption>
						<thead>
							<tr>
								<td>Date</td>
								<td>Time</td>
								<td>Event</td>
								<td>Summary</td>
							</tr>
						</thead>
						<tbody>
							<?php foreach($current_events as $current):
								echo 	'<tr>
										<td>' . $current->event_day . '</td>
										<td>' . $current->event_time . '</td>
										<td>' . $current->event_title . '</td>
										<td>' . $current->event_summary . '</td>
										</tr>';
							endforeach; ?>
							
						</tbody>
					</table>
				<?php else: ?>
					<?php echo 'No events today'; ?>
				<?php endif; ?>
				</div>

				
				<div class="past_events">
				<?php if($past_events): ?>
					<table>
						<caption><?php echo heading('Past events', 4); ?></caption>
						<thead>
							<tr>
								<td>Date</td>
								<td>Time</td>
								<td>Event</td>
								<td>Summary</td>
							</tr>
						</thead>
						<tbody>
							<?php foreach($past_events as $past):
								echo 	'<tr>
										<td>' . $past->event_day . '</td>
										<td>' . $past->event_time . '</td>
										<td>' . $past->event_title . '</td>
										<td>' . $past->event_summary . '</td>
										</tr>';
							endforeach; ?>
							
						</tbody>
					</table>

				<?php endif; ?>
				</div>
				
				
				<div class="upcoming_events"> 
				<?php if($future_events): ?>
					<table>
						<caption><?php echo heading('Upcoming events', 4); ?></caption>
						<thead>
							<tr>
								<td>Date</td>
								<td>Time</td>
								<td>Event</td>
								<td>Summary</td>
							</tr>
						</thead>
						<tbody>
							<?php foreach($future_events as $future):
								echo 	'<tr>
										<td>' . $future->event_day . '</td>
										<td>' . $future->event_time . '</td>
										<td>' . $future->event_title . '</td>
										<td>' . $future->event_summary . '</td>
										</tr>';
							endforeach;  ?>
						</tbody>
					</table>
				<?php else: ?>
					<?php echo 'No more events this month'; ?> 
				<?php endif; ?>
				</div>
				<?php endif; ?>
				
	
				
				<?php if($this->user->is_administrator()): ?>
				<div class="add">
					<div class="subheader center" id="add_event" style="cursor:pointer"><?php echo heading('Add events for ' . $this_month, 4); ?></div>
						<div class="add_form">
							<?php echo form_open('events/add'); ?>
							
							<?php echo form_label('Date', 'date'); ?>
							<?php 
									$data = array(
										'name'	=>	'date',
										'class'	=>	'input',
										'id'		=>	'datepicker',
										'size'		=>	10,
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
				</div>
				<?php endif; ?>
				

				
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
	$("#add_event").click(function () {
	  $("div.add_form").toggle();
	});
	</script>
<?php $this->load->view(THEME . 'footer'); ?>
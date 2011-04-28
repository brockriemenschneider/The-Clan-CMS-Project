<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

<script type="text/javascript">
	function updateConfirm()
	{
    	var answer = confirm("Are you sure you want to update? Any modifications you have done to Clan CMS core files will be replaced with the updated ones. We recommend you create a backup before continuing!")
    	if (answer)
		{
        	document.messages.submit();
    	}
    
    	return false;  
	} 
</script> 

<div id="main">

	<div class="box">
		<div class="header">
			<?php echo heading('Administrator Alerts', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
			
			<?php if($alerts): ?>
				<?php foreach($alerts as $alert): ?>
				<div class="alert">
					<?php echo $alert->alert_title; ?> - <?php if($alert->alert_slug == "version"): echo anchor($alert->alert_link, 'Resolve Now', array('title' => 'Resolve Now', 'onclick' => "return updateConfirm();")); else: echo anchor($alert->alert_link, 'Resolve Now', array('title' => 'Resolve Now')); endif; ?>
				</div>
				<?php echo br(); ?>
				<?php endforeach; ?>
			<?php else: ?>
				There are currently no alerts.
			<?php endif; ?>
			
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
	<div class="space"></div>
	
	<?php echo form_open(ADMINCP); ?>
	<div class="box">
		<div class="header">
			<?php echo heading('Administrator Notepad', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
			
			<?php if($this->session->flashdata('message')): ?>
				<div class="alert">
					<?php echo $this->session->flashdata('message'); ?>
				</div>
				<?php echo br(); ?>
			<?php endif; ?>
			
			<?php
				$data = array(
					'name'		=> 'notepad',
					'value'		=>	$user->user_notes,
					'rows'		=> '10',
					'cols'		=> '85'
				);
			
			echo form_textarea($data); ?>
			<?php 
					$data = array(
						'name'		=> 'update_notepad',
						'class'		=> 'submit',
						'value'		=> 'Update Notepad'
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
			<?php echo heading('Clan CMS Credits', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
		<table>
			<thead>
				<tr class="top">
					<th width="30%">Development Team</th>
					<th width="70%">Contributors</th>
				</tr>
			</thead>
			
			<tbody>
				<tr class="row">
					<td>Software Developed By</td>
					<td><?php echo anchor('http://www.xcelgaming.com', 'Xcel Gaming'); ?></td>
				</tr>
				
				<tr class="row">
					<td>Business Development</td>
					<td><?php echo anchor('http://www.xcelgaming.com/forums/member.php?u=1', 'Brock Riemenschneider'); ?></td>
				</tr>
			
				<tr class="row">
					<td>Software Development</td>
					<td><?php echo anchor('http://www.xcelgaming.com/forums/member.php?u=1', 'Brock Riemenschneider'); ?>, <?php echo anchor('http://www.xcelgaming.com/forums/member.php?u=12', 'Jon Schuster'); ?></td>
				</tr>
				
				<tr class="row">
					<td>Graphics Development</td>
					<td><?php echo anchor('http://www.xcelgaming.com/forums/member.php?u=3', 'Zach Flynn'); ?>, <?php echo anchor('http://www.xcelgaming.com/forums/member.php?u=12', 'Jon Schuster'); ?></td>
				</tr>
				
				<tr class="row">
					<td>Support Staff</td>
					<td><?php echo anchor('http://www.xcelgaming.com/forums/member.php?u=5', 'Austin Marks'); ?>, <?php echo anchor('http://www.xcelgaming.com/forums/member.php?u=68', 'Rich Giles'); ?></td>
				</tr>
			</tbody>
		</table>
		
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
</div>

<?php $this->load->view(ADMINCP . 'footer'); ?>
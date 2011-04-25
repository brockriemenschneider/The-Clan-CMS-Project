<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

 <script type="text/javascript">
	$(function() {
		$("#options tbody").sortable({stop:function(i) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?><?php echo ADMINCP; ?>polls/order_options",
				data: $("#options tbody").sortable("serialize")
			});
			$("#move").html('<div class="alert">The option was successfully moved!</div><br />');
		}});

		$("#options tbody").disableSelection();

	});		
	
	function deleteConfirm()
	{
    	var answer = confirm("Are you sure you want to delete this option? Once deleted, there will be no way to recover the option and it's votes!")
    	if (answer)
		{
        	document.messages.submit();
    	}
    
    	return false;  
	} 
	
	function emptyConfirm()
	{
    	var answer = confirm("Are you sure you want to delete all the votes for this option? Once deleted, there will be no way to recover the votes!")
    	if (answer)
		{
        	document.messages.submit();
    	}
    
    	return false;  
	} 
</script> 

<?php echo form_open(ADMINCP . 'polls/edit/' . $poll->poll_id); ?>
<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'polls', 'Polls'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'polls/add', 'Add Poll'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'polls/edit/' . $poll->poll_id, 'Edit Poll: ' . $poll->poll_title); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Edit Poll: ' . $poll->poll_title, 4); ?>
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
					<?php echo heading('Poll Information', 4); ?>
				</div>
		
				<div class="label required">Title</div>
				<?php 
				$data = array(
					'name'		=> 'title',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('title', $poll->poll_title)); ?>
				<?php echo br(); ?>
				<div class="description">The title of the poll</div>
				
				<div class="label required">Active</div>
				
				<input type="radio" name="active" value="1" <?php if($poll->poll_active): if((bool) $poll->poll_active): echo 'checked="checked"'; endif; else: echo set_radio('active', '1', (bool) $poll->poll_active); endif; ?> class="input" />
				Yes
				<input type="radio" name="active" value="0" <?php if($poll->poll_active): if((bool) !$poll->poll_active): echo 'checked="checked"'; endif; else: echo set_radio('active', '1', (bool) !$poll->poll_active); endif; ?> class="input" />
				No
				<?php echo br(); ?>
				<div class="description">Is this the active poll?</div>

			</div>
		</div>
		<div class="footer"></div>
	</div>
	
	<div class="space"></div>
	
	<div class="box">
		
		<div class="header">
			<?php echo heading('Poll Options', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
			<div id="move"></div>
			
			<table id="options">
				<thead>
					<tr>
						<th width="70%">Option</th>
						<th width="20%">Votes</th>
						<th width="10%">Actions</th>
					</tr>
				</thead>
			
				<tbody>
					<?php if($options): ?>
						<?php foreach($options as $option): ?>
						<tr id="option_<?php echo $option->option_id; ?>" class="move">
							<td><?php
									$data = array(
										'name'		=> 'titles[' . $option->option_id . ']',
										'size'		=> '60',
									);

									echo form_input($data, set_value('titles[' . $option->option_id . ']', $option->option_title)); ?></td>
							<td><?php echo br() . $option->total_votes . br(2); ?></td>
							<td><?php echo anchor(ADMINCP . 'polls/delete_votes/' . $option->option_id, img(array('src' => ADMINCP_URL . 'images/empty.png', 'alt' => 'Empty Votes')), array('title' => 'Empty Votes', 'onclick' => "return emptyConfirm();")); ?> <?php echo anchor(ADMINCP . 'polls/delete_option/' . $option->option_id, img(array('src' => ADMINCP_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?></td>
						</tr>
						<?php endforeach; ?>
					<?php else: ?>
					<tr>
						<td colspan="3">There are options for this poll.</td>
					</tr>
					<?php endif; ?>
				</tbody>
			</table>
				<?php 
					$data = array(
						'name'		=> 'update_poll',
						'class'		=> 'submit',
						'value'		=> 'Update Poll'
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
			<?php echo heading('Add Poll Option', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
			<table>
				<thead>
					<tr>
						<th width="90%">Option</th>
						<th width="10%">Actions</th>
					</tr>
				</thead>
			
				<tbody>
					<?php echo form_open(ADMINCP . 'polls/add_option'); ?>
						<?php echo form_hidden('poll_id', $poll->poll_id); ?>
						<tr>
							<td><?php echo br(); ?><?php
									$data = array(
										'name'		=> 'option',
										'size'		=> '60',
									);

									echo form_input($data, set_value('option', '')); ?><?php echo br(2); ?></td>
							<td><input type="image" name="add_option" src="<?php echo ADMINCP_URL . 'images/add.png'; ?>" title="Add" alt="Add" /></td>
						</tr>
					<?php echo form_close(); ?>
				</tbody>
			</table>
			
				<div class="clear"></div>
		
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
</div>

<?php $this->load->view(ADMINCP . 'footer'); ?>
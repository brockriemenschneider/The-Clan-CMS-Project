<?php $this->load->view('install/header'); ?>

<?php echo form_open('install/step2'); ?>
<div id="main">
	
	<div class="box">
		
		<div class="header">
			<?php echo heading('Step 2: Database Connection', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
				<?php if(validation_errors()): ?>
				<div class="alert">
					<?php echo validation_errors(); ?>
				</div>
				<?php endif; ?>
				
				<?php if($this->session->userdata('message')): ?>
				<div class="alert">
					<?php echo $this->session->userdata('message'); ?>
				</div>
				<?php endif; ?>
				
				<div class="required-field required">Required Field</div>
				<?php echo br(); ?>
				<div class="subheader">
						<?php echo heading('Database Information', 4); ?>
				</div>
				
				<div class="label">Database Prefix:</div>
				<?php 
				$data = array(
					'name'		=> 'db_prefix',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('db_prefix', 'ClanCMS_')); ?>
				<?php echo br(); ?>
				<div class="description">This makes sure there are no conflicts with other database tables</div>
				
				<div class="label required">Database Host:</div>
				<?php 
				$data = array(
					'name'		=> 'db_hostname',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('db_hostname', 'localhost')); ?>
				<?php echo br(); ?>
				<div class="description">This is usually localhost</div>

				<div class="label required">Database Port:</div>
				<?php 
				$data = array(
					'name'		=> 'db_port',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('db_port', '3306')); ?>
				<?php echo br(); ?>
				<div class="description">This is usually 3306</div>
				
				<div class="label required">Database Name:</div>
				<?php 
				$data = array(
					'name'		=> 'db_name',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('db_name')); ?>
				<?php echo br(); ?>
				
				<div class="label">Create Database:</div>
				<div class="input"><input type="checkbox" name="create_database" value="1" <?php echo set_checkbox('create_database', '1'); ?> /> (You might need to do this yourself)</div>
				
				<div class="label required">Database Username:</div>
				<?php 
				$data = array(
					'name'		=> 'db_username',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('db_username')); ?>
				<?php echo br(); ?>
				
				<div class="label">Database Password:</div>
				<?php 
				$data = array(
					'name'		=> 'db_password',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_password($data, set_value('db_password')); ?>
				<?php echo br(); ?>
				
				<?php 
					$data = array(
						'name'		=> 'step3',
						'class'		=> 'submit',
						'value'		=> 'Step 3: Check Requirements'
					);
				
				echo form_submit($data); ?>
				
				<div class="clear"></div>
	
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
</div>
<?php echo form_close(); ?>

<?php $this->load->view('install/footer'); ?>
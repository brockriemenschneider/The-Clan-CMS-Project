<?php $this->load->view('install/header'); ?>

<?php echo form_open('install/step4'); ?>
<div id="main">
	
	<div class="box">
		
		<div class="header">
			<?php echo heading('Step 4: Site Information', 4); ?>
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
						<?php echo heading('Site Settings', 4); ?>
				</div>
				
				<div class="label required">Clan Name:</div>
				<?php 
				$data = array(
					'name'		=> 'clan_name',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('clan_name', '')); ?>
				<?php echo br(); ?>
				<div class="description">Put your clan name here.</div>

				<div class="label required">Site Email:</div>
				<?php 
				$data = array(
					'name'		=> 'site_email',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('site_email', '')); ?>
				<?php echo br(); ?>
				<div class="description">The main email used to contact users (noreply@xcelgaming.com)</div>

				<div class="label required">Default Timezone:</div>
				<?php echo timezone_menu(set_value('timezone', 'UM5'), 'select input', 'timezone'); ?>
				<?php echo br(); ?>
				<div class="description">Default is set to EST (UTC -5:00)</div>

				<div class="label required">Daylight Savings:</div>
				<?php 
				$options = array(
					'1'		=> 'Yes',
					'0'		=> 'No'
				);

				echo form_dropdown('daylight_savings', $options, set_value('daylight_savings'), 'class="select input"'); ?>
				<?php echo br(); ?>
			
				<?php 
					$data = array(
						'name'		=> 'step4',
						'class'		=> 'submit',
						'value'		=> 'Step 5: Account Registration'
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
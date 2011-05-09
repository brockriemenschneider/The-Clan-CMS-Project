<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

<?php echo form_open_multipart(ADMINCP . 'settings/backup'); ?>
<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'settings', 'Site Settings'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'settings/backup', 'Database Backup'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Database Backup', 4); ?>
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
					<?php echo heading('Database Tables', 4); ?>
				</div>
				
				<?php if($tables): ?>
					<?php foreach($tables as $table): ?>
					<div class="label required"><?php echo $table; ?></div>
				
					Yes
					<input type="radio" name="table[<?php echo $table; ?>]" value="1" <?php echo set_radio('table[' . $table . ']', '1', TRUE); ?> class="input" />
					No
					<input type="radio" name="table[<?php echo $table; ?>]" value="0" <?php echo set_radio('table[' . $table . ']', '0'); ?> class="input" />
				
					<?php echo br(); ?>
					<?php endforeach; ?>
					<div class="description">What database tables do you want to backup?</div>
				<?php endif; ?>
				
				<?php 
					$data = array(
						'name'		=> 'backup_database',
						'class'		=> 'submit',
						'value'		=> 'Backup Database'
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
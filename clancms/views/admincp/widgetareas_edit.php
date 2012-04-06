<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

<?php echo form_open(ADMINCP . 'widgets/editarea/' . $area->area_id); ?>
<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets', 'Widgets'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/areas', 'Widget Areas'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/addarea', 'Add Widget Area'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/browse', 'Browse Widgets'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/editarea/' . $area->area_id, 'Edit Widget Area: ' . $area->area_title); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Edit Widget Area: ' . $area->area_title, 4); ?>
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
					<?php echo heading('Widget Area Information', 4); ?>
				</div>
		
				<div class="label required">Title</div>
				<?php 
				$data = array(
					'name'		=> 'title',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('title', $area->area_title)); ?>
				<?php echo br(); ?>
				<div class="description">The title of the widget area</div>
				
				<div class="label required">Slug</div>
				<?php 
				$data = array(
					'name'		=> 'slug',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('slug', $area->area_slug)); ?>
				<?php echo br(); ?>
				<div class="description">The short name to load the widget area</div>
				
				<?php 
					$data = array(
						'name'		=> 'update_widgetarea',
						'class'		=> 'submit',
						'value'		=> 'Update Widget Area'
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
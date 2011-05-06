<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

<?php echo form_open(ADMINCP . 'widgets/edit/' . $widget->widget_id); ?>
<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets', 'Widgets'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/areas', 'Widget Areas'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/addarea', 'Add Widget Area'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/browse', 'Browse Widgets'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/edit/' . $widget->widget_id, 'Edit Widget: ' . $widget->widget_title); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Edit Widget: ' . $widget->widget_title, 4); ?>
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
					<?php echo heading('Widget Information', 4); ?>
				</div>
				
				<div class="label required">Type:</div>
				<div class="details"><?php echo $type->title; ?></div>
				<div class="clear"></div>
				
				<div class="label required">Widget Area</div>
				<?php
					
					$options = array();
					if($areas):
						foreach($areas as $area):
							$options = $options + array($area->area_id	=>	$area->area_title);
						endforeach;
					endif;
					
				echo form_dropdown('area', $options, set_value('area', $widget->area_id), 'class="input select"'); ?>
				<?php echo br(); ?>
				<div class="description">The widget area this widget is in</div>
				
				<div class="label required">Title</div>
				<?php 
				$data = array(
					'name'		=> 'title',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('title', $widget->widget_title)); ?>
				<?php echo br(); ?>
				<div class="description">The title of the widget</div>
				
				<div class="label required">Priority</div>
				
				<?php 
				$data = array(
					'name'		=> 'priority',
					'size'		=> '30',
					'class'		=> 'input'
				);

				echo form_input($data, set_value('priority', $widget->widget_priority)); ?>
				<?php echo br(); ?>
				<div class="description">The order in which this widget should appear</div>
				<?php echo br(); ?>
				
				<?php if($type->settings): ?>
				<div class="subheader">
					<?php echo heading('Widget Settings', 4); ?>
				</div>
				
					<?php foreach($type->settings as $setting): ?>
						<div class="label <?php if(strpos($setting['rules'],'required')): echo 'required'; endif; ?>"><?php echo $setting['title']; ?></div>
						
						<?php if($setting['type'] == "text"): ?>
							<?php 
							$data = array(
								'name'		=> 'setting[' . $setting['slug'] . ']',
								'size'		=> '30',
								'class'		=> 'input'
								);
								
							echo form_input($data, set_value('setting[' . $setting['slug'] . ']', $widget->settings[$setting['slug']])); ?>
					
						<?php elseif($setting['type'] == "timezone"): ?>
					
							<?php echo timezone_menu(set_value('setting[' . $setting['slug'] . ']', $widget->settings[$setting['slug']]), 'input select', 'setting[' . $setting['slug'] . ']'); ?>
					
					<?php elseif($setting['type'] == "select"): ?>
					
						<?php
						echo form_dropdown('setting[' . $setting['slug'] . ']', $setting['options'], set_value('setting[' . $setting['slug'] . ']', $widget->settings[$setting['slug']]), 'class="input select"'); ?>
					
					<?php elseif($setting['type'] == "textarea"): ?>
					
						<?php
						$data = array(
							'name'		=> 'setting[' . $setting['slug'] . ']',
							'rows'		=> '20',
							'cols'		=> '50'
						);
				
						echo form_textarea($data, set_value('setting[' . $setting['slug'] . ']', htmlspecialchars_decode($widget->settings[$setting['slug']]))); ?>
				
						<?php endif; ?>
						<div class="description"><?php echo $setting['description']; ?></div>
					<?php endforeach; ?>
				<?php endif; ?>
				
				<?php 
					$data = array(
						'name'		=> 'update_widget',
						'class'		=> 'submit',
						'value'		=> 'Update Widget'
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
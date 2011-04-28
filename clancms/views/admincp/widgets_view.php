<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

<script type="text/javascript">	
	function installConfirm()
	{
    	var answer = confirm("Are you sure you want to install this widget?")
    	if (answer)
		{
        	document.messages.submit();
    	}
    
    	return false;  
	} 
	
	function updateConfirm()
	{
    	var answer = confirm("Are you sure you want to update this widget?")
    	if (answer)
		{
        	document.messages.submit();
    	}
    
    	return false;  
	} 
	
	function uninstallConfirm()
	{
    	var answer = confirm("Are you sure you want to uninstall this widget? Once uninstalled, there will be no way to recover any instances created from this widget!")
    	if (answer)
		{
        	document.messages.submit();
    	}
    
    	return false;  
	} 
	
</script> 

<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets', 'Widgets'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/areas', 'Widget Areas'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/addarea', 'Add Widget Area'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/browse', 'Browse Widgets'); ?></span><span class="right"></span></li>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/view/' . $widget['widget_slug'], 'View Widget: ' . $widget['widget_title']); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('View Widget: ' . $widget['widget_title'], 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
				<?php if($update): ?>
				<div class="alert">
					There is an update available for this widget! <?php echo anchor(ADMINCP . 'widgets/update/' . $update['slug'], 'Update now', array('onclick' => "return updateConfirm();")); ?>
				</div>
				<br />
				<?php endif; ?>
				
				<?php if($this->session->flashdata('message')): ?>
				<div class="alert">
					<?php echo $this->session->flashdata('message'); ?>
				</div>
				<?php endif; ?>
				
				<div class="subheader">
					<?php echo heading('Widget Information', 4); ?>
				</div>
				
				<div class="label">Version:</div>
				<div class="details"><?php echo $widget['widget_version']; ?></div>
				<div class="clear"></div>
				
				<div class="label">Author:</div>
				<div class="details"><?php echo $widget['widget_author']; ?></div>
				<div class="clear"></div>
				
				<div class="label">Clan CMS Version Required:</div>
				<div class="details"><?php echo $widget['widget_requires']; ?></div>
				<div class="clear"></div>
				
				<div class="label">Compatible up to:</div>
				<div class="details"><?php echo $widget['widget_compatible']; ?></div>
				<div class="clear"></div>
				
				<div class="label">Downloaded:</div>
				<div class="details"><?php echo $widget['widget_count']; ?> times</div>
				<div class="clear"></div>
				
				<div class="label">Rating:</div>
				<div class="details">
					<div class="stars-wrapper">
						<?php
							$options = array(
								'1' => 'Very poor',
								'2' => 'Not that bad',
								'3' => 'Average',
								'4' => 'Good',
								'5' => 'Perfect'
							);
							
							echo form_dropdown('rating', $options, set_value('rating', $widget['widget_rating']), 'class="input" disabled="disabled"'); ?>
					</div>
				</div>
				<div class="clear"></div>
				
				<?php if(!$this->widgets->is_installed($widget['widget_slug'])): ?>
					<?php echo form_open(ADMINCP . 'widgets/install/' . $widget['widget_slug']); ?>
						<?php 
						$data = array(
							'name'		=> 'install_widget',
							'class'		=> 'submit',
							'value'		=> 'Install Widget',
							'onclick'	=> "return installConfirm();"
						);
					
						echo form_submit($data); ?>
						<div class="clear"></div>
					<?php echo form_close(); ?>
				<?php elseif($this->widgets->is_installed($widget['widget_slug'])): ?>
					<?php if($update): ?>
						<?php echo form_open(ADMINCP . 'widgets/update/' . $widget['widget_slug']); ?>
							<?php 
							$data = array(
								'name'		=> 'update_widget',
								'class'		=> 'submit',
								'value'		=> 'Update Widget',
								'onclick'	=> "return updateConfirm();"
							);
						
							echo form_submit($data); ?>
							<div class="clear"></div>
						<?php echo form_close(); ?>
					<?php endif; ?>
					<?php echo form_open(ADMINCP . 'widgets/uninstall/' . $widget['widget_slug']); ?>
						<?php 
						$data = array(
							'name'		=> 'uninstall_widget',
							'class'		=> 'submit',
							'value'		=> 'Uninstall Widget',
							'onclick'	=> "return uninstallConfirm();"
						);
					
						echo form_submit($data); ?>
						<div class="clear"></div>
					<?php echo form_close(); ?>
				<?php endif; ?>
				
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
	<div class="space"></div>
	
	<?php if($this->uri->segment(5, '') == 'reviews' && (bool) !$widget['review_written']): ?>
	<?php echo form_open(ADMINCP . 'widgets/view/' . $widget['widget_slug'] . '/reviews/page/' . $pages->current_page); ?>
	<div class="box">
		<div class="header">
			<?php echo heading('Write A Review', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
			
			<?php if(validation_errors()): ?>
				<div class="alert">
					<?php echo validation_errors(); ?>
				</div>
				<?php echo br(); ?>
			<?php endif; ?>
			
			<div class="required-field required">Required Field</div>
			<?php echo br(); ?>
			<div class="subheader">
					<?php echo heading('Review Information', 4); ?>
			</div>
				
			<div class="label required">Nickname:</div>
			<?php 
			$data = array(
				'name'		=> 'nickname',
				'size'		=> '30',
				'class'		=> 'input'
			);

			echo form_input($data, set_value('nickname')); ?>
			<?php echo br(); ?>
				
			<div class="label required">Rating:</div>
				<div class="input">
					<div class="stars-wrapper">
					<?php
					
					$options = array(
						'1' => 'Very poor',
						'2' => 'Not that bad',
						'3' => 'Average',
						'4' => 'Good',
						'5' => 'Perfect'
					);
					
					echo form_dropdown('review_rating', $options, set_value('review_rating', ''), 'class="input"'); ?>
					</div>
					<div class="stars-cap" style="float:left;margin-left:5px;"></div>
				</div>
				<?php echo br(); ?>
			
			<?php
				$data = array(
					'name'		=> 'review',
					'rows'		=> '10',
					'cols'		=> '85'
				);
			
			echo form_textarea($data); ?>
			<?php 
					$data = array(
						'name'		=> 'add_review',
						'class'		=> 'submit',
						'value'		=> 'Write Review'
					);
				
				echo form_submit($data); ?>
				<div class="clear"></div>
			<?php echo form_close(); ?>
			</div>
		</div>
		<div class="footer"></div>
	</div>
	<div class="space"></div>
	<?php endif; ?>
	
	<div class="box">
		<div class="tabs">
		<ul>
			<li <?php if($this->uri->segment(5, '') == ''): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/view/' . $widget['widget_slug'], 'Description'); ?></span><span class="right"></span></li>
			<li <?php if($this->uri->segment(5, '') == 'screenshots'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/view/' . $widget['widget_slug'] . '/screenshots', 'Screenshots'); ?></span><span class="right"></span></li>
			<li <?php if($this->uri->segment(5, '') == 'changelog'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/view/' . $widget['widget_slug'] .'/changelog', 'Changelog'); ?></span><span class="right"></span></li>
			<li <?php if($this->uri->segment(5, '') == 'faq'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/view/' . $widget['widget_slug'] .'/faq', 'FAQ'); ?></span><span class="right"></span></li>
			<li <?php if($this->uri->segment(5, '') == 'reviews'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/view/' . $widget['widget_slug'] .'/reviews', 'Reviews'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		<?php if($this->uri->segment(5, '') == ''): ?>
		<div class="header">
			<?php echo heading('Description', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
				<?php echo $widget['widget_description']; ?>
				
			</div>
		</div>
		<div class="footer"></div>
		<?php elseif($this->uri->segment(5, '') == 'screenshots'): ?>
		<div class="header">
			<?php echo heading('Screenshots', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
				<?php if($screenshots): ?>
					<?php foreach($screenshots as $screenshot): ?>
						<p>
							<?php echo $screenshot['screenshot_image']; ?>
						</p>
					<?php endforeach; ?>
				<?php else: ?>
				There are no screenshots for this widget.
				<?php endif; ?>
				
			</div>
		</div>
		<div class="footer"></div>
		<?php elseif($this->uri->segment(5, '') == 'changelog'): ?>
		<div class="header">
			<?php echo heading('Changelog', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
				<?php if($changelogs): ?>
					<?php foreach($changelogs as $changelog): ?>
						<div class="subheader">
							<?php echo heading($changelog['changelog_title'], 4); ?>
						</div>
						
						<ul>
							<li>Released: <?php echo $changelog['changelog_date']; ?></li>
							<?php $changes = explode("<br />", $changelog['changelog_description']); ?>
							<?php foreach($changes as $change): ?>
								<li><?php echo strip_tags($change); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endforeach; ?>
				<?php else: ?>
					There is not a changelog for this widget.
				<?php endif; ?>
				
			</div>
		</div>
		<div class="footer"></div>
		<?php elseif($this->uri->segment(5, '') == 'faq'): ?>
		<div class="header">
			<?php echo heading('FAQ', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
				
				<?php if($faqs): ?>
					<?php foreach($faqs as $faq): ?>
						<div class="subheader">
							<?php echo heading($faq['faq_title'], 4); ?>
						</div>
						
						<p>
							<?php echo $faq['faq_description']; ?>
						</p>
					<?php endforeach; ?>
				<?php else: ?>
					There is not a FAQ for this widget.
				<?php endif; ?>
				
			</div>
		</div>
		<div class="footer"></div>
		<?php elseif($this->uri->segment(5, '') == 'reviews'): ?>
		<div class="header">
			<?php echo heading('Reviews', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
					
			<?php if($reviews): ?>
			<?php foreach($reviews as $review): ?>
			<?php
					
				$options = array(
					'1' => 'Very poor',
					'2' => 'Not that bad',
					'3' => 'Average',
					'4' => 'Good',
					'5' => 'Perfect'
				);
					
				$rating = '<div class="stars-wrapper">' . form_dropdown('rating', $options, set_value('rating', $review['review_rating']), 'class="input" disabled="disabled"') . '</div>'; ?>
			
				<div class="subheader">
					<?php echo heading($review['review_author'] . ' Posted ' . $review['review_date'] . $rating, 4); ?>
				</div>

		<p class="comment"><?php echo $review['review_title']; ?></p>
		<div class="clear"></div>
		<?php echo br(); ?>
			
			<?php endforeach; ?>
			<?php else: ?>
				There are currently on reviews for this widget.
			<?php endif; ?>
				
				
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
	<div class="box">
		<div class="pages">
		<ul>
			<?php if($pages): ?>
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/view/' . $widget['widget_slug'] . '/reviews/page/' . $pages->current_page, 'Page ' . $pages->current_page . ' of ' . $pages->total_pages); ?></span><span class="right"></span></li>
					<?php if($pages->first): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/view/' . $widget['widget_slug'] . '/reviews/page/1', '<<'); ?></span><span class="right"></span></li><?php endif; ?>
					<?php if($pages->previous): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/view/' . $widget['widget_slug'] . '/reviews/page/' . ($pages->current_page - 1), '<'); ?></span><span class="right"></span></li><?php endif; ?>
				
				<?php if($pages->before): ?>
					<?php foreach($pages->before as $before): ?>
						<li <?php if($pages->current_page == $before): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/view/' . $widget['widget_slug'] . '/reviews/page/' . $before, $before); ?></span><span class="right"></span></li>
					<?php endforeach; ?>
				<?php endif; ?>
				
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/view/' . $widget['widget_slug'] . '/reviews/page/' . $pages->current_page, $pages->current_page); ?></span><span class="right"></span></li>
				
				<?php if($pages->after): ?>
					<?php foreach($pages->after as $after): ?>
						<li <?php if($pages->current_page == $after): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/view/' . $widget['widget_slug'] . '/reviews/page/' . $after, $after); ?></span><span class="right"></span></li>
					<?php endforeach; ?>
				<?php endif; ?>
				
					<?php if($pages->next): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/view/' . $widget['widget_slug'] . '/reviews/page/' . ($pages->current_page + 1), '>'); ?></span><span class="right"></span></li><?php endif; ?>
					<?php if($pages->last): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'widgets/view/' . $widget['widget_slug'] . '/reviews/page/' . $pages->total_pages, '>>'); ?></span><span class="right"></span></li><?php endif; ?>
			<?php endif; ?>
		</ul>
		</div>
	</div>
		<?php endif; ?>
	
</div>


<?php echo form_close(); ?>

<?php $this->load->view(ADMINCP . 'footer'); ?>
<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">
	<div class="box">
		<div class="space"></div>
		<div class="header"><?php echo heading('Shout History', 4); ?></div>
		<div class="content">
			<div class="inside">
			<!-- Form Validation -->
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
				<?php echo br(); ?>
			<!-- End Validation -->
			
			<?php if($shouts): ?>
				<ul id="shouts">
				<?php foreach($shouts as $shout): ?>
					<li class=<?php if($shout->rank == 'Administrators'): echo 'admin'; else: echo 'user'; endif; ?>>
						<?php if($this->user->is_administrator()): echo $actions = anchor('shouts/del_shout/' . $shout->id, img(array('src' => THEME_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?><?php endif; ?>
						<?php if($shout->avatar): echo img(array('src' => IMAGES . 'avatars/' . $shout->avatar, 'height' => 16, 'width' => 16)); else: echo img(array('src' => THEME_URL . 'images/avatar_none.png', 'height' => 16, 'width' => 16)); endif; ?>
						<?php echo anchor('account/profile/' . $shout->user_clean, $shout->user); ?>
						<?php echo $shout->shout; ?>
						<span class="right white"><?php echo $shout->when; ?></span><span class="right yellow time"><?php echo $shout->delay; ?>&nbsp;&bull;&nbsp;</span>
						<div class="clear"></div>
					<li>
				<?php endforeach; ?>
				</ul>
			<?php else: ?>
				<p>Shoutbox is empty</p>
			<?php endif; ?>
			</div>
		<div class="footer"></div>
		<script type="text/javascript">
			function deleteConfirm()
			{
		    	var answer = confirm("Are you sure you want to delete this shout? Once deleted, there will be no way to recover it!")
		    	if (answer)
				{
		        	document.messages.submit();
		    	}
		    
		    	return false;  
			} 
		</script>
		</div>
	</div>


<?php if($shouts): ?>
	<div class="box">
		<div class="pages">
		<ul>
			<?php if($pages): ?>
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('shouts/page/' . $pages->current_page, 'Page ' . $pages->current_page . ' of ' . $pages->total_pages); ?></span><span class="right"></span></li>
					<?php if($pages->first): ?><li><span class="left"></span><span class="middle"><?php echo anchor('shouts/page/1', '<<'); ?></span><span class="right"></span></li><?php endif; ?>
					<?php if($pages->previous): ?><li><span class="left"></span><span class="middle"><?php echo anchor('shouts/page/' . ($pages->current_page - 1), '<'); ?></span><span class="right"></span></li><?php endif; ?>
				
				<?php if($pages->before): ?>
					<?php foreach($pages->before as $before): ?>
						<li <?php if($pages->current_page == $before): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor('shouts/page/' . $before, $before); ?></span><span class="right"></span></li>
					<?php endforeach; ?>
				<?php endif; ?>
				
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('shouts/page/' . $pages->current_page, $pages->current_page); ?></span><span class="right"></span></li>
				
				<?php if($pages->after): ?>
					<?php foreach($pages->after as $after): ?>
						<li <?php if($pages->current_page == $after): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor('shouts/page/' . $after, $after); ?></span><span class="right"></span></li>
					<?php endforeach; ?>
				<?php endif; ?>
				
					<?php if($pages->next): ?><li><span class="left"></span><span class="middle"><?php echo anchor('shouts/page/' . ($pages->current_page + 1), '>'); ?></span><span class="right"></span></li><?php endif; ?>
					<?php if($pages->last): ?><li><span class="left"></span><span class="middle"><?php echo anchor('shouts/page/' . $pages->total_pages, '>>'); ?></span><span class="right"></span></li><?php endif; ?>
			<?php endif; ?>
		</ul>
		</div>
	</div>
<?php endif; ?>
</div>

<?php $this->load->view(THEME . 'footer'); ?>
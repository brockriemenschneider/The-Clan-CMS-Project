<div class="widget">

	<div class="header"></div>
		
	<div class="content">
		<div class="inside">
				
			<?php if($title): ?>
			<div class="subheader">
				<?php echo heading($title, 4); ?>
			</div>
			<?php endif; ?>
			
			<?php echo $content; ?>
		</div>
	</div>
		
	<div class="footer"></div>
		
	<?php if($tabs): ?>
	<div class="tabs">
	<ul>
		<?php foreach($tabs as $tab): ?>
		<li <?php if((bool) $tab['selected']): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor($tab['link'], $tab['title']); ?></span><span class="right"></span></li>
		<?php endforeach; ?>
	</ul>
	</div>
	<?php endif; ?>
	
</div>
<div class="space"></div>
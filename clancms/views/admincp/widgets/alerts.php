<?php if($alerts): ?>
<ul id="ticker">
	<?php foreach($alerts as $alert): ?>
		<li><?php echo $alert->alert_title; ?> - <?php echo anchor($alert->alert_link, 'Resolve Now', array('class' => 'yellow')); ?></li>
	<?php endforeach; ?>
</ul>
<?php else: ?>
	There are currently no alerts
<?php endif; ?>
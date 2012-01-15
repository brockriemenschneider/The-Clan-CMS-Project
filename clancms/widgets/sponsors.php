			<?php if($sponsors): ?>
				<?php foreach($sponsors as $sponsor): ?>
					<?php if($sponsor->sponsor_link): echo anchor($sponsor->sponsor_link, img(array('src' => IMAGES . 'sponsors/' . $sponsor->sponsor_image, 'alt' => $sponsor->sponsor_title, 'title' => $sponsor->sponsor_title))); else: echo img(array('src' => IMAGES . 'sponsors/' . $sponsor->sponsor_image, 'alt' => $sponsor->sponsor_title, 'title' => $sponsor->sponsor_title)); endif; ?>
				<?php endforeach; ?>
			<?php else: ?>
				<?php echo CLAN_NAME; ?> is currently not sponsored.
			<?php endif; ?>
<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">
	<div class="box">
	<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor('account/profile/' . $user->user_name, $user->user_name); ?></span><span class="right"></span></li>
			<?php if($user->user_id == $this->session->userdata('user_id')): ?>
				<li><span class="left"></span><span class="middle"><?php echo anchor('account', 'My Account'); ?></span><span class="right"></span></li>
				<li><span class="left"></span><span class="middle"><?php echo anchor('account/social', 'My Social'); ?></span><span class="right"></span></li>
<<<<<<< HEAD
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('gallery/user/' . $user->user_name, 'My Media'); ?></span><span class="right"></span></li>
			<?php else: ?>
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('gallery/user/' . $this->uri->segment(3), $this->uri->segment(3) . '\'s Media'); ?></span><span class="right"></span></li>
=======
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('gallery/user/' . $user->user_name, 'My Media'); ?></span><span class="right"></span></li>
				<li><span class="left"></span><span class="middle"><?php echo anchor('account/wall/' . $user->user_name, 'My Wall'); ?></span><span class="right"></span></li>
			<?php else: ?>
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('gallery/user/' . $this->uri->segment(3), $this->uri->segment(3) . '\'s Media'); ?></span><span class="right"></span></li>
				<li><span class="left"></span><span class="middle"><?php echo anchor('account/wall/' . $this->uri->segment(3), $this->uri->segment(3) . '\'s Wall'); ?></span><span class="right"></span></li>
>>>>>>> complete
			<?php endif; ?>
		</ul>
		</div>
		<div class="header">
			<?php if($user->user_id == $this->session->userdata('user_id')): ?>
				<?php echo heading('My Gallery', 4); ?>
			<?php else: ?>
				<?php echo heading($this->uri->segment(3) . '\'s Gallery', 4); ?>
			<?php endif; ?>
		</div>
		<div class="content">
			<div class="inside">
<<<<<<< HEAD
			
=======
>>>>>>> complete
				<?php if($stats): ?>
					<div class="stats">
						<div class="title">Gallery Stats</div>
						<ul class="labels">
							<li>[images]</li>
							<li>[videos]</li>
							<li>[disk used]</li>
							<li>[views]</li>
							<li>[favors]</li>
							<li>[comments]</li>
							<li>[downloads]</li>
						</ul>
						<ul class="info">
<<<<<<< HEAD
							<li><?php echo $stats->uploads; ?></li>
							<li>&nbsp;</li>
=======
							<li><?php echo $stats->images; ?></li>
							<li><?php echo $stats->videos; ?></li>
>>>>>>> complete
							<li><?php echo $stats->disk_use; ?></li>
							<li><?php echo $stats->views; ?></li>
							<li><?php echo $stats->favors; ?></li>
							<li><?php echo $stats->comments; ?></li>
							<li><?php echo $stats->downloads; ?></li>
						</ul>
					</div>
				<?php endif; ?>
				
<<<<<<< HEAD
				<div id="photos">
					<?php if($images): ?>
					 	<ul>
						 <?php foreach($images as $image): ?>
					 		<li>
					 			<div class="gallery_inset">
						 			<?php if($this->user->is_administrator() OR $this->session->userdata('username') == $image->uploader): ?>
										<?php echo $actions = anchor('gallery/del_image/' . $image->gallery_id, img(array('src' => THEME_URL . 'images/delete.png', 'alt' => 'Delete', 'class' => 'delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?>
									<?php else: ?>
										<?php echo $actions = ""; ?>
									<?php endif; ?>
						 			<?php if($image->width > 130): 
						 				echo anchor('gallery/image/' . $image->image_slug, img(array('src' => IMAGES . 'gallery/thumbs/' . $image->image, 'title' => $image->title, 'alt' => $image->title . ' by ' . $image->uploader, 'class' => 'resize_x'))); 
						 			else:  
						 				echo anchor('gallery/image/' . $image->image_slug, img(array('src' => IMAGES . 'gallery/thumbs/' . $image->image, 'title' => $image->title, 'alt' => $image->title . ' by ' . $image->uploader))); endif; ?>
						 		</div>
					 			<div class="gallery_detail">
					 				<?php echo $image->title; ?> <br />
					 				<?php echo mdate("%M %j%S, %Y", $image->date); ?>
=======
				<div id="gallery">
					<?php if($media): ?>
					 	<ul>
						 <?php foreach($media as $media): ?>
					 		<li>
					 			<div class="gallery_inset">
						 			<?php if($this->user->is_administrator() OR $this->session->userdata('username') == $media->uploader): ?>
										<?php echo $actions = anchor('gallery/del_media/' . $media->gallery_id, img(array('src' => THEME_URL . 'images/delete.png', 'alt' => 'Delete', 'class' => 'delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?>
									<?php else: ?>
										<?php echo $actions = ""; ?>
									<?php endif; ?>
									<?php if($media->video): 
										echo anchor('gallery/video/' . $media->gallery_slug, img(array('src' => $media->image, 'title' => $media->title, 'alt' => $media->title . ' by ' . $media->uploader, 'class' => 'resize_x'))); else: ?>
						 			<?php if($media->width > 130): 
						 				echo anchor('gallery/image/' . $media->gallery_slug, img(array('src' => IMAGES . 'gallery/thumbs/' . $media->image, 'title' => $media->title, 'alt' => $media->title . ' by ' . $media->uploader, 'class' => 'resize_x'))); 
						 			else:  
						 				echo anchor('gallery/image/' . $media->gallery_slug, img(array('src' => IMAGES . 'gallery/thumbs/' . $media->image, 'title' => $media->title, 'alt' => $media->title . ' by ' . $media->uploader))); endif; ?>
						 			<?php endif; ?>
						 		</div>
					 			<div class="gallery_detail">
					 				<?php echo $media->title; ?> <br />
					 				<?php echo mdate("%M %j%S, %Y", $media->date); ?>
>>>>>>> complete
					 			</div>
					 		</li>
					 	<?php endforeach; ?>
					 <?php else: ?>
					 	<p>
					 		<?php if($this->uri->segment(3) == $this->session->userdata('username')): ?>
					 			You have not uploaded any media.
					 		<?php else: ?>
					 			<?php echo $this->uri->segment(3); ?> Has not uploading any media.
					 		<?php endif; ?>
					 	</p>
					 <?php endif; ?>
						
				</div>
				<div class="clear"></div>
			
			
			</div>
		</div>
		<div class="footer"></div>
	</div>
	<div class="space"></div>
</div>

<?php $this->load->view(THEME . 'footer'); ?>
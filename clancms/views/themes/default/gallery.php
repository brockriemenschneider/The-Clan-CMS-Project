<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">
	<!-- Video Gallery -->
	<div class="box">
		<div class="header">
			<?php echo heading(CLAN_NAME. ' Video Gallery', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
			<?php if($this->user->logged_in()): ?>
				<?php if(!$this->user->can_upload() OR !$this->user->has_voice()): ?>
					<div class="alert">Your upload privileges have been revoked!</div>
				<?php endif; ?>
			<?php endif; ?>
				
				<?php if(validation_errors()): ?>
				<div class="alert">
					<?php echo validation_errors(); ?>
				</div>
				<?php endif; ?>
				
				<?php if($this->session->flashdata('gallery')): ?>
				<div class="alert">
					<?php echo $this->session->flashdata('gallery'); ?>
				</div>
				<?php endif; ?>
				
				<?php if(isset($upload->errors)): ?>
				<div class="alert">
					<?php echo $upload->errors; ?>
				</div>
				<?php endif; ?>
				
				<div id="gallery">
					<?php if($this->user->can_upload()): ?>
					<div class="upload">
						<?php 
								echo form_open('gallery');?>
							<label for="title">[video]</label>
							<span>http://www.youtube.com/watch?v=</span>
								<?php $data = array(
								              'name'        => 'videoid',
								              'maxlength'   => '11',
								              'size'        => '25',
								            );
								            
								echo form_input($data);?>
								<?php $data = array(
										'name'		=> 'video',
										'class'		=> 'submit',
										'value'		=> 'Share'
										);
								
								echo form_submit($data); ?>
							<?php if($this->user->is_administrator()): ?><span><?php echo anchor('gallery/cache', 'Cache the Channel'); ?></span><?php endif; ?>
							<?php echo form_close();?>
					</div>
					<?php endif; ?>
					
					<?php if($videos): ?>
					 	<ul>
						 <?php foreach($videos as $video): ?>
					 		<li <?php if($video->group == 'Feeder'): echo 'class=official'; endif;?>>
					 			<div class="gallery_inset <?php if($video->group == 'Feeder'): echo 'official_inset'; endif;?>">
									<?php if($this->user->logged_in() && !$video->tracked): ?>
										<?php echo anchor('gallery/video/' . $video->gallery_slug, img(array('src' => THEME_URL . 'images/new.png', 'alt' => 'new', 'class' => 'new'))); ?>
									<?php endif; ?>
						 			<?php if($this->user->is_administrator() OR $this->session->userdata('username') == $video->uploader): ?>
										<?php echo $actions = anchor('gallery/del_media/' . $video->gallery_id, img(array('src' => THEME_URL . 'images/delete.png', 'alt' => 'Delete', 'class' => 'delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?>
									<?php else: ?>
										<?php echo $actions = ""; ?>
									<?php endif; ?>
									
						 			<?php echo anchor('gallery/video/' . $video->gallery_slug, img(array('src' =>$video->video, 'title' => $video->title, 'alt' => $video->title . ' by ' . $video->uploader, 'class' => 'resize_x'))); ?> 
						 			
						 		</div>
					 			<div class="gallery_detail <?php if($video->uploader ==  $official->setting_value): echo 'official_detail'; endif;?>">
					 				<?php echo $video->title; ?> <br />
					 				<span>by</span>&nbsp;<?php echo $video->uploader; ?>
					 			</div>
					 		</li>
					 	<?php endforeach; ?>
					 <?php else: ?>
					 	<p>There are no images in the gallery.  Be the first to upload!</p>
					 <?php endif; ?>
				</div>
				<div class="space"></div>
			</div>
			<div class="footer"></div>
		</div>
	</div>
	
	<!-- Image Gallery -->
	<div class="box">
		<div class="header">
			<?php echo heading(CLAN_NAME. ' Image Gallery', 4); ?>
		</div>
		<div class=" content">
			<div class="inside">
				<div id="gallery">
					<?php if($this->user->can_upload()): ?>
					<div class="upload">
						<?php 
								echo form_open_multipart('gallery');?>
							<label for="title">[title]</label>
								<?php $data = array(
								              'name'        => 'title',
								              'maxlength'   => '15',
								              'size'        => '20',
								            );
								            
								echo form_input($data);?>
								<?php $data = array(
								              'name'        => 'userfile',
								              'size'        => '40',
								            );
								            
								echo form_upload($data);?>
								<?php $data = array(
										'name'		=> 'upload',
										'class'		=> 'submit',
										'value'		=> 'Upload'
									);
								
								echo form_submit($data); ?>
							<?php echo form_close();?>
					</div>
					<?php endif; ?>
					
					 <?php if($images): ?>
					 	<ul>
						 <?php foreach($images as $image): ?>
					 		<li>
					 			<div class="gallery_inset">
									<?php if($this->user->logged_in() && !$image->tracked): ?>
										<?php echo anchor('gallery/image/' . $image->gallery_slug, img(array('src' => THEME_URL . 'images/new.png', 'alt' => 'new', 'class' => 'new'))); ?>
									<?php endif; ?>
						 			<?php if($this->user->is_administrator() OR $this->session->userdata('username') == $image->uploader): ?>
										<?php echo $actions = anchor('gallery/del_media/' . $image->gallery_id, img(array('src' => THEME_URL . 'images/delete.png', 'alt' => 'Delete', 'class' => 'delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?>
									<?php else: ?>
										<?php echo $actions = ""; ?>
									<?php endif; ?>
									
						 			<?php if($image->width > 130): 
						 				echo anchor('gallery/image/' . $image->gallery_slug, img(array('src' => IMAGES . 'gallery/thumbs/' . $image->image, 'title' => $image->title, 'alt' => $image->title . ' by ' . $image->uploader, 'class' => 'resize_x'))); 
						 			else:  
						 				echo anchor('gallery/image/' . $image->gallery_slug, img(array('src' => IMAGES . 'gallery/thumbs/' . $image->image, 'title' => $image->title, 'alt' => $image->title . ' by ' . $image->uploader))); endif; ?>
						 		</div>
					 			<div class="gallery_detail">
					 				<?php echo $image->title; ?> <br />
					 				<span>by</span>&nbsp;<?php echo $image->uploader; ?>
					 			</div>
					 		</li>
					 	<?php endforeach; ?>
					 <?php else: ?>
					 	<p>There are no images in the gallery.  Be the first to upload!</p>
					 <?php endif; ?>
				</div>
				<div class="space"></div>
			</div>
			<div class="footer"></div>
		</div>
	</div>
</div>

<?php $this->load->view(THEME . 'footer'); ?>
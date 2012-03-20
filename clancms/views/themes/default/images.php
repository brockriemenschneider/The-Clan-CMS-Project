<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">
	<!-- Video Gallery -->
	<div class="box">
		<div class="header">
			<?php echo heading(CLAN_NAME. ' Image Gallery', 4); ?>
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
<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">
	<div class="box">
		<div class="header">
			<?php echo heading('Official ' . CLAN_NAME . ' Video Gallery', 4); ?>
		</div>
		<div class="content">
			<div class="inside">

	
				<div id="videos">
					<ul id="mycarousel" class="jcarousel-skin-tango">
					<?php //  extract the videos
					foreach ($sxml->entry as $item)
					{ 
					       
							// Title
							$vTitle = $item->title[0];
					
							// Link
							$attrs = $item->link[0];
							$attrs = $attrs['href'];
							$attrs = explode('&',$attrs);
							$vLink = $attrs[0];
							
							// Updated
							$attrs = $item->updated;
							$attrs = explode('T',$attrs);
							$vUpdate = $attrs[0];
							
							// get nodes in media: namespace for media information
					      		$media = $item->children('http://search.yahoo.com/mrss/');
							$attrs = $media->group->thumbnail[0]->attributes();
							$vThumb = $attrs['url'];
							
							// make video player
							$attrs = $media->group->player->attributes();
							$watch = $attrs['url'];
							$exp = explode('=',$watch);
							$exp1 = explode('&',$exp[1]); 
							$uri = $exp1[0];
					
							$video ="
					        <object>
					        <param name='movie' value='http://www.youtube.com/v/" . $exp1[0] . "?version=3'>
					        <param name='allowFullScreen' value='false'>
					        <param name='allowScriptAccess' value='always'>
					        <embed src='http://www.youtube.com/v/" . $exp1[0] . "?version=3' type='application/x-shockwave-flash' allowfullscreen='false' allowScriptAccess='always' width='223' height='200'>
					        </object>";
							
							// get <gd:rating> node for video ratings
							$gd = $item->children('http://schemas.google.com/g/2005');
							$attrs = $gd->rating->attributes();
							$vRating = round($attrs['average'], 2);
					
							// nodes in yt:ns
							$yt = $item->children('http://gdata.youtube.com/schemas/2007');
							$attrs = $yt->statistics->attributes();
							$vViews = $attrs['viewCount'];
							
							echo "<li>
									
										<img src='" .$vThumb . "' height='200px' width='210px'><br />"
										. $vTitle . "<br />"
										. $vUpdate ."
								</li>";
					
						}?>
					</ul>
				</div>
			
			</div>
		</div>
	</div>
	
	<!-- Photos -->
	<div class="box">
		<div class="header">
			<?php echo heading('User Image Gallery', 4); ?>
		</div>
		<div class=" content">
			<div class="inside">
				<?php if(!$this->user->can_upload() OR !$this->user->has_voice()): ?>
					<div class="alert">Your upload privileges have been revoked!</div>
				<?php endif; ?>
				
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
				
				<?php if(isset($upload->errors)): ?>
				<div class="alert">
					<?php echo $upload->errors; ?>
				</div>
				<?php endif; ?>
				
				<div id="photos">
					<?php if($this->user->can_upload()): ?>
					<div class="upload">
						<?php 
								echo form_open_multipart('gallery');?>
							<label for="title">Title</label>
								<?php
								echo form_input('title');
								echo form_upload('userfile');
								echo form_submit('upload', 'Upload');
								echo form_close();
							 ?>
					</div>
					<?php endif; ?>
					
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
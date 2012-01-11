<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>
<style type="text/css">
#videos {
    margin-bottom: 15px;
    overflow: hidden;
    border: 1px solid #1b1b1b;
    box-shadow: 0 0 15px #444 inset;
    padding: 9px 0;
    border-radius: 12px;
}
#videos ul {
    list-style: none;
    padding: 5px;
    white-space: nowrap;
}
#videos li {
    display: inline;
    border: 1px solid #2b2b2b;
    margin-right: 3px;
    overflow: hidden;
    font-family: mw3;
    font-size: 10px;
}
#photos {
	padding: 0 4px;
	}
#alerts {
	height: 40px; 
	}
#photos ul {
	list-style: none;
	padding: 0;
	}
#photos li {
    display: inline-block;
    margin: 0 7px 8px 0;
    outline: 1px solid #555;
    width: 130px;
    height: 150px;
}
#photos .delete {
    float: right;
    position: relative;
    z-index: 1000;
    margin: 5px 5px -21px 0;
}
#photos .comment {
	float: left;
	position: relative;
	z-index: 1000;
	margin: 5px 5px -21px 0;
	height: 16px;
	width:16px;
	}
#photos li img {
    border: 0 none;
    clear: both;
}
.bold {
	font-weight: 800;
	color: #666;
	}
</style>
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
					<?php if($this->user->logged_in()): ?>
						<?php 
								echo form_open_multipart('gallery');?>
							<label for="title">Title</label>
								<?php
								echo form_input('title');
								echo form_upload('userfile');
								echo form_submit('upload', 'Upload', array('class' => 'submit'));
								echo form_close();
							 ?>
					<?php endif; ?>
						 
						 <?php if($images): ?>
						 	<ul>
							 <?php foreach($images as $image): ?>
						 		<li>
						 			<?php if($this->user->logged_in()): ?>
										<?php echo $actions = anchor('gallery/comment/' . $image->id, img(array('src' => THEME_URL . 'images/edit.png', 'height' => 16, 'width' => 16, 'alt' => 'Comment on ' . $image->title, 'class' => 'comment'))); ?>
									<?php else: ?>
										<?php echo $actions = ""; ?>
									<?php endif; ?>
						 			<?php if($this->user->is_administrator() OR $this->session->userdata('user_id') == $image->uploader): ?>
										<?php echo $actions = anchor('gallery/del_image/' . $image->id, img(array('src' => THEME_URL . 'images/delete.png', 'alt' => 'Delete', 'class' => 'delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?>
									<?php else: ?>
										<?php echo $actions = ""; ?>
									<?php endif; ?>
						 			<?php echo anchor(IMAGES . 'gallery/' . $image->image, img(array('src' => IMAGES . 'gallery/thumbs/' . $image->image, 'title' => $image->title, 'alt' => $image->title . ' by ' . $image->uploader))); ?>
						 			<?php echo $image->title; ?>
						 			<?php echo '<br />by: ' . anchor('account/profile/' .$image->uploader, $image->uploader); ?>
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
<script type="text/javascript">
	function deleteConfirm()
	{
    	var answer = confirm("Are you sure you want to delete this image? Once deleted, there will be no way to recover it!")
    	if (answer)
		{
        	document.messages.submit();
    	}
    
    	return false;  
	} 
</script> 

<?php $this->load->view(THEME . 'footer'); ?>
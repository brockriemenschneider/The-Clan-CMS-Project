<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">
	<div class="box">
		<div class="header">
			<h4>
				<?php echo $video->title . ' from ' . $media->uploader;?>
				<?php if($this->user->is_administrator() OR $this->session->userdata('user_id') == $media->uploader): ?>
					<?php echo $actions = anchor('gallery/del_media/' . $media->gallery_id, img(array('src' => THEME_URL . 'images/delete.png', 'alt' => 'Delete', 'class' => 'delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?>
				<?php else: ?>
					<?php echo $actions = ""; ?>
				<?php endif; ?>
			</h4>
		</div>
		<div class="content">
			<div class="inside">
				<div class="gallery">
					<div class="media">
						<object>
						        <param name='movie' value='http://www.youtube.com/v/<?php echo $this->uri->segment(3); ?>?version=3'>
						        <param name='allowFullScreen' value='false'>
						        <param name='allowScriptAccess' value='always'>
						        <embed src='http://www.youtube.com/v/<?php echo $this->uri->segment(3); ?>?version=3' type='application/x-shockwave-flash' allowfullscreen='false' allowScriptAccess='always' width='710' height='400'>
					        </object>
					</div>
					
					<?php if($this->session->flashdata('message')): ?>
					<div class="alert">
						<?php echo $this->session->flashdata('message'); ?>
					</div>
					<?php endif; ?>
					
					<div class="properties">
						<div class="title"><?php echo $media->title; ?></div>
						<ul class="labels">
							<li>[uploader]&nbsp;</li>
							<li>[uploaded]&nbsp;</li>
							<li>[vid author]&nbsp;</li>
							<li>[vid date]&nbsp;</li>
							<li>[views]&nbsp;</li>
							<li>[favors]&nbsp;</li>
							<li>[comments]&nbsp;</li>
						</ul>
						<ul class="info">
							<li><?php echo $media->uploader; ?></li>
							<li><?php echo mdate("%M %j%S, %Y", $media->date); ?></li>
							<li><?php echo $video->author; ?></li>
							<li><?php echo $video->updated; ?></li>
							<li><?php echo $media->views; ?></li>
							<li><?php echo $media->favors; ?></li>
							<li><?php echo $media->comments; ?></li>
						</ul>
						<div class="clear"></div>
						<?php if($this->user->logged_in()): ?>
						<ul class="share">
							<?php echo anchor($video->watchURL, '<li class="youtube"></li>', array('title' => 'Watch on YouTube'));?>
							<li class="favor"></li>
							<li class="facebook"></li>
							<li class="twitter"></li>
							<li class="stumble"></li>
						</ul>
						<?php endif; ?>
					</div>
					
					<div class="gallery_description">
						<div class="uploader">
							<?php if($media->avatar): ?>
								<?php echo anchor('account/profile/' . $media->uploader, img(array('src' => IMAGES . 'avatars/' . $media->avatar, 'title' => $media->uploader, 'alt' => $media->uploader, 'width' => '75', 'height' => '75'))); ?>
							<?php else: ?>
								<?php echo anchor('account/profile/' . $media->uploader, img(array('src' => THEME_URL . 'images/avatar_none.png', 'title' => $media->avatar, 'alt' => $media->avatar, 'width' => '75', 'height' => '75'))); ?>
							<?php endif; ?>
							<span><?php echo $media->uploader;?></span>
							<span class=<?php if($media->group == 'Administrators'): echo 'admin'; else: echo 'user'; endif; ?>><?php if($media->group): echo $media->group; endif;?></span>
						</div>
						<div class="uploader_desc">
							<?php if($media->desc): ?>
								<?php if($this->user->is_administrator() OR $this->session->userdata('username') == $media->uploader): ?>
									<?php echo img(array('src' => THEME_URL . 'images/edit.png', 'title' => 'Edit', 'alt' => 'Edit Description', 'class' => 'right edit')); ?>
									<div id="edit" style="display: none;">
									<?php echo form_open('gallery/video/' . $media->gallery_slug); ?>
									<?php $data = array(
											'name'		=> 'desc',
											'rows'		=> '4',
											'cols'			=> '40',
											'value'		=> $media->desc
											);
									echo form_textarea($data); ?>
									<?php $data = array(
												'name'		=> 'add_desc',
												'class'		=> 'submit',
												'value'		=> 'Describe'
											);
										echo form_submit($data); ?>
									<button id="cancel" class="submit ui-button ui-widget ui-state-default ui-corner-all">Cancel</button>
									<?php echo form_close(); ?>
									</div>
								<?php endif; ?> 
							
								<p><?php echo $media->desc; ?></p>
							<?php else: ?>
								<?php if($this->session->userdata('username') == $media->uploader): ?>
									<?php echo form_open('gallery/video/' . $media->gallery_slug); ?>
									<?php
										$data = array(
											'name'		=> 'desc',
											'rows'		=> '4',
											'cols'			=> '40'
										);
									
									echo form_textarea($data); ?>
									<?php 
											$data = array(
												'name'		=> 'add_desc',
												'class'		=> 'submit',
												'value'		=> 'Describe'
											);
										
										echo form_submit($data); ?>
										<div class="clear"></div>
									<?php echo form_close(); ?>
								<?php else: ?>
									No description given by uploader
								<?php endif; ?>
							<?php endif; ?>
						</div>
					</div>
					<?php if($this->user->logged_in() && $this->session->userdata('username') != $media->uploader): ?>
						<div class="right"> More from this uploader: <?php echo anchor('gallery/user/' . $media->uploader, 'here'); ?></div>
					<?php endif;?>
					
					<div class="gallery_comments">
						<?php if($this->user->logged_in() && $user->has_voice == 1): ?>
								<?php echo form_open('gallery/video/' . $media->gallery_slug); ?>
								<?php
									$data = array(
										'name'		=> 'comment',
										'rows'		=> '2',
										'cols'			=> '46'
									);
								
								echo form_textarea($data); ?>
								<?php 
										$data = array(
											'name'		=> 'add_comment',
											'class'		=> 'submit',
											'value'		=> 'Comment'
										);
									
									echo form_submit($data); ?>
							<div class="clear"></div>
						<?php endif; ?>
						<?php echo br(); ?>
						
						<?php if($comments): ?>
							<?php foreach($comments as $comment): ?>
								<?php if($comment->author == $media->uploader): $style = '<ul class = "author">'; else: $style = '<ul>';  endif; ?>
									
							<?php echo $style; ?>
								<li class="poster">
									<?php if($comment->avatar): ?>
										<?php echo anchor('account/profile/' . $this->users->user_slug($comment->author), img(array('src' => IMAGES . 'avatars/' . $comment->avatar, 'title' => $comment->author, 'alt' => $comment->author, 'width' => '57', 'height' => '57'))); ?>
									<?php else: ?>
										<?php echo anchor('account/profile/' . $this->users->user_slug($comment->author), img(array('src' => THEME_URL . 'images/avatar_none.png', 'title' => $comment->author, 'alt' => $comment->author, 'width' => '57', 'height' => '57'))); ?>
									<?php endif; ?>
								</li>
								<?php if($comment->author == $media->uploader): echo '<li class = "right"><span class="admin">***UPLOADER***</span></li>'; endif; ?>
								<li class="post_head">
									<?php if($this->user->is_administrator() OR $this->session->userdata('user_id') == $comment->user_id): ?>
										<?php $actions = anchor('gallery/delete_comment/' . $comment->comment_id, img(array('src' => THEME_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?>
									<?php else: ?>
										<?php $actions = ""; ?>
									<?php endif; ?>
									<?php echo anchor('account/profile/' . $comment->author, $comment->author) . ' Posted ' . mdate("%M %d, %Y at %h:%i %a ", $comment->date) . $actions; ?>
								</li>
								<li class="posted"><?php echo $comment->comment_title; ?></li>
							</ul>
							<?php endforeach; ?>
						<?php else: ?>
								No one has yet commented on this video. <?php if(!$this->user->logged_in()): echo 'Please ' . anchor('account/login', 'login') . ' to post comments.'; endif; ?>
						<?php endif; ?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="footer"></div>
	</div>
	<div class="space"></div>
</div>
<script>
$(".edit").click(function () {
  $("div#edit").show("fast", function () {
    /* use callee so don't have to name the function */
    $(this).next("div.edit").show("fast", arguments.callee);
  });
});
$("#cancel").click(function () {
  $("div.edit").hide(2000);
});

</script>

<?php $this->load->view(THEME . 'footer'); ?>
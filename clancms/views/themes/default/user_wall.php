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
					<li><span class="left"></span><span class="middle"><?php echo anchor('gallery/user/' . $user->user_name, 'My Media'); ?></span><span class="right"></span></li>
					<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('account/wall/' . $user->user_name, 'My Wall'); ?></span><span class="right"></span></li>
				<?php else: ?>
					<li><span class="left"></span><span class="middle"><?php echo anchor('gallery/user/' . $this->uri->segment(3), $this->uri->segment(3) . '\'s Media'); ?></span><span class="right"></span></li>
					<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('account/wall/' . $this->uri->segment(3), $this->uri->segment(3) . '\'s Wall'); ?></span><span class="right"></span></li>
				<?php endif; ?>
			</ul>
		</div>
	
		<div class="header">
			<?php echo heading($user->user_name . "'s Wall", 4); ?>
		</div>
		
		<div class="content">
			<div class="inside">
				<?php if(validation_errors()): ?>
				<div class="alert">
					<?php echo validation_errors(); ?>
				</div>
				<?php endif; ?>
				
				<?php if($this->session->flashdata('wall')): ?>
				<div class="alert">
					<?php echo $this->session->flashdata('wall'); ?>
				</div>
				<?php endif; ?>
				
				<div class="wall_head">
					<div class="wall_avatar">
						<?php if($user->user_avatar): ?>
							<?php echo anchor('account/profile/' . $this->users->user_slug($user->user_name), img(array('src' => IMAGES . 'avatars/' . $user->user_avatar, 'title' => $user->user_name, 'alt' => $user->user_name, 'width' => '100', 'height' => '100'))); ?>
						<?php else: ?>
							<?php echo anchor('account/profile/' . $this->users->user_slug($user->user_name), img(array('src' => THEME_URL . 'images/avatar_none.png', 'title' => $user->user_name, 'alt' => $user->user_name, 'width' => '100', 'height' => '100'))); ?>
						<?php endif; ?>
						<br />
						<?php if($this->user->is_administrator() OR $this->session->userdata('user_id') == $user->user_name): ?>
							<?php if((bool)$user->wall_enabled):
									echo anchor('account/wall_status/' . $user->user_id, 'Disable Wall');
								else:
									echo anchor('account/wall_status/' . $user->user_id, 'Enable Wall');
								endif;
							?>
						<?php endif; ?>
					</div>
					<div class="wall_status">
						<?php if($user->status): ?>
								<?php if($this->user->is_administrator() OR $this->session->userdata('username') == $this->uri->segment(3)): ?>
									<?php echo img(array('src' => THEME_URL . 'images/edit.png', 'title' => 'Edit', 'alt' => 'Edit Status', 'class' => 'right edit')); ?>
									<div id="edit" style="display: none;">
									<?php echo form_open('account/wall/' . $this->uri->segment(3)); ?>
									<?php $data = array(
											'name'		=> 'status',
											'rows'		=> '5',
											'cols'			=> '50',
											'value'		=> $user->status
											);
									echo form_textarea($data); ?>
									<?php $data = array(
												'name'		=> 'add_status',
												'class'		=> 'submit',
												'value'		=> 'Submit'
											);
										echo form_submit($data); ?>
									<button id="cancel" class="submit ui-button ui-widget ui-state-default ui-corner-all">Cancel</button>
									<?php echo form_close(); ?>
									</div>
								<?php endif; ?> 
							
								<p id="status"><?php echo $user->status_bb ?></p>
							<?php else: ?>
								<?php if($this->session->userdata('username') == $this->uri->segment(3)): ?>
									<?php echo form_open('account/wall/' . $this->uri->segment(3)); ?>
									<?php
										$data = array(
											'name'		=> 'status',
											'rows'		=> '5',
											'cols'			=> '50'
										);
									
									echo form_textarea($data); ?>
									<?php 
											$data = array(
												'name'		=> 'add_status',
												'class'		=> 'submit',
												'value'		=> 'Submit'
											);
										
										echo form_submit($data); ?>
										<div class="clear"></div>
									<?php echo form_close(); ?>
								<?php else: ?>
									User has not set his status
								<?php endif; ?>
							<?php endif; ?>
					</div>
				</div>
				
				<div class="clear"></div>
				
				<?php if( (bool)$user->wall_enabled): ?>
				<hr class="wall_hr" />
				
				<div class="wall_comments">
					<?php if($this->user->logged_in() && $user->has_voice == 1): ?>
					<div id="comment_area">
						<div id="comment_box">
							<span>Leave a message on <?php echo $this->uri->segment(3);?>'s wall.</span> <br />
						
							<?php echo form_open('account/wall/' . $this->uri->segment(3)); ?>
							
							<?php
								$data = array(
									'name'	=> 'comment',
									'rows'	=> '2',
									'id'		=> 'wall_comment'
								);
							
							echo form_textarea($data); ?>
						</div>
							<?php 
									$data = array(
										'name'	=> 'add_comment',
										'class'	=> 'submit',
										'value'	=> 'Comment'
									);
								
								echo form_submit($data); ?>
								
							<?php echo form_close();?>
							<div class="clear"></div>
						</div>
					<?php endif;?>
					<?php echo br(); ?>
					
					<?php if($comments): ?>
						<?php foreach($comments as $comment): ?>
							<?php if($comment->author == $this->uri->segment(3)): $style = '<ul class = "author">'; else: $style = '<ul>';  endif; ?>
								
						<?php echo $style; ?>
							<li class="poster">
								<?php if($comment->avatar): ?>
									<?php echo anchor('account/profile/' . $this->users->user_slug($comment->author), img(array('src' => IMAGES . 'avatars/' . $comment->avatar, 'title' => $comment->author, 'alt' => $comment->author, 'width' => '57', 'height' => '57'))); ?>
								<?php else: ?>
									<?php echo anchor('account/profile/' . $this->users->user_slug($comment->author), img(array('src' => THEME_URL . 'images/avatar_none.png', 'title' => $comment->author, 'alt' => $comment->author, 'width' => '57', 'height' => '57'))); ?>
								<?php endif; ?>
							</li>
							
							<li class="post_head">
								<?php if($this->user->is_administrator() OR $this->session->userdata('user_id') == $comment->wall_owner_id): ?>
									<?php $actions = anchor('account/delete_comment/' . $comment->comment_id, img(array('src' => THEME_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?>
								<?php else: ?>
									<?php $actions = ""; ?>
								<?php endif; ?>
								<?php echo anchor('account/profile/' . $comment->author, $comment->author) . ' Posted ' . mdate("%M %d, %Y at %h:%i %a ", $comment->comment_date) . $actions; ?>
							</li>
							<li class="posted"><?php echo $comment->comment; ?></li>
						</ul>
						<?php endforeach; ?>
					<?php else: ?>
							No one has yet commented on this user. <?php if(!$this->user->logged_in()): echo 'Please ' . anchor('account/login', 'login') . ' to post comments.'; endif; ?>
					<?php endif; ?>
				</div>
				
				<?php if($comments): ?>
				<div class="box">
					<div class="pages">
					<ul>
						<?php if($pages): ?>
							<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('account/wall/' . $user->user_name . '/page/' . $pages->current_page, 'Page ' . $pages->current_page . ' of ' . $pages->total_pages); ?></span><span class="right"></span></li>
								<?php if($pages->first): ?><li><span class="left"></span><span class="middle"><?php echo anchor('articles/view/' . $article->article_slug . '/page/1', '<<'); ?></span><span class="right"></span></li><?php endif; ?>
								<?php if($pages->previous): ?><li><span class="left"></span><span class="middle"><?php echo anchor('articles/view/' . $article->article_slug . '/page/' . ($pages->current_page - 1), '<'); ?></span><span class="right"></span></li><?php endif; ?>
							
							<?php if($pages->before): ?>
								<?php foreach($pages->before as $before): ?>
									<li <?php if($pages->current_page == $before): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor('articles/view/' . $article->article_slug . '/page/' . $before, $before); ?></span><span class="right"></span></li>
								<?php endforeach; ?>
							<?php endif; ?>
							
							<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('account/wall/' . $user->user_name . '/page/' . $pages->current_page, $pages->current_page); ?></span><span class="right"></span></li>
							
							<?php if($pages->after): ?>
								<?php foreach($pages->after as $after): ?>
									<li <?php if($pages->current_page == $after): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor('articles/view/' . $article->article_slug . '/page/' . $after, $after); ?></span><span class="right"></span></li>
								<?php endforeach; ?>
							<?php endif; ?>
							
								<?php if($pages->next): ?><li><span class="left"></span><span class="middle"><?php echo anchor('articles/view/' . $article->article_slug . '/page/' . ($pages->current_page + 1), '>'); ?></span><span class="right"></span></li><?php endif; ?>
								<?php if($pages->last): ?><li><span class="left"></span><span class="middle"><?php echo anchor('articles/view/' . $article->article_slug . '/page/' . $pages->total_pages, '>>'); ?></span><span class="right"></span></li><?php endif; ?>
						<?php endif; ?>
					</ul>
					</div>
				</div>
				<?php endif; ?>
				
			<?php endif; ?>
				
			</div>
		</div>
		<div class="footer"></div>
	</div>
</div>

<script>
$(".edit").click(function () {
  $("div#edit").show("fast", function () {
    $(this).next("div.edit").toggle("fast", arguments.callee);
    $('p#status').hide();
  $('.edit').hide();
  });
});
$("#cancel").click(function () {
  $("div.edit").hide();
});

</script>
<?php $this->load->view(THEME . 'footer'); ?>
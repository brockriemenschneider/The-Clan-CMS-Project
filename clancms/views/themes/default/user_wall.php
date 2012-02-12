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
				
				<?php if($this->session->flashdata('message')): ?>
				<div class="alert">
					<?php echo $this->session->flashdata('message'); ?>
				</div>
				<?php endif; ?>
				
				<div class="wall_head">
					<div class="wall_avatar">
						<?php if($user->user_avatar): ?>
							<?php echo anchor('account/profile/' . $this->users->user_slug($user->user_name), img(array('src' => IMAGES . 'avatars/' . $user->user_avatar, 'title' => $user->user_name, 'alt' => $user->user_name, 'width' => '57', 'height' => '57'))); ?>
						<?php else: ?>
							<?php echo anchor('account/profile/' . $this->users->user_slug($user->user_name), img(array('src' => THEME_URL . 'images/avatar_none.png', 'title' => $user->user_name, 'alt' => $user->user_name, 'width' => '57', 'height' => '57'))); ?>
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
											'rows'		=> '7',
											'cols'			=> '60',
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
							
								<p id="status"><?php echo $user->status ?></p>
							<?php else: ?>
								<?php if($this->session->userdata('username') == $this->uri->segment(3)): ?>
									<?php echo form_open('account/wall/' . $this->uri->segment(3)); ?>
									<?php
										$data = array(
											'name'		=> 'status',
											'rows'		=> '7',
											'cols'			=> '60'
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
				
				<div class="wall_comments">
					<?php if($this->user->logged_in() && $user->has_voice == 1): ?>
							<?php echo form_open('account/wall/' . $this->uri->segment(3)); ?>
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
				<div class="clear"></div>
				
			</div>
		</div>
		<div class="footer"></div>
	</div>
</div>

<script>
$(".edit").click(function () {
  $("div#edit").show("fast", function () {
    /* use callee so don't have to name the function */
    $(this).next("div.edit").show("fast", arguments.callee);
    $('p#status').hide('fast');
  });
});
$("#cancel").click(function () {
  $("div.edit").hide(2000);
});

</script>
<style>
/* ------
	WALL COMMENT AREA ----- */
.comment_textarea {
    boxshadow: 0 0 15px #999999 inset;
    padding: 10px;
}
textarea {
    background: none repeat scroll 0 0 #CCCCCC;
    border: 1px solid #666666;
    border-radius: 8px 8px 8px 8px;
    color: darkGreen;
    margin: 0 auto;
    padding: 3px;
    text-shadow: 0 0 0.02em #48661F;
}
.comment_textarea .submit {
    float: right;
    margin:  5px 20px;
    background: url(./images/commentsprite.png) 0 0;
    width: 81px;
}
.comment_textarea .submit:hover {
    background-position: 0px 26px;
}
.comment_textarea .submit:active {
    background-position: 0px 52px;
}
.wall_comments {
    float: left;
    width: 435px;
    margin: 10px 0 0;
}
.wall_comments .author {
    border: 1px solid #cc6600;
    box-shadow: 0 0 3px #cc6600 inset;
}
.wall_comments .author li.poster {
    float: right;
    padding: 4px;
    border-left: 1px solid #cc6600;
}
.wall_comments ul {
    border: 1px solid #444444;
    display: block;
    list-style: none outside none;
    margin: 0;
    padding: 0;
    height: 65px;
}
.wall_comments li.poster {
    float: left;
    padding: 5px;
    border-right: 1px solid #444;
}
.wall_comments li.post_head {
    color: #999;
    text-indent: 5px;
}
.wall_comments li.posted {
    font-family: centabel;
    font-size: 14px;
    text-indent: 5px;
}
</style>
<?php $this->load->view(THEME . 'footer'); ?>
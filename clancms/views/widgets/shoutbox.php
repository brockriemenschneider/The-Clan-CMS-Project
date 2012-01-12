<style>
#shoutbox {
    border: 1px solid #2B2B2B;
    height: 250px;
    padding: 3px;
    overflow-y: auto;
    overflow-x: hidden;
    margin: 0 0 3px;
}
#shouts {
	padding: 0;
	margin: 0;
	list-style: none;
	}
.admin {
	color: orange;
	font-variant: small-caps;
	background: #333;
	}
.user {
	color: #ccc;
	}
.time {
	font-size: 80%;
	font-variant: normal;
	}
#shout_input .alert{
	background: none repeat scroll 0 0 #F6E68D;
	border: 2px solid #FFD800;
	color: #0F0F0F;
	font-weight: 800;
	text-align: center;
	line-height: 15px;
	font-size: 10px;
	margin: 3px 0 0;
	}
#shout_input p {
	margin: 0;
	padding: 0;
	}
</style>
<div id="shoutbox">
	<?php if($shouts): ?>
		<ul id="shouts">
		<?php foreach($shouts as $shout): ?>
			<li class=<?php if($shout->rank == 'Administrators'): echo 'admin'; else: echo 'user'; endif; ?>>
				<?php if($shout->avatar): echo img(array('src' => IMAGES . 'avatars/' . $shout->avatar, 'height' => 16, 'width' => 16)); else: echo img(array('src' => IMAGES . 'avatars/avatar_none.png', 'height' => 16, 'width' => 16)); endif; ?>
				<?php echo anchor('account/profile/' . $shout->user, $shout->user); ?>
				<?php echo $shout->shout; ?>
				<span class="right yellow time"><?php echo $shout->delay; ?></span>
				<div class="clear"></div>
			<li>
		<?php endforeach; ?>
		</ul>
	<?php else: ?>
		<p>Shoutbox is empty</p>
	<?php endif; ?>
</div>
<?php if($this->user->logged_in()): ?>
	<div id="shout_input">
		<?php $user_info = array (
			'user'	=> $user->user_name,
			'avatar'	=> $user->user_avatar,
			'rank'	=> $user->group
			); 
		?>
			
		<?php echo form_open('', '', $user_info);?>
		<?php $data = array(
				'name'	=>	'comment',
				'maxlength'	=>	'80',
				'style'		=>	'width:64%'
				)
		?>
		<?php echo form_input($data);?>
		<?php 
					$data = array(
						'name'		=> 'shoutbox',
						'class'		=> 'submit',
						'value'		=> 'Shout!'
					);
				
				echo form_submit($data); ?>
		<?php echo form_close(); ?>
		<div class="clear"></div>
		
		<?php echo anchor('shouts', 'Shout History'); ?>
		<!-- Form Validation -->
				<?php if(validation_errors()): ?>
				<div class="alert">
					<?php echo validation_errors(); ?>
				</div>
				<?php endif; ?>
				<?php if($this->session->flashdata('shout')): ?>
				<div class="alert">
					<?php echo $this->session->flashdata('shout'); ?>
				</div>
				<?php endif; ?>
				<?php echo br(); ?>
			<!-- End Validation -->
	</div>
<?php endif; ?>
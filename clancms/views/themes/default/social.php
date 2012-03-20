<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">
	
	<div class="box">
		<div class="tabs">
		<ul>
			<li><span class="left"></span><span class="middle"><?php echo anchor('account/profile/' . $this->users->user_slug($user->user_name), $user->user_name); ?></span><span class="right"></span></li>
			<?php if($user->user_id == $this->session->userdata('user_id')): ?>
				<li><span class="left"></span><span class="middle"><?php echo anchor('account/', 'My Account'); ?></span><span class="right"></span></li>
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('account/social', 'My Social'); ?></span><span class="right"></span></li>
				<li><span class="left"></span><span class="middle"><?php echo anchor('gallery/user/' . $user->user_name, 'My Media'); ?></span><span class="right"></span></li>
				<li><span class="left"></span><span class="middle"><?php echo anchor('account/wall/' . $user->user_name, 'My Wall'); ?></span><span class="right"></span></li>
			<?php else: ?>
				<li><span class="left"></span><span class="middle"><?php echo anchor('gallery/user/' . $this->uri->segment(3), $this->uri->segment(3) . '\'s Media'); ?></span><span class="right"></span></li>
				<li><span class="left"></span><span class="middle"><?php echo anchor('account/wall/' . $this->uri->segment(3), $this->uri->segment(3) . '\'s Wall'); ?></span><span class="right"></span></li>
			<?php endif; ?>
			
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('My Social Media', 4); ?>
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
				
				<?php echo form_open('account/social'); ?>
				
				<div class="label">Facebook</div>
				<?php 
				$data = array(
					'name'		=> 'facebook',
					'size'		=> '30',
					'class'		=> 'input',
					'value'	=>	$social->facebook
				);

				echo form_input($data); ?>
				<?php echo br(); ?>
				
				<div class="label">Twitter</div>
				<?php 
				$data = array(
					'name'		=> 'twitter',
					'size'		=> '30',
					'class'		=> 'input',
					'value'	=>	$social->twitter
				);

				echo form_input($data); ?>
				<?php echo br(); ?>
				
				<div class="label">Xbox Live</div>
				<?php 
				$data = array(
					'name'		=> 'xboxlive',
					'size'		=> '30',
					'class'		=> 'input',
					'value'	=>	$social->xbox_live
				);

				echo form_input($data); ?>
				<?php echo br(); ?>
				
				<div class="label">PS Online</div>
				<?php 
				$data = array(
					'name'		=> 'psonline',
					'size'		=> '30',
					'class'		=> 'input',
					'value'	=>	$social->ps_online
				);

				echo form_input($data); ?>
				<?php echo br(); ?>
				
				<div class="label">Steam</div>
				<?php 
				$data = array(
					'name'		=> 'steam',
					'size'		=> '30',
					'class'		=> 'input',
					'value'	=>	$social->steam
				);

				echo form_input($data); ?>
				<?php echo br(); ?>
				
				<div class="label">Skype</div>
				<?php 
				$data = array(
					'name'		=> 'skype',
					'size'		=> '30',
					'class'		=> 'input',
					'value'	=>	$social->skype
				);

				echo form_input($data); ?>
				<?php echo br(); ?>
			 	
				<div class="label">YouTube</div>
				<?php 
				$data = array(
					'name'		=> 'youtube',
					'size'		=> '30',
					'class'		=> 'input',
					'value'	=>	$social->youtube
				);

				echo form_input($data); ?>
				<?php echo br(); ?>
			 
				<?php 
					$data = array(
						'class'		=> 'submit',
						'value'		=> 'Reset'
					);
				
				echo form_reset($data); ?>
				<div class="clear"></div>
				<?php echo br(); ?>
			 
				<?php 
					$data = array(
						'name'		=> 'update_social',
						'class'		=> 'submit',
						'value'		=> 'Update Social'
					);
				
				echo form_submit($data); ?>
				<div class="clear"></div>
				<?php echo form_close(); ?>
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
</div>


<?php $this->load->view(THEME . 'footer'); ?>
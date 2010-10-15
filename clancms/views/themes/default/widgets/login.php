<div class="widget">
		<div class="header"></div>
		<div class="content">
			<div class="inside">
				
				<?php if($this->user->logged_in()): ?>
				Welcome back, <?php echo anchor('account/profile/' . $this->users->user_slug($this->session->userdata('username')), $this->session->userdata('username')); ?>!
				<?php echo br(); ?>
				<?php if($this->user->is_administrator()): echo anchor(ADMINCP, 'Admin CP') . ' | '; endif; ?> <?php echo anchor('account', 'My Account'); ?> | <?php echo anchor('account/logout', 'Logout'); ?>
				<?php else: ?>
				<?php echo form_open('account/login'); ?>
				<div class="label">Username:</div>
				<?php 
				$data = array(
					'name'		=> 'username',
					'size'		=> '18',
					'class'		=> 'input'
				);

				echo form_input($data); ?>
				<?php echo br(2); ?>
				
				<div class="label">Password:</div> 
				<?php 
				$data = array(
					'name'		=> 'password',
					'size'		=> '18',
					'class'		=> 'input'
				);

				echo form_password($data); ?>
				<?php echo br(2); ?>
				<?php
					$data = array(
						'name'		=> 'remember',
						'value'		=> '1',
						'class'		=> 'label'
					);
					
					echo form_checkbox($data); ?><div class="label"><?php echo nbs(2); ?>Remember me?</div>
				<?php echo form_hidden('redirect', $this->session->userdata('current')); ?>
				<?php 
					$data = array(
						'name'		=> 'login',
						'class'		=> 'submit',
						'value'		=> 'Login'
					);
				
				echo form_submit($data); ?>
				
				<div class="clear"></div>
				<?php echo form_close(); ?>
				<?php endif; ?>
			</div>
		</div>
		<div class="footer"></div>
		
		<div class="tabs">
		<ul>
			<?php if($this->user->logged_in()): ?>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('account', 'MY ACCOUNT'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor('account/logout', 'LOGOUT'); ?></span><span class="right"></span></li>
			<?php else: ?>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('account/login', 'LOGIN'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor('register', 'REGISTER'); ?></span><span class="right"></span></li>
			<?php endif; ?>
		</ul>
		</div>
	</div>
<?php $this->load->view('install/header'); ?>
    <form method="post">
    <?php if(validation_errors()): ?>
        <div class="ui-widget">
            <div id="error" class="ui-state-error ui-corner-all">
		<p><?php echo validation_errors(); ?></p>
            </div>
	</div>
    <?php echo br(); ?>
    <?php endif; ?>
	
	<div id='box'>

            <div id='header'>
                <div class='title'>Step 4: Account Registration</div>
            </div>

            <div id='subheader'>
                <div class='title'>Account Information</div>
            </div>

            <div id='middle'>
			<div class='required-field'>
				<span class='required'>*</span> Required Field
			</div>

			<div id='inputrow'>
				<div class='title'>
					<span class='required'>*</span> <span class='white'>User Name</span>
				</div>
				<div class='right'>
					<div class='data'>
						<?php
                                                $data = array(
                                                    'name'        => 'username',
                                                    'size'        => '30',
                                                    'autocomplete'       => 'off'
                                                );

                                                echo form_input($data, set_value('username', '')); ?>
					</div>
				</div>
			</div>
			<br />
			<div id='details'>Valid characters: A-Z, a-z, 0-9, space ( ), underscore (_), dash (-)</div>

			<div id='inputrow'>
				<div class='title'>
					<span class='required'>*</span> <span class='white'>Email</span>
				</div>
				<div class='right'>
					<div class='data'>
                                                <?php
                                                $data = array(
                                                    'name'        => 'email',
                                                    'size'        => '30',
                                                    'autocomplete'       => 'off'
                                                );

                                                echo form_input($data, set_value('email', '')); ?>
					</div>
				</div>
			</div>
			<br />

			<div id='inputrow'>
				<div class='title'>
					<span class='required'>*</span> <span class='white'>Password</span>
				</div>
				<div class='right'>
					<div class='data'>
						 <?php
                                                $data = array(
                                                    'name'        => 'password',
                                                    'size'        => '30',
                                                    'autocomplete'       => 'off'
                                                );

                                                echo form_password($data, ''); ?>
					</div>
				</div>
			</div>
			<br />
			<div id='details'>Must be at least 8 characters long</div>

			<div id='inputrow'>
				<div class='title'>
					<span class='required'>*</span> <span class='white'>Re-type Password</span>
				</div>
				<div class='right'>
					<div class='data'>
						 <?php
                                                $data = array(
                                                    'name'        => 'password_confirmation',
                                                    'size'        => '30',
                                                    'autocomplete'       => 'off'
                                                );

                                                echo form_password($data, ''); ?>
					</div>
				</div>
			</div>
			<br />

			<div id='inputrow'>
				<div class='title'>
					<span class='required'>*</span> <span class='white'>Timezone</span>
				</div>
				<div class='right'>
					<div class='data'>
				<?php echo timezone_menu(set_value('timezone', $this->ClanCMS->get_setting('default_timezone')), 'select', 'timezone'); ?>
					</div>
				</div>
			</div>
			<br />
			
			<div id='inputrow'>
				<div class='title'>
					<span class='required'>*</span> <span class='white'>Daylight Savings</span>
				</div>
				<div class='right'>
					<div class='data'>
				<?php 
				$options = array(
					'2'		=> 'Automatically Detect',
					'1'		=> 'Yes',
					'0'		=> 'No'
				);

				echo form_dropdown('daylight_savings', $options, set_value('daylight_savings'), 'class="select"'); ?>
					</div>
				</div>
			</div>
			<br />
				
			<p>
		<?php
                    $data = array(
                        'name'      => 'step3',
                        'class'     => 'button'
                    );
                    echo form_submit($data, 'Finish: Installation Completed!'); ?>
                    <?php echo br(2); ?>
			</p>
		</div>
		<div id="footer"></div>
	</div>
<?php echo form_close(); ?>
<?php $this->load->view('install/footer'); ?>
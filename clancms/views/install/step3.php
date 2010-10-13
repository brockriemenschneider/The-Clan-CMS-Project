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

	<?php if($this->session->userdata('error')): ?>
        <div class="ui-widget">
            <div id="error" class="ui-state-error ui-corner-all">
		<p><?php echo $this->session->userdata('error'); ?></p>
            </div>
	</div>
    <?php echo br(); ?>
    <?php endif; ?>
	
	<div id='box'>

            <div id='header'>
                <div class='title'>Step 3: Site Information</div>
            </div>

            <div id='subheader'>
                <div class='title'>Site Settings</div>
            </div>

            <div id='middle'>
			<div class='required-field'>
				<span class='required'>*</span> Required Field
			</div>

			<div id='inputrow'>
				<div class='title'>
					<span class='required'>*</span> <span class='white'>Clan Name</span>
				</div>
				<div class='right'>
					<div class='data'>
						<?php
                                                $data = array(
                                                    'name'        => 'clan_name',
                                                    'size'        => '30',
                                                    'autocomplete'       => 'off'
                                                );

                                                echo form_input($data, set_value('clan_name', '')); ?>
					</div>
				</div>
			</div>
			<br />
			<div id='details'>Put your clan name here.</div>

			<div id='inputrow'>
				<div class='title'>
					<span class='required'>*</span> <span class='white'>Site Link</span>
				</div>
				<div class='right'>
					<div class='data'>
                                                <?php
                                                $data = array(
                                                    'name'        => 'site_link',
                                                    'size'        => '30',
                                                    'autocomplete'       => 'off'
                                                );

                                                echo form_input($data, set_value('site_link', '')); ?>
					</div>
				</div>
			</div>
			<br />
			<div id='details'>The link to your Clan CMS installation (http://xcelgaming.com/)</div>

			<div id='inputrow'>
				<div class='title'>
					<span class='required'>*</span> <span class='white'>Site Email</span>
				</div>
				<div class='right'>
					<div class='data'>
						 <?php
                                                $data = array(
                                                    'name'        => 'site_email',
                                                    'size'        => '30',
                                                    'autocomplete'       => 'off'
                                                );

                                                echo form_input($data, set_value('site_email', '')); ?>
					</div>
				</div>
			</div>
			<br />
			<div id='details'>The main email used to contact users (noreply@xcelgaming.com)</div>

			<div id='inputrow'>
				<div class='title'>
					<span class='required'>*</span> <span class='white'>Default Timezone</span>
				</div>
				<div class='right'>
					<div class='data'>
						<?php echo timezone_menu(set_value('timezone', 'UM5'), 'select', 'timezone'); ?>
					</div>
				</div>
			</div>
			<br />
			<div id='details'>Default is set to EST (UTC -5:00)</div>

			<div id='inputrow'>
				<div class='title'>
					<span class='required'>*</span> <span class='white'>Daylight Savings</span>
				</div>
				<div class='right'>
					<div class='data'>
						<?php 
							$options = array(
								'1'		=> 'Yes',
								'0'		=> 'No'
							);

						echo form_dropdown('daylight_savings', $options, set_value('daylight_savings'), 'class="select"'); ?>
				</div>
				</div>
			</div>
			<br />
			<div id='details'></div>
			
			<p>
		<?php
                    $data = array(
                        'name'      => 'step3',
                        'class'     => 'button'
                    );
                    echo form_submit($data, 'Step 4: Account Registration'); ?>
                    <?php echo br(2); ?>
			</p>
		</div>
		<div id="footer"></div>
	</div>
<?php echo form_close(); ?>
<?php $this->load->view('install/footer'); ?>
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
                <div class='title'>Step 2: Database Connection</div>
            </div>

            <div id='subheader'>
                <div class='title'>Database Information</div>
            </div>

            <div id='middle'>
			<div class='required-field'>
				<span class='required'>*</span> Required Field
			</div>

                    <div id='inputrow'>
				<div class='title'>
					 <span class='white'>Database Prefix</span>
				</div>
				<div class='right'>
					<div class='data'>
						<?php
                                                $data = array(
                                                    'name'        => 'dbprefix',
                                                    'size'        => '30',
                                                    'autocomplete'       => 'off'
                                                );

                                                echo form_input($data, set_value('dbprefix', 'ClanCMS_')); ?>
					</div>
				</div>
			</div>
			<br />
			<div id='details'>This makes sure there are no conflicts with other database tables</div>

			<div id='inputrow'>
				<div class='title'>
					<span class='required'>*</span> <span class='white'>Database Host</span>
				</div>
				<div class='right'>
					<div class='data'>
						<?php
                                                $data = array(
                                                    'name'        => 'hostname',
                                                    'size'        => '30',
                                                    'autocomplete'       => 'off'
                                                );

                                                echo form_input($data, set_value('hostname', 'localhost')); ?>
					</div>
				</div>
			</div>
			<br />
			<div id='details'>This is usually localhost</div>

			<div id='inputrow'>
				<div class='title'>
					<span class='required'>*</span> <span class='white'>Database Name</span>
				</div>
				<div class='right'>
					<div class='data'>
                                                <?php
                                                $data = array(
                                                    'name'        => 'database',
                                                    'size'        => '30',
                                                    'autocomplete'       => 'off'
                                                );

                                                echo form_input($data, set_value('database', '')); ?>
					</div>
				</div>
			</div>
			<br />
			<div id='inputrow'>
                                <div class='title'>
					<span class='white'>Create Database</span>
				</div>
				<div class='right'>
					<div class='data'>
						<input type="checkbox" name="create_database" value="1" <?php echo set_checkbox('create_database', '1'); ?> /> (You might need to do this yourself)
					</div>
				</div>
			</div>
			<br />

			<div id='inputrow'>
				<div class='title'>
					<span class='required'>*</span> <span class='white'>Database Username</span>
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

			<div id='inputrow'>
				<div class='title'>
					<span class='required'>*</span> <span class='white'>Database Password</span>
				</div>
				<div class='right'>
					<div class='data'>
						 <?php
                                                $data = array(
                                                    'name'        => 'password',
                                                    'size'        => '30',
                                                    'autocomplete'       => 'off'
                                                );

                                                echo form_password($data, set_value('password', '')); ?>
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
                    echo form_submit($data, 'Step 3: Site Information'); ?>
                    <?php echo br(2); ?>
			</p>
		</div>
		<div id="footer"></div>
	</div>
<?php echo form_close(); ?>
<?php $this->load->view('install/footer'); ?>
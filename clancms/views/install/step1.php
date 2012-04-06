<?php $this->load->view('install/header'); ?>

<?php echo form_open("install/index"); ?>
<div id="main">
	
	<div class="box">
		
		<div class="header">
			<?php echo heading('Step 1: Welcome to Clan CMS', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
                <p>
                    Welcome to the installation guide for Clan CMS brought to you by <a href="http://www.xcelgaming.com/" target="_blank">Xcel Gaming</a>. If you have any questions on how to install please read the <?php echo anchor('../readme.txt', 'readme', array('target' => '_blank')); ?> file located
                    in this folder. If you are still having issues please look on the <a href="http://www.xcelgaming.com/forums/" target="_blank">forums</a> for additional support.
                </p>
                <p>
                    Clan CMS consists of 5 easy steps to get you up in running in a short amount of time. Just follow the steps and fill out the information required and you will have a fully functional Clan CMS up
                    before you know it. Click Step 2 to continue with the installation process.
                </p>
                <p>
                    Thank you for choosing <a href="http://www.xcelgaming.com/" target="_blank">Xcel Gaming</a> and we hope you enjoy Clan CMS!
                </p>
                <p>
                    <?php 
					$data = array(
						'name'		=> 'step2',
						'class'		=> 'submit',
						'value'		=> 'Step 2: Database Connection'
					);
				
					echo form_submit($data); ?>
				
					<div class="clear"></div>
                </p>
            </div>
		</div>
		<div class="footer"></div>
	</div>
	
</div>
<?php echo form_close(); ?>

<?php $this->load->view('install/footer'); ?>
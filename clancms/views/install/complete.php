<?php $this->load->view('install/header'); ?>

<?php echo form_open("install/complete"); ?>
<div id="main">
	
	<div class="box">
		
		<div class="header">
			<?php echo heading('Finish: Installation Complete', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
                <p>
                    Congratulations you have successfully completed the Clan CMS installation! What should you do next?
                </p>
                <p>
                   First of all you need to delete the install directory to make sure no one else can access the installation guide. 
				   Then click on the Admin CP link below to navigate to the Admin CP and start adding your team's information, add your own personal theme, 
				   etc to make your Clan CMS unique and stand out.
                </p>
                <p>
                    Thank you for choosing <a href="http://www.xcelgaming.com/" target="_blank">Xcel Gaming</a> and we hope you enjoy Clan CMS!
                </p>
					<?php 
					$data = array(
						'name'		=> 'complete',
						'class'		=> 'submit',
						'value'		=> 'Continue to the Admin CP'
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
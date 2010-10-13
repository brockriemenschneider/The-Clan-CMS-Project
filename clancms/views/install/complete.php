<?php $this->load->view('install/header'); ?>
    <?php echo form_open("install/step1"); ?>
	<div id="box">
            <div id="header">
                <div class="title">Finish: Installation Complete</div>
            </div>
            <div id="middle">
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
                <p>
                    <a href="../admincp" class="button">Continue to the Admin CP</a>
                    <?php echo br(2); ?>
                </p>
            </div>
            <div id="footer"></div>
	</div>
    <?php echo form_close(); ?>
<?php $this->load->view('install/footer'); ?>
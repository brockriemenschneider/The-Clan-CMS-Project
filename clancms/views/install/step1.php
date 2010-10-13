<?php $this->load->view('install/header'); ?>
    <?php echo form_open("install/step1"); ?>
	<div id="box">
            <div id="header">
                <div class="title">Step 1: Welcome to Clan CMS</div>
            </div>
            <div id="middle">
                <p>
                    Welcome to the installation guide for Clan CMS brought to you by <a href="http://www.xcelgaming.com/" target="_blank">Xcel Gaming</a>. If you have any questions on how to install please read the <a href="../readme.txt" target="_blank">readme</a> file located
                    in this folder. If you are still having issues please look on the <a href="http://www.xcelgaming.com/forums/" target="_blank">forums</a> for additional support.
                </p>
                <p>
                    Clan CMS consists of 4 easy steps to get you up in running in a short amount of time. Just follow the steps and fill out the information required and you will have a fully functional Clan CMS up
                    before you know it. Click Step 2 to continue with the installation process.
                </p>
                <p>
                    Thank you for choosing <a href="http://www.xcelgaming.com/" target="_blank">Xcel Gaming</a> and we hope you enjoy Clan CMS!
                </p>
                <p>
                    <a href="step2" class="button">Step 2: Database Connection</a>
                    <?php echo br(2); ?>
                </p>
            </div>
            <div id="footer"></div>
	</div>
    <?php echo form_close(); ?>
<?php $this->load->view('install/footer'); ?>
<html>
    <head>
        <?php echo doctype(); ?> 
	<title>Xcel Gaming - Clan CMS Installation</title>
    <link href="../favicon.ico" rel="shortcut icon" type="image/ico" />
    <link href="../clancms/views/install/css/style.css" rel="stylesheet" type="text/css" />  
    <link href="../clancms/views/install/css/custom-theme/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" /> 
	<script type="text/javascript" src="../clancms/views/install/js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="../clancms/views/install/js/jquery-ui-1.8.2.custom.min.js"></script> 
	<script type="text/javascript">
    $(function(){
        $("#steps").buttonset();

		$(".steps").button({
                    disabled: true
		});

		$("a.button").button();
		$("input:submit").button();
    });
	</script>
    </head>
    <body>
        <a href="../install/"><img src="../clancms/views/install/images/logo.png" alt="Installation Guide"></a><?php echo br(2); ?>
	<div id="steps">
            <input type="radio" id="step1" name="radio" <?php if($this->uri->segment(2, '') == '' OR $this->uri->segment(2, '') == 'index'): echo 'checked="checked"'; else: echo 'class="steps"'; endif; ?> /><label for="step1">Step 1: Welcome to Clan CMS</label>
            <input type="radio" id="step2" name="radio" <?php echo $this->uri->segment(2, '') == 'step2' ? 'checked="checked"' : 'class="steps"'?> /><label for="step2">Step 2: Database Connection</label>
            <input type="radio" id="step3" name="radio" <?php echo $this->uri->segment(2, '') == 'step3' ? 'checked="checked"' : 'class="steps"'?> /><label for="step3">Step 3: Site Information</label>
            <input type="radio" id="step4" name="radio" <?php echo $this->uri->segment(2, '') == 'step4' ? 'checked="checked"' : 'class="steps"'?> /><label for="step4">Step 4: Account Registration</label>
            <input type="radio" id="complete" name="radio" <?php echo $this->uri->segment(2, '') == 'complete' ? 'checked="checked"' : 'class="steps"'?> /><label for="complete">Finish: Installation Completed!</label>
	</div>
	<?php echo br(); ?>
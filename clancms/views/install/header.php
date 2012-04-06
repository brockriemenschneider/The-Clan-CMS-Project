<html>
    <head>
        <?php echo doctype(); ?> 
	<title>Xcel Gaming - Clan CMS Installation</title>
	<?php echo link_tag('favicon.ico', 'shortcut icon', 'image/ico'); ?>
	<?php echo link_tag('clancms/views/install/style.css'); ?>
	<?php echo link_tag('clancms/views/install/js/jquery-ui-1.8.2.custom.css'); ?>
	<script type="text/javascript" src="<?php echo base_url(); ?>clancms/views/install/js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>clancms/views/install/js/jquery-ui-1.8.2.custom.min.js"></script> 
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
        <?php echo anchor('install/index', img(array('src' => 'clancms/views/install/images/logo.png', 'alt' => 'Installation Guide', 'title' => 'Installation Guide'))); ?><br /><br />
	<div id="steps">
            <input type="radio" id="step1" name="radio" <?php if($this->uri->segment(2, '') == '' OR $this->uri->segment(2, '') == 'index'): echo 'checked="checked"'; else: echo 'class="steps"'; endif; ?> /><label for="step1">Welcome to Clan CMS</label>		
            <input type="radio" id="step2" name="radio" <?php echo $this->uri->segment(2, '') == 'step2' ? 'checked="checked"' : 'class="steps"'?> /><label for="step2">Database Connection</label>
            <input type="radio" id="step3" name="radio" <?php echo $this->uri->segment(2, '') == 'step3' ? 'checked="checked"' : 'class="steps"'?> /><label for="step3">Check Requirements</label>
			<input type="radio" id="step4" name="radio" <?php echo $this->uri->segment(2, '') == 'step4' ? 'checked="checked"' : 'class="steps"'?> /><label for="step4">Site Information</label>
            <input type="radio" id="step5" name="radio" <?php echo $this->uri->segment(2, '') == 'step5' ? 'checked="checked"' : 'class="steps"'?> /><label for="step5">Account Registration</label>
            <input type="radio" id="complete" name="radio" <?php echo $this->uri->segment(2, '') == 'complete' ? 'checked="checked"' : 'class="steps"'?> /><label for="complete">Installation Completed!</label>
	</div>
	<br />
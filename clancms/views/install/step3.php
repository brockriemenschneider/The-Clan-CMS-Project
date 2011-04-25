<?php $this->load->view('install/header'); ?>

<?php echo form_open('install/step3'); ?>
<div id="main">
	
	<div class="box">
		
		<div class="header">
			<?php echo heading('Step 3: Check Requirements', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
				
				<?php if(validation_errors()): ?>
				<div class="alert">
					<?php echo validation_errors(); ?>
				</div>
				<?php endif; ?>
				
				<?php if($this->session->userdata('message')): ?>
				<div class="alert">
					<?php echo $this->session->userdata('message'); ?>
				</div>
				<?php endif; ?>
				
				<div class="required-field required">Required Field</div>
				<?php echo br(); ?>
				<div class="subheader">
						<?php echo heading('Mandatory', 4); ?>
				</div>
				
				<div class="label required">PHP Settings:</div>
				<div class="details <?php if((bool) $php_test): echo 'green'; else: echo 'red'; endif; ?>"><?php if((bool) $php_test): echo img(array('src' => 'clancms/views/install/images/check.png')); else: echo img(array('src' => 'clancms/views/install/images/exclamation.png')); endif; ?> Your server is currently running version <i><?php echo $php_version; ?></i></div>
				<div class="description">Clan CMS requires PHP version 5.1.6 or higher.</div>
				
				<div class="label required">MySQL Settings:</div>
				<div class="details <?php if((bool) $mysql_server_test): echo 'green'; else: echo 'red'; endif; ?>"><?php if((bool) $mysql_server_test): echo img(array('src' => 'clancms/views/install/images/check.png')); else: echo img(array('src' => 'clancms/views/install/images/exclamation.png')); endif; ?> Your server is currently running version <i><?php echo $mysql_server_version; ?></i><br /><div class="<?php if((bool) $mysql_client_test): echo 'green'; else: echo 'red'; endif; ?>"><?php if((bool) $mysql_client_test): echo img(array('src' => 'clancms/views/install/images/check.png')); else: echo img(array('src' => 'clancms/views/install/images/exclamation.png')); endif; ?> Your client is currently running version <i><?php echo $mysql_client_version; ?></i></div></div>
				<div class="description">Clan CMS requires access to a MySQL database running version 5.0 or higher.</div>
				
				<?php echo br(); ?>
				<div class="subheader">
						<?php echo heading('Recommended', 4); ?>
				</div>
				
				<div class="label">GD Settings:</div>
				<div class="details <?php if((bool) $gd_test): echo 'green'; else: echo 'red'; endif; ?>"><?php if((bool) $gd_test): echo img(array('src' => 'clancms/views/install/images/check.png')); else: echo img(array('src' => 'clancms/views/install/images/exclamation.png')); endif; ?> Your server is currently running version <i><?php echo $gd_version; ?></i></div>
				<div class="description">Clan CMS requires GD library 1.0 or higher to manipulate images.</div>
				
				
				<div class="label">ZLib:</div>
				<div class="details green"><?php if((bool) $zlib_test): echo img(array('src' => 'clancms/views/install/images/check.png')) . ' Your server has the zlib extension'; else: echo img(array('src' => 'clancms/views/install/images/exclamation.png')) . ' Your server does not have the zlib extension'; endif; ?></div>
				<div class="description">Clan CMS requires Zlib in order to unzip and install updates, themes, and widgets.</div>
				
				<?php echo br(); ?>
				<div class="subheader">
						<?php echo heading('Folder Permissions', 4); ?>
				</div>
				
				<?php foreach($directories as $directory): ?>
				<div class="label"><?php echo img(array('src' => 'clancms/views/install/images/folder.png')); ?></div>
				<div class="details"><?php echo $directory; ?><?php if((bool) $permissions['directories'][$directory]): echo img(array('src' => 'clancms/views/install/images/check.png')) . '<div class="green">Folder is Writeable</div>'; else: echo img(array('src' => 'clancms/views/install/images/exclamation.png')) . '<div class="red">Folder is not writeable! Please change the file permissions to 0777!</div>'; endif; ?></div>
				
				<?php echo br(3); ?>
				<?php endforeach; ?>
				
				<?php echo br(); ?>
				<div class="subheader">
						<?php echo heading('File Permissions', 4); ?>
				</div>
				
				<?php foreach($files as $file): ?>
				<div class="label"><?php echo img(array('src' => 'clancms/views/install/images/file.png')); ?></div>
				<div class="details"><?php echo $file; ?><?php if((bool) $permissions['files'][$file]): echo img(array('src' => 'clancms/views/install/images/check.png')) . '<div class="green">File is Writeable</div>'; else: echo img(array('src' => 'clancms/views/install/images/exclamation.png')) . '<div class="red">File is not writeable! Please change the file permissions to 0666!</div>'; endif; ?></div>
				<?php echo br(2); ?>
				<?php endforeach; ?>
				
				<?php echo br(); ?>
				<?php if($disabled): ?>
				<?php 
					$data = array(
						'name'		=> 'step3',
						'class'		=> 'submit',
						'value'		=> 'Step 4: Site Information',
						'disabled'	=> 'disabled'
					);
				
				echo form_submit($data); ?>
				<?php else: ?>
				<?php 
					$data = array(
						'name'		=> 'step4',
						'class'		=> 'submit',
						'value'		=> 'Step 4: Site Information'
					);
				
				echo form_submit($data); ?>
				<?php endif; ?>
				
				<div class="clear"></div>
	
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
</div>
<?php echo form_close(); ?>

<?php $this->load->view('install/footer'); ?>
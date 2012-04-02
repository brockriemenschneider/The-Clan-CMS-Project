<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">
	<div class="box">
		<div class="header"><?php echo heading('Accept Social Agreement', 4); ?></div>
		<div class="content">
			<div class="inside">
				<p>
					Before you can establish any social identities, you must affirm that any social IDs 
					you enter are your own.  You further accept to hold no liability against Xcel Gaming &copy;,  
					The ClanCMS Project &reg;, or <?php echo CLAN_NAME; ?>  for the use of said ID.  By 
					accepting this agreement, you are affirming you are the rightful owner of the social ID and 
					permit full use of it to <?php echo CLAN_NAME; ?> for the purposes of obtaining and 
					publishing any information that may be found and used within the confounds of this site.
					<?php echo br(); ?>
					<?php echo br(); ?>
					<?php echo CLAN_NAME; ?> <strong>will not</strong> use your information for any 
					purposes other than the retrieval of data through officially sanctioned APIs.  This includes 
					selling any information to third-parties.
					<?php echo br(); ?>
					<?php echo br(); ?>
					Do you affirm the user names and social IDs you will input are rightfully yours and do so freely?
				</p>
				<?php echo form_open('account/agree'); ?>
				<?php 
					$data = array(
						'name'		=> 'social_agree',
						'class'		=> 'submit',
						'value'		=> 'I Affirm'
					);
				
				echo form_submit($data); ?>
			<div class="clear"></div>
			</div>
		</div>
		<div class="footer"></div>
	</div>
	<div class="space"></div>
</div>

<?php $this->load->view(THEME . 'footer'); ?>
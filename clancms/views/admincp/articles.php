<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

 <script type="text/javascript">
	function deleteConfirm()
	{
    	var answer = confirm("Are you sure you want to delete this article? Once deleted, there will be no way to recover the article or it's comments!")
    	if (answer)
		{
        	document.messages.submit();
    	}
    
    	return false;  
	} 
</script> 

<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li <?php if($this->uri->segment(3, '') != 'drafts'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles', 'Published'); ?></span><span class="right"></span></li>
			<li <?php if($this->uri->segment(3, '') == 'drafts'): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/drafts', 'Drafts'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/add', 'Add News Article'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('News Articles', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
			
			<?php if($this->session->flashdata('message')): ?>
				<div class="alert">
					<?php echo $this->session->flashdata('message'); ?>
				</div>
				<?php echo br(); ?>
			<?php endif; ?>
		<table>
			<thead>
				<tr>
					<th width="25%">Title</th>
					<th width="15%"># Of Comments</th>
					<th width="20%">Author</th>
					<th width="25%">Date</th>
					<th width="15%">Actions</th>
				</tr>
			</thead>
			
			<tbody>
				<?php if($articles): ?>
				<?php foreach($articles as $article): ?>
				<tr <?php if($article->user_id == $this->session->userdata('user_id')): echo 'class="selected"'; endif; ?>>
					<td><?php echo anchor(ADMINCP . 'articles/edit/' . $article->article_id, $article->article_title); ?></td>
					<td><?php echo $article->total_comments; ?></td>
					<td><?php echo anchor(ADMINCP . 'users/edit/' . $article->user_id, $article->author); ?></td>
					<td><?php echo mdate("%M %d, %Y at %h:%i %a", $article->date); ?></td>
					<td><?php if(!(bool) $article->article_status): echo anchor(ADMINCP . 'articles/publish/' . $article->article_id, img(array('src' => ADMINCP_URL . 'images/publish.png', 'alt' => 'Publish')), array('title' => 'Publish')); endif; ?>
						<?php echo anchor(ADMINCP . 'articles/edit/' . $article->article_id, img(array('src' => ADMINCP_URL . 'images/edit.png', 'alt' => 'Edit')), array('title' => 'Edit')); ?>
						<?php echo anchor(ADMINCP . 'articles/delete/' . $article->article_id, img(array('src' => ADMINCP_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php else: ?>
				<tr>
					<td colspan="5">There are currently no <?php if($this->uri->segment(3, '') == ''): echo 'published'; else: echo 'draft'; endif; ?> articles. Click <?php echo anchor(ADMINCP . 'articles/add', 'Add News Article'); ?> to add one.</td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
	<div class="box">
		<div class="pages">
		<ul>
			<?php if($pages): ?>
			<?php if($this->uri->segment(3, '') == 'drafts'): $pages->drafts = 'drafts/'; else: $pages->drafts = ''; endif; ?>
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/' . $pages->drafts . 'page/' . $pages->current_page, 'Page ' . $pages->current_page . ' of ' . $pages->total_pages); ?></span><span class="right"></span></li>
					<?php if($pages->first): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/' . $pages->drafts . 'page/1', '<<'); ?></span><span class="right"></span></li><?php endif; ?>
					<?php if($pages->previous): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/' . $pages->drafts . 'page/' . ($pages->current_page - 1), '<'); ?></span><span class="right"></span></li><?php endif; ?>
				
				<?php if($pages->before): ?>
					<?php foreach($pages->before as $before): ?>
						<li <?php if($pages->current_page == $before): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/' . $pages->drafts . 'page/' . $before, $before); ?></span><span class="right"></span></li>
					<?php endforeach; ?>
				<?php endif; ?>
				
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/' . $pages->drafts . 'page/' . $pages->current_page, $pages->current_page); ?></span><span class="right"></span></li>
				
				<?php if($pages->after): ?>
					<?php foreach($pages->after as $after): ?>
						<li <?php if($pages->current_page == $after): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/' . $pages->drafts . 'page/' . $after, $after); ?></span><span class="right"></span></li>
					<?php endforeach; ?>
				<?php endif; ?>
				
					<?php if($pages->next): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/' . $pages->drafts . 'page/' . ($pages->current_page + 1), '>'); ?></span><span class="right"></span></li><?php endif; ?>
					<?php if($pages->last): ?><li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'articles/' . $pages->drafts . 'page/' . $pages->total_pages, '>>'); ?></span><span class="right"></span></li><?php endif; ?>
			<?php endif; ?>
		</ul>
		</div>
	</div>
</div>

<?php $this->load->view(ADMINCP . 'footer'); ?>
<?php if($pages): ?>
	<?php foreach($pages as $page): ?>
		<li <?php if($this->uri->segment(1) == 'page' && $this->uri->segment(2, '') == $page->page_slug): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor('page/' . $page->page_slug, $page->page_title); ?></span><span class="right"></span></li>
	<?php endforeach; ?>
<?php endif; ?>
	
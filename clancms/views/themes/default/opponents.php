<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>

<div id="main">
	
	<div class="box">
		<div class="tabs">
		<ul>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('oppoennts', 'Opponents'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Opponents', 4); ?>
		</div>
		<div class="content">
			<div class="inside">
			
		<table>
			<thead>
				<tr>
					<th width="35%">Opponent</th>
					<th width="10%">Tag</th>
					<th width="30%">Website</th>
					<th width="15%"># Of Matches</th>
					<th width="10%">View</th>
				</tr>
			</thead>
			
			<tbody>
				<?php if($opponents): ?>
				<?php foreach($opponents as $opponent): ?>
				<tr>
					<td><?php echo anchor('opponents/view/' . $opponent->opponent_slug, $opponent->opponent_title); ?></td>
					<td><?php if($opponent->opponent_tag): echo $opponent->opponent_tag; else: echo 'N/A'; endif; ?></td>
					<td><?php if($opponent->opponent_link): echo anchor($opponent->opponent_link, $opponent->opponent_link); else: echo 'N/A'; endif; ?></td>
					<td><?php echo $opponent->total_matches; ?></td>
					<td><?php echo anchor('opponents/view/' . $opponent->opponent_slug, img(array('src' => THEME_URL . 'images/view.png', 'alt' => 'View Opponent', 'title' => 'View Opponent'))); ?></td>
				</tr>
				<?php endforeach; ?>
				<?php else: ?>
				<tr>
					<td colspan="5">There are currently no opponents.</td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	
			</div>
		</div>
		<div class="footer"></div>
		
	</div>
	
	<?php if($opponents): ?>
	<div class="box">
		<div class="pages">
		<ul>
			<?php if($pages): ?>
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('opponents/page/' . $pages->current_page, 'Page ' . $pages->current_page . ' of ' . $pages->total_pages); ?></span><span class="right"></span></li>
					<?php if($pages->first): ?><li><span class="left"></span><span class="middle"><?php echo anchor('opponents/page/1', '<<'); ?></span><span class="right"></span></li><?php endif; ?>
					<?php if($pages->previous): ?><li><span class="left"></span><span class="middle"><?php echo anchor('opponents/page/' . ($pages->current_page - 1), '<'); ?></span><span class="right"></span></li><?php endif; ?>
				
				<?php if($pages->before): ?>
					<?php foreach($pages->before as $before): ?>
						<li <?php if($pages->current_page == $before): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor('opponents/page/' . $before, $before); ?></span><span class="right"></span></li>
					<?php endforeach; ?>
				<?php endif; ?>
				
				<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor('opponents/page/' . $pages->current_page, $pages->current_page); ?></span><span class="right"></span></li>
				
				<?php if($pages->after): ?>
					<?php foreach($pages->after as $after): ?>
						<li <?php if($pages->current_page == $after): echo 'class="selected"'; endif; ?>><span class="left"></span><span class="middle"><?php echo anchor('opponents/page/' . $after, $after); ?></span><span class="right"></span></li>
					<?php endforeach; ?>
				<?php endif; ?>
				
					<?php if($pages->next): ?><li><span class="left"></span><span class="middle"><?php echo anchor('opponents/page/' . ($pages->current_page + 1), '>'); ?></span><span class="right"></span></li><?php endif; ?>
					<?php if($pages->last): ?><li><span class="left"></span><span class="middle"><?php echo anchor('opponents/page/' . $pages->total_pages, '>>'); ?></span><span class="right"></span></li><?php endif; ?>
			<?php endif; ?>
		</ul>
		</div>
	</div>
	<?php endif; ?>
	
</div>

<?php $this->load->view(THEME . 'footer'); ?>
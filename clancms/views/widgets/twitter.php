<div class="item">
<?php if($tweets): ?>
	<ul id="tweets">
		<?php foreach($tweets->msg as $tweet): ?>
			<li class="tweet">
				<?php echo $tweet->text . br() . $tweet->date; ?>
				<div class="tweet_intent">
					<ul>
						<li><div class="reply"></div><?php echo anchor('https://twitter.com/intent/tweet?in_reply_to=' . $tweet->id, 'Reply'); ?></li>
						<li><div class="retweet"></div><?php echo anchor('https://twitter.com/intent/retweet?tweet_id=' . $tweet->id, 'Retweet'); ?></li>
						<li><div class="favorite"></div><?php echo anchor('https://twitter.com/intent/favorite?tweet_id=' . $tweet->id, 'Favorite'); ?></li>
					</ul>					
				</div>
			</li>
			<div class="separator"></div>
		<?php endforeach; ?>
	</ul>
<?php else: ?>
	<p>No Tweets yet :(</p>
<?php endif; ?>
</div>

<?php if(isset($tweeter)): ?>
<script type="text/javascript">
	twttr.anywhere(function (T) { T("#follow-placeholder").followButton("<?php echo $tweeter; ?>");});
</script>


<?php endif; ?>
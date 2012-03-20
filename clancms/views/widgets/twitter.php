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

<script type="text/javascript">
	twttr.anywhere(function (T) { T("#follow-placeholder").followButton('codezyne_me');});
</script>
<script type="text/javascript">
	twttr.anywhere(function (T) {T("#login").connectButton(); });
</script>
<script type="text/javascript">
	 jQuery(function () { twttr.anywhere(function (T) {if (T.isConnected()) {$("#login-logout").append("<button id="signout" type="button">Sign out of Twitter</button>");
	$("#signout").bind("click", function () {twttr.anywhere.signOut();});}else {T("#login-logout").connectButton(); } });});
</script>
<script type="text/javascript">
	YUI().use("node", function(Y) {Y.on("domready", function () { twttr.anywhere(function (T) {if (T.isConnected()) {Y.one("#login-logout").append('<button id="signout" type="button">Sign out of Twitter</button>');Y.one("#signout").on("click", function () { twttr.anywhere.signOut();});}else {T("#login-logout").connectButton(); }});});});
</script>

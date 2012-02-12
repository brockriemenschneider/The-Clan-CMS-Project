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
	twttr.anywhere(function (T) {T("#tbox").tweetBox({height: 100,width: 400,defaultContent: "<YOUR DEFAULT TWEETBOX CONTENT HERE>"});});
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

<style>
.item {
    margin: 0;
    padding: 0;
}
.item ul {
    list-style: none outside none;
    margin: 0;
    padding: 0;
}
 .separator{
    border-bottom: 1px dashed #444;
    margin: 5px 0;	
}
.tweet_intent {
    list-style: none;
    height: 20px;
}
.tweet_intent li {
    display: inline-block;
}
.tweet_intent .reply {
    background-position: 0 0;
}
.tweet_intent .reply:hover {
    cursor: pointer;
    background-position: -16px 0;
}
.tweet_intent .retweet {
    background-position: -81px 0px;
}
.tweet_intent .retweet:hover {
    background-position: -113px 0;
    cursor: pointer;
}
.tweet_intent .favorite {
    background-position: -32px 0;
}
.tweet_intent .favorite:hover {
    background-position: -65px 0;
    cursor: pointer;
}
.tweet_intent ul li div {
    width: 16px;
    float: left;
    margin: 0 5px 0 10px;
    height: 16px;
    background: url("./tweet_sprite.png") no-repeat scroll 0 0 transparent;
}
</style>
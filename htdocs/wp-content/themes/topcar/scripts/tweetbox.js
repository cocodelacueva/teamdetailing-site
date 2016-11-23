jQuery(document).ready(function($) {
	
	$('#tweetText').on({
		focus:function() {
			$('form#tweetUs').animate({'height':261},'fast');
		}, blur:function() {
			if($('#tweetText').val()=='') {
				$('form#tweetUs').animate({'height':91},'fast');
			}
		}, keyup:function() {
			var tweetVia = $('#sendTweet').attr('data-via');
			var tweetHashtag = $('#sendTweet').attr('data-hashtag');
			var tweetText=$('#tweetText').val(), tweetHref = 'https://twitter.com/intent/tweet?via=' + tweetVia + '&hashtags=' + tweetHashtag + '&text=' + tweetText;
			$('#sendTweet').attr('href',tweetHref);
			var tweetCharsRemaining = 114 - tweetText.length;
			$('#charsRemaining').text(tweetCharsRemaining);
		}
	});
	
});

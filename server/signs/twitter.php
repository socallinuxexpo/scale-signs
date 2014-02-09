<?php

function search_twitter()
{

	//require "TwitterSearch.phps";
	
    require_once('TwitterAPIExchange.php');

	/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
	$settings = array(
	    'oauth_access_token' => "14053355-Qs1Ak2XOeFJFUuogLC7Yc6gDRhTLxDmp88AhX8PYg",
	    'oauth_access_token_secret' => "3pR09a4ibPBDy8fy4dtkcmmQJKMJDn9UqWS4B7wQvyOl7",
	    'consumer_key' => "AykYbVCFhRml9KhO5jbQ",
	    'consumer_secret' => "g8fH1U56jFYJwCrLOYI0npye9rmhV02IuyCt8Yu6iQ"
	);

  // Any Twitter Accounts to Highlight
  $promote = array(
    "socallinuxexpo",
  );
  
  // Any to block from the signs
  $blacklist = array(
  );
	
	$url = 'https://api.twitter.com/1.1/search/tweets.json';
	$getfield = '?q=#scale12x';
	$requestMethod = 'GET';
	
	$twitter = new TwitterAPIExchange($settings);
	$response = $twitter->setGetfield($getfield)
	                    ->buildOauth($url, $requestMethod)
	                   ->performRequest();

	$results = json_decode($response, TRUE);

	$count = 0;
	
  print '<div class="item active">';
  foreach ($results['statuses'] as $status) {
		$logo = $status['user']['profile_image_url'];
		$name = $status['user']['name'];
		$screen_name = $status['user']['screen_name'];
		$comment = $status['text'];
		
		$created = date("F d, Y h:i a", strtotime($status->created_at));
		$rightnow = round(time() / 60);
		
		$time_diff = $rightnow - $created;

    if (in_array($user, $blacklist)) {
      continue;
    }
    
    if ($count % 3 == 0 && $count > 0) {
      print '</div>';
      print '<div class="item">';
    }

    if (in_array($user, $promote)) {    
      print '<div class="tweet tweetpromote media">';
    } else {
      print '<div class="tweet media">';
    }
	    
	  //  print "<div class=\"span8 tweetcomment\">$comment</div>";
  	//	print "<div class=\"tweet-time\">$created</div>";

    print '<a class="pull-left" href="#">';
      print "<img class='media-object' src=\"$logo\">";
    print '</a>';

    print '<div class="media-body'>
      print "<h3 class='media-heading'>$name</span> -- @$screen_name</h4>";
      print "<h4>$comment</h4>";
    print "</div>";

		$count += 1;

	}
  print '</div>';
}

?>

<div id="twitterCarousel" class="carousel carousel-fade">
  <div class="carousel-inner">	  
    <?php search_twitter(); ?>
  </div>
</div>

<script src="js/jquery-1.8.2.js"></script>    
<script src="js/jquery.marquee.js"></script>    
<script src="bootstrap/js/bootstrap.js"></script>
<script type="text/javascript">

  $(document).ready(function() {
      $('#twitterCarousel').carousel({
        interval: 10000
      });
  });
  
</script>

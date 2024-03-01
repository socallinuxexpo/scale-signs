<?php

date_default_timezone_set('America/Los_Angeles');

function search_twitter()
{

	//require "TwitterSearch.phps";
	
  require_once('TwitterAPIExchange.php');

  /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
  /** Need to update these values and move to env vars so they're not in codebase **/
	$settings = array(
	    'oauth_access_token'        => $_SERVER['TWITTER_OAUTH_ACCESS_TOKEN'],
	    'oauth_access_token_secret' => $_SERVER['TWITTER_OAUTH_ACCESS_TOKEN_SECRET'],
	    'consumer_key'              => $_SERVER['TWITTER_OAUTH_CONSUMER_KEY'],
	    'consumer_secret'           => $_SERVER['TWITTER_OAUTH_CONSUMER_SECRET']
	);

  // Any Twitter Accounts to Highlight
  $promote = array(
    "socallinuxexpo",
    "hridaybala",
    "irabinovitch"
  );
  
  // Any to block from the signs
  $blacklist = array(
  );
	
	$url = 'https://api.twitter.com/1.1/search/tweets.json';
	$getfield = '?q=#scale21x';
	$requestMethod = 'GET';
	
	$twitter = new TwitterAPIExchange($settings);
	$response = $twitter->setGetfield($getfield)
	                    ->buildOauth($url, $requestMethod)
	                   ->performRequest();

  $results = json_decode($response, TRUE);

	$count = 0;
	
  print '<div class="item active">';
 
  # ensure twitter response actually contains statuses
  # TODO: fix broken query due to upstream changes
  if (array_key_exists('statuses', $results)) {
    foreach ($results['statuses'] as $status) {
                  $logo = $status['user']['profile_image_url'];
                  $name = $status['user']['name'];
                  $screen_name = $status['user']['screen_name'];
                  $comment = $status['text'];
                  
                  $created = date("F d, Y h:i a", strtotime($status['created_at']));
                  $rightnow = round(time() / 60);
                  
                  $time_diff = $rightnow - $created;

      if (in_array($screen_name, $blacklist)) {
        continue;
      }

      if (strpos($comment, 'RT') !== FALSE && in_array($screen_name, $promote) !== TRUE) {
        continue;
      }
      
      if ($count % 3 == 0 && $count > 0) {
        print '</div>';
        print '<div class="item">';
      }

      if (in_array($screen_name, $promote)) {    
        print '<div class="tweet tweetpromote media">';
      } else {
        print '<div class="tweet media">';
      }
              
      print '<div class="vcard">';
      print '<a class="pull-left" href="#">';
        //print "<div class='tweet-pic'>";
        //    print "<img class='media-object' style=\"height: 48px; width: 48px;\" src=\"$logo\">";
        //print "</div>";
      print '</a>';
      print '</div>';

      print '<div class="hentry">';
          print '<div class="media-body'>
            print "<span class='media-heading'>$screen_name </span>";
            print "<span class=\"tweet-comment\">$comment</span>";
            print "<span class=\"tweet-time\">$created</span>";
          print "</div>";
      print "</div>";

          $count += 1;

    }
  }
  print '</div>';
}

?>

<div id="twitterCarousel" class="carousel carousel-fade">
  <div class="carousel-inner">	  
    <?php search_twitter(); ?>
  </div>
</div>

<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/jquery.marquee.js"></script>    
<script src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">

  $(document).ready(function() {
      $('#twitterCarousel').carousel({
        interval: 15000
      });
  });
  
</script>

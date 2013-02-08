<?php

function search_twitter()
{

	require "TwitterSearch.phps";
	
  // Any Twitter Accounts to Highlight
  $promote = array(
    "socallinuxexpo",
  );
  
  // Any to block from the signs
  $blacklist = array(
  );
	
	//$search = new TwitterSearch('#scale11x');
	$search = new TwitterSearch();
	$search->rpp(100);
	$search->with("#scale11x");
	$results = $search->results();
	
	$count = 0;
	
	//print_r($results);
	
  print '<div class="item active">';
	foreach ($results as $i => $value) {
	
	  $total_results = count($results);
		$logo = $value->profile_image_url;
		$user = $value->from_user;
		$user_name = $value->from_user_name;
		$comment = $value->text;
		
		$created = date("F d, Y h:i a", strtotime($value->created_at));
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
      print '<div class="tweet tweetpromote row-fluid">';
    } else {
      print '<div class="tweet row-fluid">';
    }
    //
    // Promote certain users
    //
      print "<!-- Begin TweetUserIcon -->";
      print '<div class="span4 tweetusericon">';
      
        print "<!-- Begin TweetIcon -->";
        print "<div class='span2 tweeticon'>";		  
	        print "<img class=\"img-rounded\" src=\"$logo\">";
	      print "</div>";
        print "<!-- End TweetIcon -->";
	              
	      print "<!-- Begin Tweet User -->";
		    print "<div class='span8 tweetuser'>";
		      print " <span class='tweetuser_name'>$user_name</span><br />@$user ";
	      print "</div>";
	      print "<!-- End Tweet User -->";
	    
	    print "</div>";
	    print "<!-- End Tweet User Icon -->";
	    
	    print "<div class=\"span8 tweetcomment\">$comment</div>";
  		print "<div class=\"tweet-time\">$created</div>";
		print '</div>';

    
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

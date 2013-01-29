<?php

function search_twitter()
{

	require "TwitterSearch.phps";
	
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
		$created = $value->created_at;

    if ($count % 4 == 0 && $count > 0) {
      print '</div>';
      print '<div class="item">';
    }
    
    print '<div class="tweet row-fluid">';
		  print '<div class="span4 tweetusericon">';
        print "<div class='span1 tweeticon'>";		  
	        print "<img class=\"img-rounded\" src=\"$logo\">";
	      print "</div>";
		    print "<div class='span2 tweetuser'>";
		      print " <span class='tweetuser_name'>$user_name</span><br />@$user ";
	      print "</div>";		    
	    print "</div>";
	    print "<div class=\"span8 tweetcomment\">$comment $created</div>";
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

<link href="bootstrap/css/bootstrap.css" rel="stylesheet">

<?php

#$xml = simplexml_load_file('http://scale10x.unbuilt.org/sign.xml');
$xml = simplexml_load_file('http://www.socallinuxexpo.org/scale11x/sign.xml');
#$xml = simplexml_load_file('sign.xml');

$starttime = mktime(0, 0, 0, 2, 22, 2013) / 60;

#$rightnow = round(time() / 60);
$rightnow = mktime(19, 0, 0, 2, 22, 2013) / 60;
$minsafter = $rightnow - $starttime;

$data = array();
$order = array();
$times = array();

$shorten_topics = array(
                        "BeginnerTutorials" => "Beginner Tutorials",
                        "CloudandVirtualization" => "Cloud and Virtualization",
                        "FileSystem" => "File System",
                        "OpenSourceSoftwareInEducation" => "OSSIE",                        
                        "SysAdmin" => "Sys Admin",
                        );

foreach ($xml->node AS $node) {

  // Remove HTML tags
  $node->{'Time'} = preg_replace('/<[^>]*>/', '', $node->{'Time'});
  $node->{'Day'} = preg_replace('/<[^>]*>/', '', $node->{'Day'});
  
  // Remove Spaces so we can use it for a CSS class
  $node->{'Topic'} = preg_replace('/\s+/', '', $node->{'Topic'});
  
	$pos = strpos((string) $node->{'Time'}, ",");
	$lpos = strrpos((string) $node->{'Time'}, ",");
	if ($pos === false) {
		$thistime = (string) $node->{'Time'};
		$thisend = (string) $node->{'Time'};
	} else {
		$thistime = substr((string) $node->{'Time'}, 0, $pos);
		$thisend = substr((string) $node->{'Time'}, $lpos + 2);
	}
	
	if ((string) $node->Speaker == "- -") {
		$name = '';
	} else {
		$name = (string) $node->Speaker;
	}
	$data[] = array((string) $node->Day, $thistime, $name, (string) $node->Title, (string) $node->Room, (string) $node->Topic);
	
	/*
	$realtime = explode(" ", $thistime);
	$realstime = explode(" ", $thisend);
	$handm = explode(":", $realtime[0]);
	if ($realtime[1] == "PM" && $handm[0] != "12") {
		$mfromm = (($handm[0] + 12) * 60) + $handm[1];
	} else {
		$mfromm = ($handm[0] * 60) + $handm[1];
	}
	$handme = explode(":", $realstime[0]);
	if ($realstime[1] == "PM" && $handme[0] != "12") {
		$mfromme = (($handme[0] + 12) * 60) + 60 + $handme[1];
	} else {
		$mfromme = ($handme[0] * 60) + 60 + $handme[1];
	}
	*/
	
	$realtime = $thistime;
	$realstime = $thisend;
	$handm = explode(":", $realtime);
	$handme = explode(":", $realstime);
	$mfromm = ($handm[0] * 60) + $handm[1];
	$mfromme = ($handme[0] * 60) + 60 + $handme[1];
	
	switch ((string) $node->Day) {
		case "Friday";
			$order[] = $mfromm;
			$times[] = array($mfromm, $mfromme);
			break;
		case "Saturday";
			$order[] = $mfromm + 1440;
			$times[] = array($mfromm + 1440, $mfromme + 1440);
			break;
		case "Sunday";
			$order[] = $mfromm + 2880;
			$times[] = array($mfromm + 2880, $mfromme + 2880);
			break;
		case "";
			$order[] = 0;
			$times[] = array(0, 0);
			break;
	}
}
asort($order, SORT_NUMERIC);

?>

	<style type="text/css" media="screen">
		font { font-family: Tahoma, Geneva, sans-serif; color:black; text-align:left; font-size:14px; }
	</style>
		  <div id="scheduleCarousel" class="carousel carousel-fade">
		    <div class="carousel-inner">	  
		      <div id="schedule-1-content" class="active item">
			    <table cellpadding=2 cellspacing=1 class="table table-bordered">
          <tr bgcolor="#fff"><th>Day</th><th>Start Time</th><th>Presenter</th><th>Topic</th><th>Room</th></tr>
		      <tbody>
    <?php 
      $topics = array();
      $items_per_page = 8;
      $odd = 0; $count = 0; $schedule_page = 1;
      foreach ($order AS $key => $value) {

	      if (($times[$key][0] - 60) <= $minsafter && ($times[$key][1]) >= $minsafter) {
	      //if (($times[$key][0] - 60) <= $minsafter && ($times[$key][1] + 10) >= $minsafter) {
	      // if ($times[$key][0] > 0) {
	      
          //
          // Check if the topic of the current talk is in the array
          // ..if not. add it.
          //
          if (! in_array($data[$key][5], $topics)) {
            $topics[] = $data[$key][5];
          }
	      
		      $odd++; 
		      if ( $odd % 2 == 0 ) { $color = "bgcolor=\"#d0e4fe\""; } else { $color="bgcolor=\"#fff\""; }
		      		      
		      if ( $count % $items_per_page == 0 && $count > 0) {
		        $schedule_page = $schedule_page + 1;
		        print "</table>";
		        print "</div>";
		        print "<div id=\"schedule-$schedule_page-content\" class=\"item\">";
			      print "<table cellpadding=2 cellspacing=1 class=\"table table-bordered\">";
			      print "<tr bgcolor='#fff'><th>Day</th><th>Start Time</th><th>Presenter</th><th>Topic</th><th>Room</th></tr>";
		      }
		      $count++; 

    ?>
				    <tr class="<?php echo $data[$key][5]; ?>" <?php echo "$color"; ?> >
				      <!-- Day -->
				      <td> <i class="icon-calendar"></i> 
				        <span> 
				          <!-- <?php echo strtoupper(substr($data[$key][0], 0, 3)) ?>  -->
				          <?php echo $data[$key][0]; ?> 
			          </span> 
		          </td>
				      
				      <!-- Time -->
				      <?php
				        // Convert to human friendly format
                $talk_time = date("h:i A", strtotime($data[$key][1]));
			        ?>
					    <td width="12%">
					      <i class="icon-time"></i>
					      <span>
					      <?php if ($times[$key][0] <= $minsafter) { echo "In-Progress"; }
						    else { echo $talk_time; } ?>
						    </span>
					    </td>
					    
				      <!-- Presenter -->
				      <?php
				        if ( strlen($data[$key][2]) >= 20 ) { 
                  $speakerName = substr($data[$key][2], 0, 20) . "...";
  					    } else {
  					      $speakerName = $data[$key][2];
					      }
  					    
					    ?>
					    <td class="schedulePresenter"> <i class="icon-user"></i> <span> <?php echo $speakerName; ?> </span></td>
					    
					    <!-- Topic -->
					    <?php 
					      if ( strlen($data[$key][3]) >= 50 ) {
					        $talk_title = substr($data[$key][3], 0, 50) . "...";
					      } else {
					        $talk_title = $data[$key][3];					      
					      }

				      ?>
					    <td> <i class="icon-bullhorn"></i> <span> <?php echo $talk_title; ?> </span></td>
					    
					    <!-- Room -->
					    <td width="15%"> <i class="icon-info-sign"></i> 
					    <?php 
					      if ( $data[$key][3] == "Game Night" ) {
					        echo "Plaza Ballroom";
					      } else {
					        echo $data[$key][4];
				        }
				      ?>
				      </td>
				    </tr>
    <?php
    
    }
    }
    if ( $count < ($schedule_page * $items_per_page) ) {
      $filler = ($schedule_page * $items_per_page) - $count;
      for ($i = 0; $i < $filler; $i++) {
        print "<tr bgcolor='#fff'><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
      }
    }    
    ?>
			    </table>
			    </div>
			  </div>
			</div>
			
            <div class="span12 topicList" style="text-align:center;">
			<!-- <ul class="thumbnails topicList"> -->
			    <?php foreach ($topics as $topic) {
			            if ( array_key_exists($topic, $shorten_topics) ) {
                    print "<span class=\"badge $topic\">{$shorten_topics[$topic]}</span>";			            
			            } else {
                    print "<span class=\"badge $topic\">$topic</span>";
			            }
			    }
			    ?>
			<!-- </ul> -->
            </div>

<script src="js/jquery-1.8.2.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
<script type="text/javascript">

  $(document).ready(function() {
    $('#scheduleCarousel').carousel({
      interval: 10000,
    });
  });

</script>


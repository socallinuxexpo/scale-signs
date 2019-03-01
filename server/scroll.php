<?php

date_default_timezone_set('America/Los_Angeles');

# set yearly (change if DST starts during SCaLE)

# before "spring forward"
$starttime = mktime(0, 0, 0, 3, 7, 2019) / 60;

# after "spring forward"
#$starttime = mktime(23, 0, 0, 3, 6, 2019) / 60;

include 'ChromePhp.php';

$url = 'http://www.socallinuxexpo.org/scale/17x/sign.xml';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$xmlresponse = curl_exec($ch);
$xml = simplexml_load_string($xmlresponse);



#if (!empty($_GET["year"]) && !empty($_GET["month"]) && !empty($_GET["day"]) && !empty($_GET["hour"]) && !empty($_GET["minute"])) {
if (!empty($_GET["year"]) && !empty($_GET["month"]) && !empty($_GET["day"])) {
    $year = $_GET['year'];
    $month = $_GET['month'];
    $day = $_GET['day'];
    $hour = $_GET['hour'];
    $minute = $_GET['minute'];
    $rightnow = round(mktime($hour, $minute, 0, $month, $day, $year) / 60);
} else {
    $rightnow = round(time() / 60);
}
$minsafter = $rightnow - $starttime;

$data = array();
$order = array();
$times = array();

$shorten_topics = array(
	"BeginnerTutorials"						=>	"Beginner Tutorials",
	"BoFs"												=>	"BoFs",
	"Cloud"												=>	"Cloud",
	"ContainerandVirtualization"	=>	"Container",
	"Developer"										=>	"Developer",
	"DevOps"											=>	"DevOps",
	"Embedded"										=>	"Embedded",
	"General"											=>	"General",
	"HAMRadio"										=>	"HAM Radio",
	"Keynote"											=>	"Keynote",
	"Kubeflow"										=>	"Kubeflow",
	"LibreGraphics"								=>	"LibreGraphics",
	"Mentoring"										=>	"Mentoring",
	"MySQL"												=>	"MySQL",
	"NextGeneration"							=>	"Next Generation",
	"Observability"								=>	"Observability",
	"OpenData"										=>	"Open Data",
	"OpenGovernment"							=>	"Open Government",
	"OpenSourceinEnterprises"			=>	"Open Source in Enterprises",
	"openSUSE"										=>	"openSUSE",
	"PosgreSQL"										=>	"PostgreSQL",
	"Security"										=>	"Security",
	"Sponsored"										=>	"Sponsored",
	"SysAdmin"										=>	"SysAdmin",
	"Ubucon"											=>	"Ubucon",
	"UpSCALE"											=>	"UpSCALE",
);

foreach ($xml->node AS $node) {

  // Remove HTML tags
  $node->{'Time'} = preg_replace('/<[^>]*>/', '', $node->{'Time'});
  $node->{'Day'} = preg_replace('/<[^>]*>/', '', $node->{'Day'});
  
  // Remove Spaces so we can use it for a CSS class
  $node->{'Topic'} = preg_replace('/\s+/', '', $node->{'Topic'});
  $node->{'Topic'} = preg_replace('/\&/', 'and', $node->{'Topic'});

	$pos = strpos((string) $node->{'Time'}, ",");
	$lpos = strrpos((string) $node->{'Time'}, ",");
	if ($pos === false) {
		$thistime = (string) $node->{'Time'};
		$thisend = (string) $node->{'Time'};
	} else {
		$thistime = substr((string) $node->{'Time'}, 0, $pos);
		$thisend = substr((string) $node->{'Time'}, $lpos + 2);
	}

	if ((string) $node->Speakers == "- -") {
		$name = '';
	} else {
		$name = (string) $node->Speakers;
	}
	$title = (string) $node->Title;
	$data[] = array((string) $node->Day, $thistime, $name, (string) $node->Title, (string) $node->Room, (string) $node->Topic, (string) $node->Overflow);

		
	$realtime = explode(' to ', $thistime)[0];
	$realstime = explode(' to ', $thisend)[1];
	$handm = explode(":", $realtime);
	$handme = explode(":", $realstime);
	$mfromm = ($handm[0] * 60) + $handm[1];
	$mfromme = ($handme[0] * 60) + $handme[1];
	

	echo($node);
	switch ((string) $node->Day) {
		case "Thursday";
			$order[] = $mfromm;
			$times[] = array($mfromm, $mfromme);
			break;
		case "Friday";
			$order[] = $mfromm + 1440;
			$times[] = array($mfromm + 1440, $mfromme + 1440);
			break;
		case "Saturday";
			$order[] = $mfromm + 2880;
			$times[] = array($mfromm + 2880, $mfromme + 2880);
			break;
		case "Sunday";
			$order[] = $mfromm + 4320;
			$times[] = array($mfromm + 4320, $mfromme + 4320);
			break;
		case "";
			$order[] = 0;
			$times[] = array(0, 0);
			break;
	}
  $order_current = end($order);
  $times_current = end($times);
}
//asort($order, SORT_NUMERIC);

?>

	<style type="text/css" media="screen">
		font { font-family: Tahoma, Geneva, sans-serif; color:black; text-align:left; font-size:14px; }
	</style>
		  <div id="scheduleCarousel" class="carousel carousel-fade">
		    <div class="carousel-inner">	  
		      <div id="schedule-1-content" class="active item">
			    <table cellpadding=2 cellspacing=1 class="table table-bordered">
                <tr bgcolor="#fff"><th>Time</th><th>Presenter</th><th>Topic</th><th>Room</th></tr>
                <tbody>
    <?php 
      $topics = array();
      $items_per_page = 6;
      $odd = 0; $count = 0; $schedule_page = 1;
      foreach ($order AS $key => $value) {

	      if (($times[$key][0] - 60) <= $minsafter && ($times[$key][1]) >= $minsafter) {
	      // if (($times[$key][0] - 60) <= $minsafter && ($times[$key][1] + 10) >= $minsafter) {
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
			    print "<tr bgcolor='#fff'><th>Time</th><th>Presenter</th><th>Topic</th><th>Room</th></tr>";
		      }
		      $count++; 

    ?>
				    <tr class="<?php echo $data[$key][5]; ?>" <?php echo "$color"; ?> >
				      <!-- Day -->
                      <!--
				      <td> <i class="icon-calendar"></i> 
				        <span> 
				          <?php echo $data[$key][0]; ?> 
			          </span> 
		              </td>
                      -->
				      
				      <!-- Time -->
				      <?php
				        // Convert to human friendly format
                        //$talk_time = date("h:i A", strtotime($data[$key][1]));
                        $talk_time = $data[$key][1];
                        list($start_time, $end_time) = split(" to ", $talk_time, 2);
                        $start_time = date("h:i a", strtotime($start_time));
                        $end_time = date("h:i a", strtotime($end_time));


                        ?>
					    <td width="20%">
					      <i class="icon-time"></i>
					      <span>
					      <?php
                            if ($times[$key][0] <= $minsafter) {
                                echo "In-Progress until $end_time";
                            } else {
                                echo "$start_time to $end_time";
                            }
                          ?>
						  </span>
					    </td>
					    
				      <!-- Presenter -->
				      <?php
				        if ( strlen($data[$key][2]) >= 45 ) { 
                            $speakerName = substr($data[$key][2], 0, 45) . "...";
  					    } else {
                            $speakerName = $data[$key][2];
                        }
  					    
					    ?>
					    <td class="schedulePresenter"> <i class="icon-user"></i> <span> <?php echo $speakerName; ?> </span></td>
					    
					    <!-- Topic -->
					    <?php 
					      if ( strlen($data[$key][3]) >= 90 ) {
					        $talk_title = substr($data[$key][3], 0, 90) . "...";
					      } else {
					        $talk_title = $data[$key][3];					      
					      }

				      ?>
					    <td> <i class="icon-bullhorn"></i> <span> <?php echo $talk_title; ?> </span></td>
					    
					    <!-- Room -->
					    <td width="20%"> <i class="icon-info-sign"></i> 
					    <?php 
					      echo $data[$key][4];
				      ?>
				      </td>

				    </tr>
    <?php
    
    }
    }
    if ( $count < ($schedule_page * $items_per_page) ) {
      $filler = ($schedule_page * $items_per_page) - $count;
      for ($i = 0; $i < $filler; $i++) {
        print "<tr bgcolor='#fff'><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";

      }
    }    
    ?>
			    </table>
			    </div>
			  </div>
			</div>
			
          <div class="topicList" style="text-align:center;">
			    <?php foreach ($topics as $topic) {
			            if ( array_key_exists($topic, $shorten_topics) ) {
                    print "<span class=\"badge $topic\">{$shorten_topics[$topic]}</span>";			            
			            } else {
                    print "<span class=\"badge $topic\">$topic</span>";
			            }
			    }
			    ?>
          </div>

<script src="js/jquery-1.10.2.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">

  $(document).ready(function() {
    $('#scheduleCarousel').carousel({
      interval: 15000,
    });
  });

</script>


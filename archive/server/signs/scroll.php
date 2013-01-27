<link href="bootstrap/css/bootstrap.css" rel="stylesheet">

<?php

#$xml = simplexml_load_file('http://scale10x.unbuilt.org/sign.xml');
$xml = simplexml_load_file('sign.xml');

$starttime = mktime(00, 00, 00, 01, 20, 2012) / 60;

#$rightnow = round(time() / 60);
$rightnow = 22117980;
$minsafter = $rightnow - $starttime;

$data = array();
$order = array();
$times = array();

foreach ($xml->node AS $node) {
	$pos = strpos((string) $node->{'Time-Slot'}, ",");
	$lpos = strrpos((string) $node->{'Time-Slot'}, ",");
	if ($pos === false) {
		$thistime = (string) $node->{'Time-Slot'};
		$thisend = (string) $node->{'Time-Slot'};
	} else {
		$thistime = substr((string) $node->{'Time-Slot'}, 0, $pos);
		$thisend = substr((string) $node->{'Time-Slot'}, $lpos + 2);
	}
	if ((string) $node->name == "- -") {
		$name = '';
	} else {
		$name = (string) $node->name;
	}
	$data[] = array((string) $node->Day, $thistime, $name, (string) $node->presentation, (string) $node->Room);
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
        <!---		body { background-color:#d0e4fe; } --->
		body { background-color:#ffffff; } 
		font { font-family: Tahoma, Geneva, sans-serif; color:black; text-align:left; font-size:14px; }
    	</style>
		<!-- <marquee behavior="scroll" direction="up" scrollamount="2" height="300"> -->
		  <div id="scheduleCarousel" class="carousel slide">
		    <div class="carousel-inner">	  
		      <div id="schedule-one-content" class="active item">
			    <table cellpadding=2 cellspacing=1 class="table table-bordered">
          <tr bgcolor="#fff"><th>Day</th><th>Start Time</th><th>Presenter</th><th>Topic</th><th>Room</th><th></th></tr>
		      <tbody id="schedule-one-content" class="active item">
    <?php $odd = 0; $count = 1; foreach ($order AS $key => $value) {
	    if (($times[$key][0] - 60) <= $minsafter && ($times[$key][1] + 10) >= $minsafter) {
	    // if ($times[$key][0] > 0) {
		    $odd++; 
		    if ( $odd % 2 == 0 ) { $color = "bgcolor=\"#d0e4fe\""; } else { $color="bgcolor=\"#fff\""; }
		    if ( $count % 8 == 0 ) {
		      $schedule_page = $count % 7;
		      print "</table>";
		      print "</div>";
		      print "<div id=\"schedule-two-content\" class=\"item\">";
			    print "<table cellpadding=2 cellspacing=1 class=\"table table-bordered\">";
			    print "<tr bgcolor='#fff'><th>Day</th><th>Start Time</th><th>Presenter</th><th>Topic</th><th>Room</th><th></th></tr>";
		    }
		    $count++; 

    ?>
				    <tr <?php echo "$color"; ?> >
				      <!-- Day -->
				      <td> <i class="icon-calendar"></i> <font><?php echo $data[$key][0]; ?> </font></td>
				      
				      <!-- Time -->
					    <td width="12%">
					      <i class="icon-time"></i>
					      <font><?php if ($times[$key][0] < $minsafter) { echo "In-Progress $minsafter " . $times[$key][0]; }
						    else { echo $data[$key][1]; } ?> </font>
					    </td>
					    
				      <!-- Presenter -->
					    <td> <font><?php echo $data[$key][2]; ?> </font></td>
					    
					    <!-- Topic -->
					    <td> <i class="icon-bullhorn"></i> <font><?php echo $data[$key][3]; ?> </font></td>
					    
					    <!-- Room -->
					    <td width="15%"> <i class="icon-info-sign"></i> <font><?php echo $data[$key][4]; ?> </font></td>
					    <td> <font><?php echo $data[$key][5]; ?> </font></td>
				    </tr>
    <?php
	    }
    }
    ?>
			    </table>
			    </div>
			  </div>
			</div>
  <!-- </marquee> -->

<script src="js/jquery-1.8.2.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
<script type="text/javascript">

  $(document).ready(function() {
    $('#scheduleCarousel').carousel('cycle',{
      interval: 10000
    });
  });

  

</script>

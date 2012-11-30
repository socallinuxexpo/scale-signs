<?php

$xml = simplexml_load_file('http://www.socallinuxexpo.org/sign.xml');

$starttime = mktime(00, 00, 00, 01, 20, 2012) / 60;

$rightnow = round(time() / 60);
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
	$data[] = array((string) $node->Day, $thistime, $name, (string) $node->presentation, (string) $node->Room, (string) $node->Categories);
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
function listheader() {
?>
				<tr bgcolor="#d0e4fe">
					<td><b>Start</b></td>
					<td><b>Track</b></td>
					<td><b>Presenter</b></td>
					<td><b>Presentation</b></td>
					<td><b>Room</b></td>
				</tr>
<?php
}
?>
<html>
	<head>
		<meta http-equiv="refresh" content="300" >
		<title>SCALE 10x</title>
	</head>
	<body>
	<style type="text/css" media="screen">
        <!---		body { background-color:#d0e4fe; } --->
		body { background-color:#ffffff; } 
		font { font-family: Tahoma, Geneva, sans-serif; color:black; text-align:left; font-size:14px; }
    	</style>
		<marquee behavior="scroll" direction="up" scrollamount="2" height="400">
			<table  cellpadding=2 cellspacing=1>
			<?php listheader(); ?>
<?php $odd = 0; foreach ($order AS $key => $value) {
	if (($times[$key][0] - 90) <= $minsafter && ($times[$key][1] + 5) >= $minsafter && $data[$key][5] != "Break") {
	// if ($times[$key][0] > 0 && $data[$key][5] != "Break") {
		$odd++; if ( $odd % 2 == 0 ) { $color = "bgcolor=\"#d0e4fe\""; } else { $color=''; }
	if ($odd % 10 == 0) { listheader(); }
?>
				<tr <?php echo "$color"; ?> >
				<!--	<td> <font><?php echo $data[$key][0]; ?> </font></td> -->
					<td width="12%"> <font><?php if ($times[$key][0] < $minsafter) { echo "In-Progress"; }
						else { echo $data[$key][1]; } ?> </font></td>
					<td> <font><?php echo $data[$key][5]; ?> </font></td>
					<td> <font><?php echo $data[$key][2]; ?> </font></td>
					<td> <font><?php echo $data[$key][3]; ?> </font></td>
					<td width="15%"> <font><?php echo $data[$key][4]; ?> </font></td>
				</tr>
<?php
	}
}
?>
			</table>
		</marquee>
	</body>
</html>

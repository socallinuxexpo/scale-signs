<?php
if (!empty($_GET["room"])) {
   $room = str_replace(' ', '', $_GET["room"]);
} else {
   $room = "";
}

$sponsors = array(
                "Verizon-Edgecast"  => "32.png",
                "MediaTemple"       => "19.png",
                "Ansible"           => "02.png",
                "Cars.com"          => "04.png",
                "DTK.io"            => "10.png",
                "Citrix"            => "07.png",
                "Joyent"            => "16.png",
                "RedHat"            => "26.png",
                "PuppetLabs"        => "23.png",
                "Mysql"             => "20.png",
                "Google"            => "12.png",
                "LPI"               => "33.png",
                "OneCourseSource"   => "34.png",
                "Rackspace"         => "24.png",
                "HP"                => "13.png",
                "Chef"              => "06.png",
                "SaltStack"         => "27.png",
                "LOPSA"             => "36.png",
                "Fedora"            => "11.png"

    );

$sponsors_to_rooms = array(
                "LaJolla" => array(
                                    "Friday" => array("Verizon-Edgecast", "MediaTemple", "Ansible", "Cars.com", "DTK.io"),
                                    "Saturday" => array("Joyent"),
                                    "Sunday" => array("Joyent"),
                            ),
                "Carmel" => array(
                                    "Friday" => array("Citrix"),
                                    "Saturday" => array("Q"),
                                    "Sunday" => array("Q"),
                            ),
                "CenturyAB" => array(
                                    "Friday" => array("RedHat"),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "CenturyCD" => array(
                                    "Friday" => array("PuppetLabs"),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "LosAngelesA" => array(
                                    "Friday" => array("Mysql"),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "LosAngelesB" => array(
                                    "Friday" => array(),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "LosAngelesC" => array(
                                    "Friday" => array(),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "BelAir" => array(
                                    "Friday" => array("LPI"),
                                    "Saturday" => array("Google"),
                                    "Sunday" => array("OneCourseSource"),
                            ),
                "Marina" => array(
                                    "Friday" => array(),
                                    "Saturday" => array("Google"),
                                    "Sunday" => array("Google"),

                            ),
                "SanLorenzoD" => array(
                                    "Friday" => array("LOPSA"),
                                    "Saturday" => array("HP"),
                                    "Sunday" => array("HP"),
                            ),
                "SanLorenzoE" => array(
                                    "Friday" => array("Rackspace"),
                                    "Saturday" => array("Rackspace"),
                                    "Sunday" => array("Rackspace"),
                            ),
                "SanLorenzoF" => array(
                                    "Friday" => array("Chef"),
                                    "Saturday" => array("Chef"),
                                    "Sunday" => array("SaltStack"),
                            ),
                );

$xml = simplexml_load_file('http://www.socallinuxexpo.org/scale12x/sign.xml');

$starttime = mktime(0, 0, 0, 2, 21, 2014) / 60;

#$rightnow = round(time() / 60);
$rightnow = mktime(11, 30, 0, 2, 22, 2014) / 60;
$minsafter = $rightnow - $starttime;

$data = array();
$order = array();
$times = array();

$shorten_topics = array(
                        "BeginnerTutorials" => "Beginner Tutorials",
                        "CloudandVirtualization" => "Cloud and Virtualization",
                        "EveningEntertainment" => "Evening Entertainment",
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
	$data[] = array((string) $node->Day, $thistime, $name, (string) $node->Title, (string) $node->Room, (string) $node->Topic, (string) $node->Photo, (string) $node->{'Short-abstract'});
		
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

    <?php 
    $topics = array();
    $items_per_page = 8;
    $odd = 0; $count = 0; $schedule_page = 1;
    foreach ($order AS $key => $value) {
        //
        // Remove spaces from room to compare with passed argument
        //
        $xml_room = str_replace(' ', '', $data[$key][4]);
        if (($times[$key][0] - 60) <= $minsafter && ($times[$key][1]) >= $minsafter && $xml_room == $room) {
            //
            // Check if the topic of the current talk is in the array
            // ..if not. add it.
            //
            if (! in_array($data[$key][5], $topics)) {
                $topics[] = $data[$key][5];
            }
            $photo = $data[$key][6];
            ?>
    	    <div class="<?php if ($count == 0) { echo "active"; } ?> item">
                <div class="media">
                    <a class="pull-left" href="#">
                        <?php
                        if (strlen($photo) > 0) {
                            echo "$photo";
                        } else {
                            echo '<img src="images/headshot.png" width="480" height="480">';
                        }
                        ?>
                    </a>
                    <div class="media-body">
                        <h2 class="media-heading"><?php echo $data[$key][2]; ?></h2>
                        <h3 class="media-heading"><?php echo $data[$key][3]; ?></h3>
                        <h4><?php echo $data[$key][7]; ?></h4>
                        <hr/>
					    <?php
                            $talk_time = $data[$key][1];
                            list($start_time, $end_time) = split(" to ", $talk_time, 2);
                            $start_time = date("h:i a", strtotime($start_time));
                            $end_time = date("h:i a", strtotime($end_time));

                            if ($times[$key][0] <= $minsafter) {
                                echo "<h2 style='text-align: center;'>In-Progress until $end_time</h2>";
                            } else {
                                echo "<h2 style='text-align: center;'>$start_time to $end_time</h2>";
                            }

                            $day = $data[$key][0];
                            if (count($sponsors_to_rooms[$room][$day]) > 0) {
                                $sponsors_for_room = $sponsors_to_rooms[$room][$day];
                            } else {
                                $sponsors_for_room = array();
                            }
                            ?>
                    </div>
                </div>
            </div>
        <?php
        $count++;
        }
    }
    ?>
    	    <div class="<?php if ($count == 0) { echo "active"; } ?> item">
                <div class="media">
                    <div class="row">
                        <div class="col-md-12" style="text-align: center; vertical-align: middle;">
                            <div class="well" style="height: 480px; vertical-align: middle;">
                            <div class="row">&nbsp;</div>
                            <img src="images/WiFi-Sign.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (count($sponsors_for_room) > 0) { ?>
            <div class="item">
                <div class="media">
                    <div class="row" style="text-align: center;">
                        <h2 style='text-align: center;'>Thank You To Our Track <?php if (count($sponsors_for_room) > 1) { echo "Sponsors"; } else { echo "Sponsor"; } ?></h2> 
                    </div>                  
                    <div class="row" style="text-align: center;">
                        <?php
                        $column = count($sponsors_for_room);
                        switch ($column) {
                            case 1:
                                $img_size = 500;
                                break;
                            case 2:
                                $img_size = 400;
                                break;
                            case 3:
                                $img_size = 300;
                                break;
                            case 4:
                                $img_size = 250;
                                break;
                            case 5:
                                $img_size = 200;
                                break;
                        }

                        foreach ($sponsors_for_room as $sponsor) {
                            echo "<img src='images/sponsors/" . $sponsors[$sponsor] . "' style='width: " . $img_size . "px; height: " . $img_size . "px;'>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php } ?>

	</div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>    
<script src="bootstrap/js/bootstrap.js"></script>
<script type="text/javascript">

  $(document).ready(function() {
    $('#scheduleCarousel').carousel({
      interval: 5000,
    });
  });

</script>


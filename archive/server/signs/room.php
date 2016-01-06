<?php
if (!empty($_GET["room"])) {
   $room = str_replace(' ', '', $_GET["room"]);
} else {
   $room = "";
}
 
$year = $month = $day = $hour = $minute = '';
if (!empty($_GET["year"])) {
    $year = $_GET['year'];
}

if (!empty($_GET["month"])) {
    $month = $_GET['month'];
}

if (!empty($_GET["day"])) {
    $day = $_GET['day'];
}

if (!empty($_GET["hour"])) {
    $hour = $_GET['hour'];
}

if (!empty($_GET["minute"])) {
    $minute = $_GET['minute'];
}
if (!empty($year) && !empty($month) && !empty($day) && !empty($hour) && !empty($minute)) {
    $rightnow = round(mktime($hour, $minute, 0, $month, $day, $year) / 60);
} else {
    $rightnow = round(time() / 60);
}

$room_lookup_table = array(
    "ballroom-de"   => "BallroomDE",
    "ballroom-a"    => "BallroomA",
    "ballroom-b"    => "BallroomB",
    "ballroom-c"    => "BallroomC",
    "ballroom-f"    => "BallroomF",
    "ballroom-g"    => "BallroomG",
    "ballroom-h"    => "BallroomH",
    "ballroom-gh"   => "BallroomGH",
    "ballroom-i"    => "BallroomI",
    "ballroom-j"    => "BallroomJ",
    "room-101"  => "Room101",
    "room-103"  => "Room103",
    "room-104"  => "Room104",
    "room-106"  => "Room106",
    "room-107"  => "Room107",
    "room-211"  => "Room211",
    "room-212"  => "Room212",
    "room-209"  => "Room209",
    "room-205"  => "Room205",
    "room-215"  => "Room215",
    );

$sponsors = array(
                "ActiveState"       => "01.png",
                "Ansible"           => "02.png",
                "Arista"            => "03.png",
                "Chef"              => "04.png",
                "Citrix"            => "05.png",
                "Datadog"           => "06.png",
                "Dreamhost"         => "07.png",
                "Dtk.io"            => "08.png",
                "Fedora"            => "09.png",
                "HP"                => "10.png",
                "IBM"               => "11.png",
                "LinuxJournal"      => "12.png",
                "LinuxMagazine"     => "13.png",
                "MediaTemplate"     => "14.png",
                "Puppet"            => "15.png",
                "RackSpace"         => "16.png",
                "RedHat"            => "17.png",
                "SaltStack"         => "18.png",
                "SiliconMechanics"  => "19.png",
                "Telesign"          => "20.png",
                "Usenix"            => "21.png",
                "ActUSA"            => "22.png",
                "LPI"               => "23.png",
                "OneCourseSource"   => "24.png",
                "Q"                 => "25.png",
                "DigitalOceam"      => "26.png",
                "Github"            => "27.png",
                "Keycloud"          => "28.png",
                "Linode"            => "29.png",
                "FreeBSD"           => "30.png",
                "ElasticSearch"     => "31.png",
                "PogoLinux"         => "32.png",
                "openNMS"           => "33.png",
                "StackStorm"        => "34.png",
                "SUSE"              => "35.png",
                "VictorOps"         => "36.png",
                "FOSSForce"         => "37.png",
                "MaxCDN"            => "38.png",
                "Symantec"          => "39.png",
                "OpenSource.com"    => "40.png",
                "Rubicon"           => "41.png",
                "Verizon"           => "42.png",
                "Google"            => "43.png",
                "Microsoft"         => "44.png",
                "cars.com"          => "45.png",
                "MySQL"             => "46.png",
                "Cisco"             => "47.png",
                "nginx"             => "48.png",
                "openSUSE"          => "49.png",
                "ZipRecruiter"      => "50.png",
    );

$sponsors_to_rooms = array(
                "ballroom-de" => array(
                                    "Thursday" => array(),
                                    "Friday" => array("cars.com", "Datadog", "Dtk.io", "Microsoft", "StackStorm", "Verizon", "Cisco", "ZipRecruiter"),
                                    "Saturday" => array("Rubicon"),
                                    "Sunday" => array("Rubicon"),
                            ),
                "ballroom-a" => array(
                                    "Thursday" => array("Chef","Datadog"),
                                    "Friday" => array("ActiveState"),
                                    "Saturday" => array("ActiveState"),
                                    "Sunday" => array("ActiveState"),
                            ),
                "ballroom-b" => array(
                                    "Thursday" => array("openSUSE"),
                                    "Friday" => array("RedHat"),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "ballroom-c" => array(
                                    "Thursday" => array("openSUSE"),
                                    "Friday" => array("RedHat"),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "ballroom-f" => array(
                                    "Thursday" => array("Puppet"),
                                    "Friday" => array(),
                                    "Saturday" => array("Q"),
                                    "Sunday" => array("Q"),
                            ),
                "ballroom-g" => array(
                                    "Thursday" => array("ElasticSearch"),
                                    "Friday" => array(),
                                    "Saturday" => array("Symantec"),
                                    "Sunday" => array("Symantec"),
                            ),
                "ballroom-h" => array(
                                    "Thursday" => array("ElasticSearch"),
                                    "Friday" => array(),
                                    "Saturday" => array("Symantec"),
                                    "Sunday" => array("Symantec"),
                            ),
                "ballroom-gh" => array(
                                    "Thursday" => array(),
                                    "Friday" => array(),
                                    "Saturday" => array("MaxCDN"),
                                    "Sunday" => array("MaxCDN"),
                            ),
                "ballroom-i" => array(
                                    "Thursday" => array(),
                                    "Friday" => array(),
                                    "Saturday" => array("MaxCDN"),
                                    "Sunday" => array("MaxCDN"),
                            ),
                "ballroom-j" => array(
                                    "Thursday" => array(),
                                    "Friday" => array(),
                                    "Saturday" => array("openSUSE"),
                                    "Sunday" => array("openSUSE"),
                            ),
                "room-101" => array(
                                    "Thursday" => array(),
                                    "Friday" => array(),
                                    "Saturday" => array("openSUSE"),
                                    "Sunday" => array("openSUSE"),
                            ),
                "room-102" => array(
                                    "Thursday" => array(),
                                    "Friday" => array(),
                                    "Saturday" => array("OneCourseSource", "HP"),
                                    "Sunday" => array(),
                            ),
                "room-103" => array(
                                    "Thursday" => array(),
                                    "Friday" => array(),
                                    "Saturday" => array("openSUSE"),
                                    "Sunday" => array("openSUSE"),

                            ),
                "room-104" => array(
                                    "Thursday" => array(),
                                    "Friday" => array(),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "room-106" => array(
                                    "Thursday" => array(),
                                    "Friday" => array(),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "room-107" => array(
                                    "Thursday" => array(),
                                    "Friday" => array(),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "room-211" => array(
                                    "Thursday" => array(),
                                    "Friday" => array("MySQL"),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "room-212" => array(
                                    "Thursday" => array(),
                                    "Friday" => array(),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                 "room-209" => array(
                                    "Thursday" => array(),
                                    "Friday" => array(),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
               );
$url = 'http://www.socallinuxexpo.org/scale/14x/sign.xml';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$xmlresponse = curl_exec($ch);
$xml = simplexml_load_string($xmlresponse);

$starttime = mktime(0, 0, 0, 1, 21, 2016) / 60;

#$rightnow = round(time() / 60);
#$rightnow = mktime(10, 30, 0, 2, 22, 2015) / 60;
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

	if ((string) $node->Speakers == "- -") {
		$name = '';
	} else {
		$name = (string) $node->Speakers;
	}
	$data[] = array((string) $node->Day, $thistime, $name, (string) $node->Title, (string) $node->Room, (string) $node->Topic, (string) $node->Photo, (string) $node->{'Short-abstract'});
		
	#$realtime = $thistime;
	#$realstime = $thisend;
	$realtime = explode(' to ', $thistime)[0];
	$realstime = explode(' to ', $thisend)[1];
	$handm = explode(":", $realtime);
	$handme = explode(":", $realstime);
	$mfromm = ($handm[0] * 60) + $handm[1];
	#$mfromme = ($handme[0] * 60) + 60 + $handme[1];
	$mfromme = ($handme[0] * 60) + $handme[1];
	
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
        if (($times[$key][0] - 60) <= $minsafter && ($times[$key][1]) >= $minsafter && $xml_room == $room_lookup_table[$room]) {
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
                            if ($data[$key][3] === "Bad Voltage: Live") {
                                echo '<img src="images/badvoltage.jpg" width="480" height="480">';
                            } elseif ($data[$key][3] === "Weakest Geek") {
                                echo '<img src="images/weakest_geek_1.png" width="480" height="480">';
                            } elseif ($data[$key][3] === "UpSCALE") {
                                echo '<img src="images/upscale_logo_480.png" width="480" height="480">';
                            } else {
                                echo '<img src="images/headshot.png" width="480" height="480">';
                            }
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
                            <div class="well" style="height: 460px; vertical-align: middle;">
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
                                $img_size = 400;
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
                            case 6:
                                $img_size = 200;
                                break;
                            case 7:
                                $img_size = 200;
                                break;
                            case 8:
                                $img_size = 200;
                                break;
                        }

                        foreach ($sponsors_for_room as $sponsor) {
                            echo "<img src='images/sponsors/" . $sponsors[$sponsor] . "' style='width: " . $img_size . "px; height: " . $img_size . "px; border: 1px solid #000; margin: 1px;'>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php } ?>

	</div>
    </div>

<script src="js/jquery-1.10.2.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">

  $(document).ready(function() {
    $('#scheduleCarousel').carousel({
      interval: 5000,
    });
  });

</script>


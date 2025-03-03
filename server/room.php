<?php

date_default_timezone_set('America/Los_Angeles');

# set yearly (change if DST starts during SCaLE)

# set yearly (change if DST starts during SCaLE)
# before "spring forward"
$starttime = mktime(0, 0, 0, 3, 6, 2025) / 60;

# after "spring forward"
#$starttime = mktime(23, 0, 0, 3, 5, 2025) / 60;

$sponsors_for_room = array();
$sponsor_class = "Room";
$sponsor_image_size = 165;

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
    "ballroom-a"     => "BallroomA",
    "ballroom-b"     => "BallroomB",
    "ballroom-c"     => "BallroomC",
    "ballroom-de"    => "BallroomDE",
    "ballroom-f"     => "BallroomF",
    "ballroom-g"     => "BallroomG",
    "ballroom-h"     => "BallroomH",
    "room-101"       => "Room101",
    "room-103"       => "Room103",
    "room-104"       => "Room104",
    "room-105"       => "Room105",
    "room-106"       => "Room106",
    "room-107"       => "Room107",
    "room-208"       => "Room208",
    "room-209"       => "Room209",
    "room-211"       => "Room211",
    "room-212"       => "Room212",
);

$sponsors = array(
    "ampere"    => "ampere.jpg",
    "arm"     => "arm.png",
    "automatedbuildings"     => "automatedbuildings.jpg",
    "aws"     => "aws.png",
    "canonical"     => "canonical.png",
    "ciq"     => "ciq.png",
    "clickhouse"     => "clickhouse.png",
    "cloudnativecomputingfoundation"     => "cloudnativecomputingfoundation.png",
    "coder"     => "coder.png",
    "consuldemocracyfoundation"     => "consuldemocracyfoundation.png",
    "dagger"     => "dagger.png",
    "datadog"     => "datadog.png",
    "dbeaver"     => "dbeaver.png",
    "flox"     => "flox.png",
    "fosslife"     => "fosslife.png",
    "github"     => "github.png",
    "google"     => "google.png",
    "grafanalabs"     => "grafanalabs.png",
    "gsjj"     => "gsjj.png",
    "isovalent"     => "isovalent.png",
    "kubecareers"     => "kubecareers.png",
    "kubeevents"     => "kubeevents.png",
    "linbit"     => "linbit.png",
    "linuxmagazine"     => "linuxmagazine.png",
    "meta"     => "meta.png",
    "microsoft"     => "microsoft.png",
    "mysql"     => "mysql.png",
    "netactuate"     => "netactuate.png",
    "netappinstaclustr"     => "netappinstaclustr.png",
    "netknights"     => "netknights.png",
    "openintel"     => "openintel.png",
    "opensourcejobhub"     => "opensourcejobhub.png",
    "owasp"     => "owasp.png",
    "oxenai"     => "oxenai.png",
    "percona"     => "percona.png",
    "perforce"     => "perforce.png",
    "personalai"     => "personalai.jpg",
    "pomerium"     => "pomerium.png",
    "postgresql"     => "postgresql.png",
    "quest"     => "quest.png",
    "redgate"     => "redgate.jpg",
    "redhat"     => "redhat.png",
    "replit"     => "replit.png",
    "rockylinux"     => "rockylinux.png",
    "softwaredefinedtalk"     => "softwaredefinedtalk.jpg",
    "softwarefreedomconservancy"     => "softwarefreedomconservancy.png",
    "speedscale"     => "speedscale.png",
    "starnetcommunications"     => "starnetcommunications.png",
    "system76"     => "system76.png",
    "tailscale"     => "tailscale.jpg",
    "thunderbird"     => "thunderbird.png",
    "thundercomm"     => "thundercomm.png",
    "tigera"     => "tigera.png",
    "victoriametrics"     => "victoriametrics.png",
    "warpdev"     => "warpdev.png",
    "xata"     => "xata.png",
    "yogertpc"     => "yogertpc.png",
    "zabbix"     => "zabbix.png",
    "zesty"     => "zesty.png",
    # devops days
    "akamai" => "akamai.png",
    "bellsoft" => "bellsoft.png",
    "checkmarx" => "checkmarx.png",
    "couchbase" => "couchbase.png",
    "devzero" => "devzero.png",
    "dnsimple" => "dnsimple.png",
    "firefly" => "firefly.png",
    "fluidattacks" => "fluidattacks.png",
    "gruntwork" => "gruntwork.png",
    "honeycombio" => "honeycombio.png",
    "jobst" => "jobst.png",
    "kapstan" => "kapstan.png",
    "opsera" => "opsera.png",
    "parasoft" => "parasoft.png",
    "runme" => "runme.png",
    "sedai" => "sedai.png",
    "semaphore" => "semaphore.png",
    "thales" => "thales.png",
);

$diamond_platinum_sponsors = array(
    "aws",
    "github",
    "openintel",
    "microsoft",
    "zabbix",
);

$gold_sponsors = array(
    "canonical",
    "flox",
    "google",
    "meta",
    "netknights",
    "redhat",
    "system76",
    "victoriametrics",
);

$silver_sponsors = array(
    "ampere",
    "arm",
    "ciq",
    "clickhouse",
    "cncf",
    "coder",
    "dagger",
    "datadog",
    "dbeaver",
    "grafana",
    "isovalent",
    "linbit",
    "mysql",
    "netactuate",
    "netappinstaclustr",
    "oxenai",
    "percona",
    "perforce",
    "pomerium",
    "postgresql",
    "quest",
    "redgate",
    "replit",
    "rockylinux",
    "speedscale",
    "starnetcommunications",
    "tailscale",
    "thunderbird",
    "thundercomm",
    "warpdev",
    "xata",
    "zesty",
);

$media_sponsors = array(
    "openintel",
    "automatedbuildings",
    "consuldemocracyfoundation",
    "fosslife",
    "gsjj",
    "kubecareers",
    "kubeevents",
    "linuxmagazine",
    "opensourcejobhub",
    "owasp",
    "personalai",
    "softwaredefinedtalk",
    "yogertpc",
);

$fancy_sponsors = array(
    "openintel",       #registration & reception
    "google",      #travel
    "redhat",      #travel
    "arm",         #reception
    "quest",       #speaker-track
);

$sponsors_to_rooms = array(
    "ballroom-a"    => array(
            "Thursday"  => array("tigera","cloudnativecomputingfoundation"),
            "Friday"    => array("tigera","cloudnativecomputingfoundation"),
            "Saturday"  => array(),
            "Sunday"    => array(),
    ),
    "ballroom-b"    => array(
            "Thursday"  => array("tigera","cloudnativecomputingfoundation"),
            "Friday"    => array("tigera","cloudnativecomputingfoundation"),
            "Saturday"  => array(),
            "Sunday"    => array(),
    ),
    "ballroom-c"    => array(
            "Thursday"  => array("microsoft","meta","grafanalabs","openintel"),
            "Friday"    => array(),
            "Saturday"  => array(),
            "Sunday"    => array(),
    ),
    "ballroom-de"   => array(
            "Thursday"  => array(),
            "Friday"    => array("akamai","bellsoft","checkmarx","couchbase","devzero","dnsimple","firefly","fluidattacks","gruntwork","honeycombio","jobst","kapstan","opsera","parasoft","runme","sedai","semaphore","thales"),
            "Saturday"  => array("github","microsoft","openintel","zabbix"),
            "Sunday"    => array("github","microsoft","openintel","zabbix"),
    ),
    "ballroom-f"    => array(
            "Thursday"  => array(),
            "Friday"    => array(),
            "Saturday"  => array(),
            "Sunday"    => array(),
    ),
    "ballroom-g"    => array(
            "Thursday"  => array(),
            "Friday"    => array(),
            "Saturday"  => array(),
            "Sunday"    => array(),
    ),
    "ballroom-h"    => array(
            "Thursday"  => array(),
            "Friday"    => array(),
            "Saturday"  => array(),
            "Sunday"    => array(),
    ),
    "room-101"      => array(
            "Thursday"  => array(),
            "Friday"    => array(),
            "Saturday"  => array(),
            "Sunday"    => array(),
    ),
    "room-103"      => array(
            "Thursday"  => array(),
            "Friday"    => array(),
            "Saturday"  => array(),
            "Sunday"    => array(),
    ),
    "room-104"      => array(
            "Thursday"  => array(),
            "Friday"    => array(),
            "Saturday"  => array(),
            "Sunday"    => array(),
    ),
    "room-105"      => array(
            "Thursday"  => array(),
            "Friday"    => array(),
            "Saturday"  => array(),
            "Sunday"    => array(),
    ),
    "room-106"      => array(
            "Thursday"  => array(),
            "Friday"    => array(),
            "Saturday"  => array(),
            "Sunday"    => array(),
    ),
    "room-107"      => array(
            "Thursday"  => array(),
            "Friday"    => array(),
            "Saturday"  => array(),
            "Sunday"    => array(),
    ),
    "room-208"      => array(
            "Thursday"  => array(),
            "Friday"    => array(),
            "Saturday"  => array(),
            "Sunday"    => array(),
    ),
    "room-209"      => array(
            "Thursday"  => array(),
            "Friday"    => array(),
            "Saturday"  => array(),
            "Sunday"    => array(),
    ),
    "room-211"      => array(
            "Thursday"  => array(),
            "Friday"    => array(),
            "Saturday"  => array(),
            "Sunday"    => array(),
    ),
    "room-212"      => array(
            "Thursday"  => array(),
            "Friday"    => array(),
            "Saturday"  => array(),
            "Sunday"    => array(),
    ),
);

$url = 'http://www.socallinuxexpo.org/scale/22x/sign.xml';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$xmlresponse = curl_exec($ch);
$xml = simplexml_load_string($xmlresponse);

#$rightnow = round(time() / 60);
#$rightnow = mktime(10, 30, 0, 2, 22, 2015) / 60;
$minsafter = $rightnow - $starttime;

$data = array();
$order = array();
$times = array();

$shorten_topics = array(
	"AppliedScience" 					=>	"Applied Science",
	"BoFs" 								=> 	"BoFs",
	"CareerDay"							=>	"Career Day",
	"CloudNative"						=>	"Cloud Native",
	"DataonKubernetes"					=>	"Data on Kubernetes",
	"Developer"							=>	"Developer",
	"DevOpsDayLA"						=>	"DevOpsDay LA",
	"Embedded"							=>	"Embedded",
	"FOSSHOME"							=>	"FOSS @ HOME",
	"FOSS@HOME"							=>	"FOSS @ HOME",
	"General"							=>	"General",
	"KernelandLowLevelSystems"			=>	"Kernel & Low Level Systems",
	"Keynote"							=>	"Keynote",
	"KwaaiSummit" 						=>	"Kwaai Summit",
	"KubernetesCommunityDay"			=>	"Kubernetes Community Day",
	"LibreGraphics" 					=> 	"Libre Graphics",
	"MySQL"								=>	"MySQL",
	"NextGeneration"					=>	"Next Generation",
	"NixCon"							=>	"NixCon",
	"Observability"						=>	"Observability",
	"OpenGovernment"					=>	"Open Government",
	"OpenInfraDays" 					=>  "OpenInfra Days",
	"OpenSourceAI"              		=>	"Open Source AI",
	"OpenSourceAIandAppliedScience"		=>	"Open Source AI and Applied Science",
	"PlanetNix" 						=>	"PlanetNix",
	"PostgreSQL"						=>	"PostgreSQL",
	"ReproducibleandImmutableSoftware"	=>	"Reproducible and Immutable Software",
	"Security"							=>	"Security",
	"Sponsored"							=>	"Sponsored",
	"SunSecCon" 						=> 	"SunSecCon",
	"SystemsandInfrastructure"			=>	"Systems and Infrastructure",
	"Ubucon"							=>	"Ubucon",
	"UpSCALE"							=>	"UpSCALE",
	"Workshops"							=>	"Workshops"
);

foreach ($xml->node AS $node) {

    // Remove HTML tags
    $node->{'Time'} = preg_replace('/<[^>]*>/', '', $node->{'Time'});
    $node->{'Day'} = preg_replace('/<[^>]*>/', '', $node->{'Day'});

    // Remove special chars in Topic from XML request so we can use it for a CSS class
    $node->{'Topic'} = preg_replace('/\s+/', '', $node->{'Topic'});
    $node->{'Topic'} = preg_replace('/\&/', 'and', $node->{'Topic'});
    $node->{'Topic'} = preg_replace('/\@/', '', $node->{'Topic'});

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
                            #echo "$photo";
                        /*} else {
                            if ($data[$key][3] === "Bad Voltage: Live") {
                                echo '<img src="images/badvoltage.jpg" width="480" height="480">';
                            } elseif ($data[$key][3] === "Weakest Geek") {
                                echo '<img src="images/weakest_geek_1.png" width="480" height="480">';
                            } elseif ($data[$key][3] === "UpSCALE") {
                                echo '<img src="images/upscale_logo_480.png" width="480" height="480">';
                            } else {
                                echo '<img src="images/headshot.png" width="480" height="480">';
                            }
                        */
                        }
                        ?>
                    </a>
                    <div class="media-body" style="vertical-align: middle; height: 525px; margin: 15px">
                        <h1 class="media-heading" style="margin: 20px;"><?php echo $data[$key][3]; ?></h1>
                        <h2 class="media-heading" style="margin: 20px;"><?php echo $data[$key][2]; ?></h2>
                        <h3 style="margin: 20px;"><?php echo $data[$key][7]; ?></h3>
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
                                $sponsor_class = "Room";
                            } else {
                                $sponsors_for_room = $gold_sponsors;
                                $sponsor_class = "Gold";
                            }
                            shuffle($sponsors_for_room);
                            if (count($sponsors_for_room) > 12) {
                                $sponsor_image_size = 137;
                            }
                            if (count($sponsors_for_room) < 5) {
                                $sponsor_image_size = 220;
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
                            <div class="well" style="height: 300px; vertical-align: middle;">
                            <div class="row" style="margin: 5px">&nbsp;</div>
                                <img src="images/WiFi-Sign.png" width="487" height="186">
                            </div>
                            <div class="row" style="margin: 15px">
                                <h2 style='text-align: center;'>Thank You to our Diamond and Platinum Sponsors</h2>
                                <?php
                                foreach ($diamond_platinum_sponsors as $sponsor) {
                                    echo "<img src='images/sponsors/" . $sponsors[$sponsor] . "' style='margin: 15px';>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (count($sponsors_for_room) > 0) { ?>
            <div class="item">
                <div class="media">
                    <div class="row" style="text-align: center; vertical-align: middle; height: 550px;">
                        <h2 style='text-align: center;'>Thank You to our <?php echo "$sponsor_class "; if (count($sponsors_for_room) > 1) { echo "Sponsors"; } else { echo "Sponsor"; } ?></h2>
                        <?php
                        foreach ($sponsors_for_room as $sponsor) {
                            echo "<img src='images/sponsors/" . $sponsors[$sponsor] . "' style='margin: 15px';>";
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
      interval: 15000,
    });
  });

</script>

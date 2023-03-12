<?php

date_default_timezone_set('America/Los_Angeles');

# set yearly (change if DST starts during SCaLE)

# before "spring forward"
#$starttime = mktime(0, 0, 0, 3, 5, 2020) / 60;
#$starttime = mktime(0, 0, 0, 3, 9, 2023) / 60;

# after "spring forward"
#$starttime = mktime(23, 0, 0, 7, 27, 2022) / 60;
$starttime = mktime(23, 0, 0, 3, 8, 2023) / 60;

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
    "room-209"       => "Room209",
    "room-211"       => "Room211",
    "room-212"       => "Room212",
);

$sponsors = array(
    "cloud_native_computing_foundation" =>    "cloud_native_computing_foundation.png",
    "google"                            => "google.png",
    "ceph"                              =>    "ceph.png",
    "cisco"                             => "cisco_eti.png",
    "databricks"                        =>    "databricks.png",
    "datastax"                          => "datastax.png",
    "elastic"                           =>    "elastic.png",
    "isovalent"                         => "isovalent.png",
    "linbit"                            => "linbit.png",
    "mattermost"                        => "mattermost.png",
    "meta"                              =>    "meta.png", #facebook
    "nginx"                             => "nginx.png",
    "pgedge"                            => "pgedge.png",
    "redhat"                            =>    "redhat.png",
    "site247"                           =>    "site247.png",
    "sonatype"                          => "sonatype.png",
    "suse"                              => "suse.png",
    "acorn"                             =>  "acorn.png",
    "akamai_linode"                     =>    "linode.png",
    "akuity"                            =>  "akuity.png",
    "asserts"                           =>  "asserts.png",
    "azul"                              =>  "azul.png",
    "bayesian"                          =>  "bayesian.png",
    "buildkite"                         =>    "buildkite.png",
    "calyptia"                          =>    "calyptia.png",
    "camunda"                           =>    "camunda.png",
    "ciq"                               =>    "ciq.png",
    "circleci"                          =>    "circleci.png",
    "cyberark"                          =>  "cyberark.png",
    "d2iq"                              =>  "d2iq.png",
    "datadog"                           =>    "datadog.png",
    "dbeaver"                           =>  "dbeaver.png",
    "fleet"                             =>  "fleet.png",
    "github"                            =>  "github.png",
    "gitlab"                            =>    "gitlab.png",
    "grafana"                           =>  "grafana.png",
    "ieee_sa_open"                      =>  "ieee_sa_open.png",
    "instaclustr"                       =>    "instaclustr.png",
    "ix_systems"                        =>  "ix_systems.png",
    "kloudfuse"                         =>  "kloudfuse.png",
    "kubecost"                          =>  "kubecost.png",
    "loft"                              =>  "loft.png",
    "maira"                             =>  "maira.png",
    "mysql"                             =>    "mysql.png", #oracle
    "nanovms"                           =>  "nanovms.png",
    "okteto"                            =>  "okteto.png",
    "opencost"                          =>  "opencost.png",
    "pagerduty"                         =>  "pagerduty.png",
    "percona"                           =>    "percona.png",
    "port"                              =>  "port.png",
    "postgresql"                        =>    "postgresql.png",
    "prosperops"                        =>  "prosperops.png",
    "quest"                             =>  "quest.png",
    "retool"                            =>  "retool.png",
    "spyderbat"                         =>    "spyderbat.png",
    "synopsys"                          =>  "synopsys.png",
    "temporal"                          =>  "temporal.png",
    "tetrate"                           =>  "tetrate.png",
    "tuxcare"                           =>  "tuxcare.png",
    "ubuntu"                            =>    "ubuntu.jpg",
    "arm"                               =>    "arm.png",
    "cloud7"                            => "cloud7.png",
    "fosslife"                          => "fosslife.png",
    "freebsd"                           => "freebsd.png",
    "its_foss"                          => "its_foss.png",
    "kubeevents"                        =>    "kubeevents.png",
    "learnk8s"                          =>  "learnk8s.png",
    "linuxjournal"                      => "linuxjournal.png",
    "linuxmagazine"                     => "linuxmagazine.png",
    "linux_org"                         => "linux_org.png",
    "opensource_jobhub"                 => "opensource_jobhub.png",
    "opensource_watch"                  => "opensource_watch.png",
    "sourceforge"                       =>    "sourceforge.png",
    "stackhawk"                         =>  "stackhawk.png",
    "stickermule"                       =>  "stickermule.png",
    "the_new_stack"                     =>  "the_new_stack.png",
    "trendoceans"                       =>  "trendoceans.png",
    "tuxdigital"                        =>  "tuxdigital.png",
    "intel"                             =>  "intel.png",
    "tailscale"                         =>  "tailscale.png",
    "the_linux_foundation_training"     =>  "the_linux_foundation_training.pny",
    ### "9to5linux"                         =>    "9to5linux.png",
    ### "adminmagazine"                     =>    "adminmagazine.png",
    ### "allegrograph"                      =>    "allegrograph.png", #franz
    ### "aws"                               =>    "aws.png",
    ### "chronosphere"                      =>    "chronosphere.png",
    ### "cloudbees"                         =>    "cloudbees.png",
    ### "coastlinecollege"                  =>    "coastlinecollege.png",
    ### "courier"                           =>    "courier.png",
    ### "deepsource"                        =>    "deepsource.png",
    ### "digitalocean"                      =>    "digitalocean.png",
    ### "dynatrace"                         =>    "dynatrace.png",
    ### "faun"                              =>    "faun.png",
    ### "freebsd_foundation"                =>    "freebsd_foundation.png",
    ### "edb"                               =>    "edb.png",
    ### "era"                               =>    "era.png",
    ### "gradle"                            =>    "gradle.png",
    ### "gremlin"                           =>    "gremlin.png",
    ### "harness"                           =>    "harness.png",
    ### "hulanetworks"                      =>    "hulanetworks.png",
    ### "humio"                             =>    "humio.png", #crowdstike
    ### "intellibus"                        =>    "intellibus.png",
    ### "itopia"                            =>    "itopia.png",
    ### "lpi"                               =>    "lpi.png",
    ### "mattermost"                        =>    "mattermost.png",
    ### "mondoo"                            =>    "mondoo.png",
    ### "newrelic"                          =>    "newrelic.png",
    ### "nirmata"                           =>    "nirmata.png",
    ### "observe"                           =>    "observe.jpg",
    ### "octopusdeploy"                     =>    "octopusdeploy.png",
    ### "opennms"                           =>    "opennms.png",
    ### "opensuse"                          =>    "opensuse.png",
    ### "pogo_linux"                        =>    "pogo_linux.png",
    ### "portworx"                          =>    "portworx.png",
    ### "replicated"                        =>    "replicated.png",
    ### "scoutapm"                          =>    "scoutapm.png",
    ### "spacelift"                         =>    "spacelift.png",
    ### "splunk"                            =>    "splunk.png",
    ### "stacklet"                          =>    "stacklet.png",
    ### "streamnative"                      =>    "streamnative.png",
    ### "system76"                          =>    "system76.png",
    ### "uffizzi"                           =>    "uffizzi.png",
    ### "veryant"                           =>    "veryant.png",
    ### "vmware"                            =>    "vmware.png",
    ### "wrccdc"                            =>    "westernregionalcyberdefense.png",
);

$diamond_platinum_sponsors = array(
    "cloud_native_computing_foundation",
    "google",
);

$gold_sponsors = array(
    "ceph",
    "cisco",
    "databricks",
    "datastax",
    "elastic",
    "isovalent",
    "linbit",
    "mattermost",
    "meta",
    "nginx",
    "pgedge",
    "redhat",
    "site24x7",
    "sonatype",
    "suse",
);

$silver_sponsors = array(
    "acorn",
    "akamai_linode",
    "akuity",
    "asserts",
    "azul",
    "bayesian",
    "buildkite",
   # "calyptia",
   # "camunda",
   # "ciq",
   # "circleci",
    "cyberark",
    "d2iq",
    "datadog",
    "dbeaver",
    "fleet",
    "github",
    "gitlab",
    "grafana",
    "ieee_sa_open",
    "instaclustr",
    "ix_systems",
    "kloudfuse",
    "kubecost",
    "loft",
    "maira",
    "mysql",
    "nanovms",
    "okteto",
    "opencost",
    "pagerduty",
    "percona",
    "port",
    "postgresql",
    "prosperops",
    "quest",
    "retool",
    "spyderbat",
    "synopsys",
    "temporal",
    "tetrate",
    "tuxcare",
    "ubuntu",
);

$media_sponsors = array(
    "arm",
    "cloud7",
    "fosslife",
    "freebsd",
    "its_foss",
    "kubeevents",
    "learnk8s",
    "linuxjournal",
    "linuxmagazine",
    "linux_org",
    "opensource_jobhub",
    "opensource_watch",
    "sourceforge",
    "stackhawk",
    "stickermule",
    "the_new_stack",
    "trendoceans",
    "tuxdigital",
);

$fancy_sponsors = array(
    "intel",       #registration
    "tailscale",   #reception
    "ceph",        #special-event
    "gitlab",      #speaker-track
    "the_linux_foundation_training", #speaker-track
);

$sponsors_to_rooms = array(
    "ballroom-a"    => array(
            "Thursday"  => array(),
            "Friday"    => array(),
            "Saturday"  => array(),
            "Sunday"    => array(),
    ),
    "ballroom-b"    => array(
            "Thursday"  => array(),
            "Friday"    => array(),
            "Saturday"  => array(),
            "Sunday"    => array(),
    ),
    "ballroom-c"    => array(
            "Thursday"  => array(),
            "Friday"    => array(),
            "Saturday"  => array(),
            "Sunday"    => array(),
    ),
    "ballroom-de"   => array(
            "Thursday"  => array(),
            "Friday"    => array(),
            "Saturday"  => array(),
            "Sunday"    => array(),
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
    "room-205"      => array(
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

$url = 'http://www.socallinuxexpo.org/scale/20x/sign.xml';
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
	"BoFs"           =>	"BoFs",
	"CloudNative"    =>	"CloudNative",
	"Developer"      =>	"Developer",
	"DevOpsDayLA"    =>	"DevOps Day LA",
	"General"        =>	"General",
	"MySQL"          =>	"MySQL",
	"Observability"  =>	"Observability",
	"OpenData"	 =>	"Open Data",
	"OpenGovernment" =>	"Open Government",
	"OpenMedical"	 =>	"Open Medical",
	"PosgreSQL"      =>	"PostgreSQL",
	"Security"       =>	"Security",
	"Sponsored"      =>	"Sponsored",
	"SystemsandInfrastructure" =>	"Systems and Infrastructure",
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
                                    echo "<img src='images/sponsors/" . $sponsors[$sponsor] . "' width='165' height='165' style='margin: 15px';>";
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
                            echo "<img src='images/sponsors/" . $sponsors[$sponsor] . "' height='" . $sponsor_image_size ."' width='" . $sponsor_image_size . "' style='margin: 15px';>";
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

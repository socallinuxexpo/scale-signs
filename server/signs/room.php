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
    "2nd-quadrant"      =>      "2nd-quadrant.png",
    "actusa"            =>      "actusa.png",
    "all-things-open"   =>      "all-things-open.png",
    "apache-bigtop"     =>      "apache-bigtop.png",
    "apcera"            =>      "apcera.png",
    "arden"             =>      "arden.png",
    "arrl"              =>      "arrl.png",
    "artoo"             =>      "artoo.png",
    "auriq"             =>      "auriq.png",
    "balabit"       =>      "balabit.png",
    "beachbody"     =>      "beachbody.png",
    "beagleboard"       =>      "beagleboard.png",
    "canonical"     =>      "canonical.png",
    "cars-com"      =>      "cars-com.png",
    "chef"      =>      "chef.png",
    "circonus"      =>      "circonus.png",
    "cisco"      =>      "cisco.png",
    "cloudlinux"        =>      "cloudlinux.png",
    "cylonjs"       =>      "cylonjs.png",
    "datadog"       =>      "datadog.png",
    "datarobot"     =>      "datarobot.png",
    "datera"        =>      "datera.png",
    "debian"        =>      "debian.png",
    "devops-com"        =>      "devops-com.png",
    "digitalocean"      =>      "digitalocean.png",
    "docker"        =>      "docker.png",
    "dreamhost"     =>      "dreamhost.png",
    "dtk"       =>      "dtk.png",
    "eff"       =>      "eff.png",
    "elementaryOS"      =>      "elementaryOS.png",
    "facebook"      =>      "facebook.png",
    "fedora"        =>      "fedora.png",
    "fluentd"       =>      "fluentd.png",
    "freebsdfoundation"     =>      "freebsdfoundation.png",
    "fsf"       =>      "fsf.png",
    "gentoo"        =>      "gentoo.png",
    "github"        =>      "github.png",
    "gnome"     =>      "gnome.png",
    "gnu-health"        =>      "gnu-health.png",
    "gobot"     =>      "gobot.png",
    "hackaday"      =>      "hackaday.png",
    "hp"        =>      "hp.png",
    "informit"      =>      "informit.png",
    "inkscape"      =>      "inkscape.png",
    "inmotion"      =>      "inmotion.png",
    "internet-in-a-box"     =>      "internet-in-a-box.png",
    "iovisor"       =>      "iovisor.png",
    "jenkins"       =>      "jenkins.png",
    "kde"       =>      "kde.png",
    "kids-on-computers"     =>      "kids-on-computers.png",
    "kodi"      =>      "kodi.png",
    "la-big-data"       =>      "la-big-data.png",
    "libreoffice"       =>      "libreoffice.png",
    "linbit"        =>      "linbit.png",
    "linhes"        =>      "linhes.png",
    "linode"        =>      "linode.png",
    "linuxacademy"      =>      "linuxacademy.png",
    "linuxastronomy"        =>      "linuxastronomy.png",
    "linuxchixla"       =>      "linuxchixla.png",
    "linuxfoundation"       =>      "linuxfoundation.png",
    "linuxpro"      =>      "linuxpro.png",
    "lopsa"     =>      "lopsa.png",
    "lpi"       =>      "lpi.png",
    "mageia"        =>      "mageia.png",
    "mariadb"       =>      "mariadb.png",
    "mediatemple"       =>      "mediatemple.png",
    "microsoft"     =>      "microsoft.png",
    "minnowboard"       =>      "minnowboard.png",
    "moog"      =>      "moog.png",
    "mysql"     =>      "mysql.png",
    "nagios"        =>      "nagios.png",
    "netbsd"        =>      "netbsd.png",
    "nixox"     =>      "nixox.png",
    "no-starch-press"       =>      "no-starch-press.png",
    "olpc"      =>      "olpc.png",
    "onecoursesource"       =>      "onecoursesource.png",
    "openbsd"       =>      "openbsd.png",
    "opennms"       =>      "opennms.png",
    "openshift"     =>      "openshift.png",
    "opensus"       =>      "opensus.png",
    "openx"     =>      "openx.png",
    "orabuntu-lxc"      =>      "orabuntu-lxc.png",
    "orangefs"      =>      "orangefs.png",
    "oreilly"       =>      "oreilly.png",
    "osi"       =>      "osi.png",
    "owncloud"      =>      "owncloud.png",
    "palamida"      =>      "palamida.png",
    "percona"       =>      "percona.png",
    "perlmongers"       =>      "perlmongers.png",
    "pfsense"       =>      "pfsense.png",
    "pogo-linux"        =>      "pogo-linux.png",
    "postgresql"        =>      "postgresql.png",
    "puppetlabs"        =>      "puppetlabs.png",
    "pyladies"      =>      "pyladies.png",
    "python"        =>      "python.png",
    "qnap"      =>      "qnap.png",
    "qubole"        =>      "qubole.png",
    "r1soft"        =>      "r1soft.png",
    "redhat"        =>      "redhat.png",
    "redislabs"     =>      "redislabs.png",
    "rubiconproject"        =>      "rubiconproject.png",
    "saltstack"     =>      "saltstack.png",
    "self"      =>      "self.png",
    "sgvhak"        =>      "sgvhak.png",
    "siliconmechanics"      =>      "siliconmechanics.png",
    "smci"      =>      "smci.png",
    "snowdrift-coop"        =>      "snowdrift-coop.png",
    "solarwinds"        =>      "solarwinds.png",
    "stackiq"       =>      "stackiq.png",
    "stellar"       =>      "stellar.png",
    "sugarlabs"     =>      "sugarlabs.png",
    "sumologic"     =>      "sumologic.png",
    "suse"      =>      "suse.png",
    "swift"     =>      "swift.png",
    "system76"      =>      "system76.png",
    "taos"      =>      "taos.png",
    "ticketmaster"      =>      "ticketmaster.png",
    "thinkpenguin"      =>      "thinkpenguin.png",
    "tox"       =>      "tox.png",
    "ubuntu"        =>      "ubuntu.png",
    "unleashkids"       =>      "unleashkids.png",
    "usenix"        =>      "usenix.png",
    "vaddy"     =>      "vaddy.png",
    "vcars"     =>      "vcars.png",
    "verizon"     =>      "verizon.png",
    "victorops"     =>      "victorops.png",
    "videolan"      =>      "videolan.png",
    "waltdisney"        =>      "waltdisney.png",
    "worldmentoring"        =>      "worldmentoring.png",
    "xoware"        =>      "xoware.png",
    "yelp"      =>      "yelp.png",
    "yocto"     =>      "yocto.png",

);

$sponsors_to_rooms = array(
                "ballroom-de" => array(
                                    "Thursday" => array(),
                                    "Friday" => array(),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "ballroom-a" => array(
                                    "Thursday" => array("ubuntu"),
                                    "Friday" => array(),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "ballroom-b" => array(
                                    "Thursday" => array(),
                                    "Friday" => array(),
                                    "Saturday" => array("q"),
                                    "Sunday" => array("q"),
                            ),
                "ballroom-c" => array(
                                    "Thursday" => array(),
                                    "Friday" => array(),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "ballroom-f" => array(
                                    "Thursday" => array(),
                                    "Friday" => array(),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "ballroom-g" => array(
                                    "Thursday" => array(),
                                    "Friday" => array(),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "ballroom-h" => array(
                                    "Thursday" => array(),
                                    "Friday" => array(),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "ballroom-gh" => array(
                                    "Thursday" => array(),
                                    "Friday" => array("cars-com","cisco","puppetlabs","verizon","sumologic","ticketmaster"),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "ballroom-i" => array(
                                    "Thursday" => array(),
                                    "Friday" => array(),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "ballroom-j" => array(
                                    "Thursday" => array(),
                                    "Friday" => array(),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "room-101" => array(
                                    "Thursday" => array(),
                                    "Friday" => array(),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "room-102" => array(
                                    "Thursday" => array(),
                                    "Friday" => array(),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "room-103" => array(
                                    "Thursday" => array("chef"),
                                    "Friday" => array(),
                                    "Saturday" => array(),
                                    "Sunday" => array(),

                            ),
                "room-104" => array(
                                    "Thursday" => array(),
                                    "Friday" => array("minnowboard"),
                                    "Saturday" => array("minnowboard"),
                                    "Sunday" => array("minnowboard"),
                            ),
                "room-106" => array(
                                    "Thursday" => array("postgresql"),
                                    "Friday" => array("postgresql"),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "room-107" => array(
                                    "Thursday" => array("postgresql"),
                                    "Friday" => array("postgresql"),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "room-211" => array(
                                    "Thursday" => array("xen"),
                                    "Friday" => array(),
                                    "Saturday" => array(),
                                    "Sunday" => array(),
                            ),
                "room-212" => array(
                                    "Thursday" => array("yocto"),
                                    "Friday" => array("palamida"),
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


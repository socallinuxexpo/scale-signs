<?php
	if (!empty($_GET["group"])) {
    switch ($_GET["group"]) {
      case 'one':
        $logos = array(
					"ato",
					"beagleboard",
					"blackduck",
					"buoyant",
					"canonical",
					"cars-com",
					"chef",
					"cloudlinux",
					"cncf",
					"codestream",
					"cyberark",
					"datadog",
					"debian",
					"dellemc",
					"diamanti",
					"disney",
					"dtk",
					"eff",
					"everbridge",
					"facebook",
					"fbf",
					"fedora",
					"fluentd",
					"freebsd",
					"fsf",
					"gentoo",
					"gnome",
					"gnuhealth",
					"gobot",
					"hackaday",
					"hak",
					"hubblestack",
					"inkscape",
					"ixsystems",
					"kde",
					"linbit",
					"linode",
					"linuxacademy",
					"linuxfoundation",
					"linuxpro",
					"logz",
					"lopsa",
					"lot",
					"lpi",
        );
      	break;
      case 'two':
        $logos = array(
					"mariadb",
					"mediatemple",
					"microsoft",
					"microway",
					"minio",
					"mozilla2",
					"mozilla",
					"mysql",
					"netapp",
					"nostarch",
					"opensuse",
					"opsgenie",
					"orabuntulxc",
					"osi",
					"owasp",
					"percona",
					"pia",
					"pivotal",
					"pogo",
					"postgresql",
					"pssclabs",
					"pssc",
					"qnap",
					"redhat",
					"salt",
					"saltstack",
					"scylla",
					"sensu",
					"shellcon",
					"sonatype",
					"suse",
					"swift",
					"symantec",
					"system76",
					"timescaledb",
					"tindle",
					"twistlock",
					"ubuntu",
					"uncoded",
					"usenix",
					"VDMS_Logo_secondary_three_lines_0",
					"verizon",
					"victorops",
					"videolan",
					"wavefront",
					"yocto",
					"yubico",
					"zabbix",
        );
        break;
    }
  }
?>

<div id="carousel1" class="sponsorCarousel carousel carousel-fade">
<div class="carousel-inner">
<?php
  shuffle($logos);
  for ($i = 0; $i < (count($logos) - 1); $i++) {
    $logo = array_pop($logos);
?>
    <div class="item sponsor-logo <?php if ( $i == 0 ) { echo 'active'; } ?>" >
        <img class="" src="images/sponsors/<?php echo "$logo"; ?>.png">
    </div>
<?php
   }
?>
</div>
</div>

<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/jquery.marquee.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">

  $(document).ready(function() {
      $('.sponsorCarousel').carousel({
        interval: 20000
      });
  });

</script>

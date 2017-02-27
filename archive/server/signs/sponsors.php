<?php
  if (!empty($_GET["group"])) {
    switch ($_GET["group"]) {
      case 'one':
        $logos = array(
                      "anchore",
                      "aredn",
                      "bitnami",
                      "blackduck",
                      "chef",
                      "collabnet",
                      "coreos",
                      "couchbase",
                      "cyberark",
                      "datadog",
                      "dellemc",
                      "disney",
                      "docker",
                      "everbridge",
                      "facebook",
                      "flexera",
                      "hpe",
                      "jfrog",
                      "linode",
                      "linuxacademy",
                      "linuxfoundation",
                      "linuxpro",
                      "mediatemple",
                      "minio",
                      "mysql",
                      "nats",
                      "netapp",
                      "nginx",
                      "openshift",
                      "opensource",
                      "openx",
                      "opsgenie",
                      "orabuntu",
                      "oreilly",
                      "percona",
                      "platform9",
                      "postgresql",
                      "procore",
                      "pssclabs",
                      "q",
                      "r1soft",
                      "rancher",
                      "redhat",
                      "resinio",
                      "saucelabs",
                      "signalsciences",
                      "sparkpost",
                      "stackiq",
                      "steelhouse",
                      "suse",
                      "symantec",
                      "threatstack",
                      "ticketmaster",
                      "ubuntu",
                      "usenix",
                      "verizon",
                      "versionone",
                      "victorops",
                      "vikidial",
                      "wavefront",
                      "yahoo",
                      "yocto",
                      "zabbix",
                    );
        break;
      //case 'two':
      //  $logos = range(67, 133);
      //  break;
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
        <img class="" src="images/sponsors/15x/<?php echo "$logo"; ?>.png">
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
        interval: 10000
      });
  });

</script>

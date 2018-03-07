<?php
  if (!empty($_GET["group"])) {
    switch ($_GET["group"]) {
      case 'one':
        $logos = array(
          "cars-com",
          "cyberark",
          "dellemc",
          "verizon",
          "mediatemple",
          "datadog",
          "victorops",
          "netapp",
          "wavefront",
          "facebook",
          "canonical",
          "everbridge",
          "chef",
          "redhat",
          "opsgenie",
          "microsoft",
                    );
        break;
      case 'two':
        $logos = array(
          "linuxacademy",
          "yocto",
          "mariadb",
          "saltstack",
          "linuxpro",
          "disney",
          "linode",
          "minio",
          "zabbix",
          "pssclabs",
          "blackduck",
          "suse",
          "mysql",
          "linbit",
          "system76",
          "percona",
          "usenix",
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
        <img class="" src="images/sponsors/16x/<?php echo "$logo"; ?>.png">
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

<?php
  if (!empty($_GET["group"])) {
    switch ($_GET["group"]) {
      case 'one':
        $logos = array(
             "arm.png",
             "camunda.png",
             "datadog.png",
             "edb.png",
             "instaclustr.png",
             "mysql.png", #oracle
             "newrelic.png",
             "percona.png",
             "percona.png",
             "pingcap.png",
             "postgresql.png",
             "site247.png",
             "stormforge.png",
             "ulia.png",
             "dbeaver.png",
             "fleet.png",
             "grafanalabs.png",
             "stickermule.png",
             "tailscale.png",
             "appscode.png",
             "aws.png",
             "canonical.png",
             "chainguard.png",
             "checkmk.png",
             "cloud_native_computing_foundation.png",
             "cloud_native_computing_foundation.png",
             "coder.png",
             "commitgo.png",
             "elastic.png",

        );
      	break;
      case 'two':
        $logos = array(
         "flox.png",
         "fossa.png",
         "fosslife.png",
         "framework.png",
         "freebsd.png",
         "fujitsu.png",
         "github.png",
         "google.png",
         "hasura.png",
         "honeycomb.png",
         "kubecareers.png",
         "kubeevents.png",
         "lakefs.png",
         "linbit.png",
         "linuxmagazine.png",
         "meta.png", #facebook
         "microsoft.png",
         "netknights.png",
         "opensource_jobhub.png",
         "perforce.png",
         "redhat.png",
         "redhat.png",
         "saucelabs.png",
         "siglens.png",
         "suse.png",
         "thunderbird.png",
         "warp.png",
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
        <img class="" src="images/sponsors/<?php echo "$logo"; ?>">
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

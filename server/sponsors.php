<?php
  if (!empty($_GET["group"])) {
    switch ($_GET["group"]) {
      case 'one':
        $logos = array(
          #"9to5linux.png",
          #"adminmagazine.png",
          #"allegrograph.png", #franz
          "arm.png",
          #"aws.png",
          "buildkite.png",
          "calyptia.png",
          "camunda.png",
          "ceph.png",
          #"chronosphere.png",
          "ciq.png",
          "circleci.png",
          #"cloudbees.png",
          "cloud_native_computing_foundation.png",
          #"coastlinecollege.png",
          #"courier.png",
          "databricks.png",
          "datadog.png",
          #"deepsource.png",
          #"digitalocean.png",
          #"dynatrace.png",
          #"faun.png",
          #"freebsd_foundation.png",
          #"edb.png",
          "elastic.png",
          #"era.png",
          "gitlab.png",
          #"gradle.png",
          #"gremlin.png",
          #"harness.png",
          #"hulanetworks.png",
          #"humio.png", #crowdstike
          "instaclustr.png",
          #"intellibus.png",
          #"itopia.png",
          "kubeevents.png",
          "linode.png",
          #"lpi.png",
          #"mattermost.png",
          "meta.png", #facebook
        );
      	break;
      case 'two':
        $logos = array(
	  "mondoo.png",
          "mysql.png", #oracle
          "newrelic.png",
          "nirmata.png",
          "observe.jpg",
          "octopusdeploy.png",
          "opennms.png",
          "opensuse.png",
          "percona.png",
          "pogo_linux.png",
          "postgresql.png",
          "portworx.png",
          "redhat.png",
          "replicated.png",
          "scoutapm.png",
          "site247.png",
          "spacelift.png",
          "sourceforge.png",
          "splunk.png",
          "spyderbat.png",
          "stacklet.png",
          "streamnative.png",
          "system76.png",
          "ubuntu.jpg",
          "uffizzi.png",
          "veryant.png",
          "vmware.png",
          "westernregionalcyberdefense.png",
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

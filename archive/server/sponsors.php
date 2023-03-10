<?php
  if (!empty($_GET["group"])) {
    switch ($_GET["group"]) {
      case 'one':
        $logos = array(
          #"9to5linux.png",
          #"adminmagazine.png",
          #"allegrograph.png", #franz
          "akuity.png",
          "asserts.png",
          "azul.png",
          "acorn.png",
          "arm.png",
          #"aws.png",
          "bayesian.png",
          "buildkite.png",
          "calyptia.png",
          "camunda.png",
          "ceph.png",
          #"chronosphere.png",
          "ciq.png",
          "circleci.png",
          "cisco_eti.png",
          #"cloudbees.png",
          "cloud_native_computing_foundation.png",
          "cyberark.png",
          #"coastlinecollege.png",
          #"courier.png",
          "databricks.png",
          "datadog.png",
          "datastax.png",
          "d2iq.png",
          "dbeaver.png",
          "fleet.png",
          #"deepsource.png",
          #"digitalocean.png",
          #"dynatrace.png",
          #"faun.png",
          #"freebsd_foundation.png",
          #"edb.png",
          "elastic.png",
          #"era.png",
          "github.png",
          "gitlab.png",
          "grafana.png",
          "google.png",
          #"gradle.png",
          #"gremlin.png",
          #"harness.png",
          #"hulanetworks.png",
          #"humio.png", #crowdstike
          "ieee_sa_open.png",
          "instaclustr.png",
          "isovalent.png",
          "isovalent.png",
          "ix_systems.png",
          #"intellibus.png",
          #"itopia.png",
          "kubeevents.png",
          "kloudfuse.png",
          "linode.png",
          "linbit.png",
          "loft.png",
          #"lpi.png",
          "mattermost.png",
          "meta.png", #facebook
          "maira.png",
        );
      	break;
      case 'two':
        $logos = array(
	  "nanovms.png",
	  "nginx.png",
	  #"mondoo.png",
          "mysql.png", #oracle
          #"newrelic.png",
          #"nirmata.png",
          #"observe.jpg",
          #"octopusdeploy.png",
          #"opennms.png",
          #"opensuse.png",
          "okteto.png",
          "opencost.png",
          "pagerduty.png",
          "pgedge.png",
          "percona.png",
          #"pogo_linux.png",
          "postgresql.png",
          "port.png",
          "prosperops.png",
          "quest.png",
          #"portworx.png",
          "redhat.png",
          "retool.png",
          #"replicated.png",
          #"scoutapm.png",
          "site247.png",
          "sonatype.png",
          #"spacelift.png",
          "sourceforge.png",
          "suse.png",
          #"splunk.png",
          "spyderbat.png",
          "synopsys.png",
          "temporal.png",
          "tetrate.png",
          "tuxcare.png",
          "cloud7.png",
          "fosslife.png",
          "freebsd.png",
          "its_foss.png",
          "linuxjournal.png",
          "linuxmagazine.png",
          "linux_org.png",
          "learnk8s.png",
          "opensource_jobhub.png",
          "opensource_watch.png",
          "stackhawk.png",
          "stickermule.png",
          "the_new_stack.png",
          "trendoceans.png",
          "tuxdigital.png",
          "intel.png",
          "tailscale.png",
          "the_linux_foundation_training.png",
          #"stacklet.png",
          #"streamnative.png",
          #"system76.png",
          "ubuntu.jpg",
          #"uffizzi.png",
          #"veryant.png",
          #"vmware.png",
          #"westernregionalcyberdefense.png",
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

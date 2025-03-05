<?php
  if (!empty($_GET["group"])) {
    switch ($_GET["group"]) {
      case 'one':
        $logos = array(
          "ampere.jpg",
          "automatedbuildings.jpg",
          "canonical.png",
          "clickhouse.png",
          "coder.png",
          "dagger.png",
          "dbeaver.png",
          "fosslife.png",
          "google.png",
          "gsjj.png",
          "kubecareers.png",
          "linbit.png",
          "meta.png",
          "mysql.png",
          "netappinstaclustr.png",
          "openintel.png",
          "owasp.png",
          "percona.png",
          "personalai.jpg",
          "postgresql.png",
          "redgate.jpg",
          "replit.png",
          "softwaredefinedtalk.jpg",
          "speedscale.png",
          "system76.png",
          "thunderbird.png",
          "tigera.png",
          "warpdev.png",
          "yogertpc.png",
          "zesty.png",
          "akamai.png",
          "checkmarx.png",
          "devzero.png",
          "firefly.png",
          "gruntwork.png",
          "jobst.png",
          "opsera.png",
          "runme.png",
          "semaphore.png",
          "companionintelligence.png",
          "glia.jpeg",
          "mimik.png",
          "jetstream.png",
          "openinfrafoundation.png",
          "purestorage.png",
          "zconverter.png",
          "heeler.png",
          "kodem.png",
        );
      	break;
      case 'two':
        $logos = array(
          "arm.png",
          "aws.png",
          "ciq.png",
          "cloudnativecomputingfoundation.png",
          "consuldemocracyfoundation.png",
          "datadog.png",
          "flox.png",
          "github.png",
          "grafanalabs.png",
          "isovalent.png",
          "kubeevents.png",
          "linuxmagazine.png",
          "microsoft.png",
          "netactuate.png",
          "netknights.png",
          "opensourcejobhub.png",
          "oxenai.png",
          "perforce.png",
          "pomerium.png",
          "quest.png",
          "redhat.png",
          "rockylinux.png",
          "softwarefreedomconservancy.png",
          "starnetcommunications.png",
          "tailscale.jpg",
          "thundercomm.png",
          "victoriametrics.png",
          "xata.png",
          "zabbix.png",
          "bellsoft.png",
          "couchbase.png",
          "dnsimple.png",
          "fluidattacks.png",
          "honeycombio.png",
          "kapstan.png",
          "parasoft.png",
          "sedai.png",
          "thales.png",
          "collabera.png",
          "cryptid.png",
          "kasm.png",
          "personalai.png",
          "planetnix.png",
          "lightbits.png",
          "openmetal.png",
          "rackspace.png",
          "pacifichackers.png",
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

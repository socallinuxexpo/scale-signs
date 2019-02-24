<?php
	if (!empty($_GET["group"])) {
    switch ($_GET["group"]) {
      case 'one':
        $logos = array(
					"arden.jpg",
					"attivo.png",
					"bareos.jpg",
					"chef.png",
					"cloud_native_computing_foundation.png",
					"code_fresh.png",
					"crunchy_data.png",
					"datadog.png",
					"debian.png",
					"disney.png",
					"eff.png",
					"eliassen_group.png",
					"fast_reports.png",
					"fedora.png",
					"fossa.png",
					"freebsd.png",
					"gentoo.png",
					"gnome.png",
					"google_cloud.png",
					"hackaday.png",
					"hubblestack.png",
					"ibm.jpg",
					"itdrc.jpeg",
					"jenkins.jpg",
					"layerone.png",
					"linode.png",
					"linux_foundation.png",
					"logdna.png",
					"lopsa.png",
					"lutris.png",
					"maven_code.png",
					"mysql.png",
					"nylas.png",
					"opensource.png",
					"opsi.png",
					"postgresql.png",
					"purism.png",
					"qnap.png",
					"redgate.png",
					"reverse_shell_corporation.png",
					"shellcon.png",
					"skysilk.png",
					"softiron.png",
					"stackrox.png",
					"svghack.png",
					"synopsys.jpg",
					"think_penguin.jpg",
					"twilio.png",
					"uncoded.png",
					"verizon.png",
					"victorops.png",
					"vmware.png",
					"whitesource.png",
        );
      	break;
      case 'two':
        $logos = array(
					"all_things_open.png",
					"arrikto.png",
					"aws.png",
					"big_data_day_la.png",
					"cirro.png",
					"cloudbees.png",
					"cribl.png",
					"cyberark_conjur.png",
					"dc_darknet.jpeg",
					"diamanti.png",
					"dynatrace.png",
					"elastic.png",
					"facebook.png",
					"faunadb.png",
					"floqast.png",
					"free_software_foundation.png",
					"freebsd_foundation.png",
					"gitlab.png",
					"gnu_health.png",
					"gravitational.png",
					"hashicorp.png",
					"humio.png",
					"invoca.png",
					"ix_systems.png",
					"kde.png",
					"linbit.png",
					"linux_chix.jpg",
					"linux_journal.jpg",
					"logz.png",
					"lpi.png",
					"mariadb.png",
					"microsoft.png",
					"newrelic.png",
					"openembedded.png",
					"opensuse.png",
					"pogo_linux.png",
					"pssc_labs.png",
					"pyladies.png",
					"rancher.png",
					"redhat.png",
					"scalyr.png",
					"signalfx.png",
					"smci.jpg",
					"sonatype.png",
					"sumologic.png",
					"swift.png",
					"system76.png",
					"transformix.png",
					"ubuntu.jpg",
					"usenix.png",
					"vertical_sysadmin.png",
					"videolan.png",
					"wavefront.jpg",
					"yubico.png",
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

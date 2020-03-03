<?php
  if (!empty($_GET["group"])) {
    switch ($_GET["group"]) {
      case 'one':
        $logos = array(
					"microsoft.png",
					"cloud_native_computing_foundation.png",
					"logz.png",
					"splunk.png",
					"disney.png",
					"all_things_open.png",
					"arista.png",
					"bareos.jpg",
					"chaossearch.png",
					"datadog.png",
					"elastic.png",
					"instaclustr.png",
					"linbit.png",
					"memsql.png",
					"openlogic.png",
					"orchid.png",
					"percona.png",
					"saltstack.png",
					"softiron.png",
					"taos.png",
					"trendmicro.png",
					"turris.png",
					"wavefront.jpg",
					"zabbix.png",
					"postgresql.png",
					"linuxpro.png",
					"usenix.png",
					"gitlab.png",
        );
      	break;
      case 'two':
        $logos = array(
					"aws.png",
					"facebook.png",
					"redhat.png",
					"square.png",
					"vmware.png",
					"arm.png",
					"bitergia.png",
					"ceph.png",
					"coastlinecollege.png",
					"datastax.png",
					"gumgum.png",
					"ix_systems.png",
					"linode.png",
					"mysql.png",
					"opsi.png",
					"pennymac.png",
					"panetscale.png",
					"shiftleft.png",
					"system76.png",
					"tigera.png",
					"think_penguin.jpg",
					"uclalawschool.png",
					"westernregionalcyberdefense.png",
					"vmware.png",
					"freebsd_foundation.png",
					"stickermule.png",
					"raiseme.png",
					"lpi.png",
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

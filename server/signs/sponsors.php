<?php
  if (!empty($_GET["group"])) {
    switch ($_GET["group"]) {
      case 'one':
        $logos = range(1, 21);
        break;
      case 'two':
        $logos = range(22, 37);
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
        <img class="" src="images/sponsors/<?php if ( $logo < 10 ) { echo "0" . $logo; } else { echo "$logo"; } ?>.png">
    </div>
<?php
   }
?>      
</div>
</div>

<script src="js/jquery-1.8.2.js"></script>    
<script src="js/jquery.marquee.js"></script>    
<script src="bootstrap/js/bootstrap.js"></script>
<script type="text/javascript">

  $(document).ready(function() {
      $('.sponsorCarousel').carousel({
        interval: 10000
      });
  });
      
</script>

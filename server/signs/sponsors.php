<ul class="sponsorList">
  <li>
    <div id="carousel1" class="sponsorCarousel carousel carousel-fade">
      <div class="carousel-inner">
<?php 
  $logos = range(1, 39);
  $logos_per_page = 10;

  shuffle($logos);  
  for ($i = 0; $i < 32 ; $i++) {
    $logo = array_pop($logos);
    if ( $i % $logos_per_page == 0 && $i > 0 ) {
      print "<li>";
        print '<div class="sponsorCarousel carousel carousel-fade">';
          print '<div class="carousel-inner">';
    }
?>
    <!-- <div class="item sponsor-logo <?php if ( $i % $logos_per_page == 0 ) { echo 'active'; } ?>" style="background-image: url('images/sponsors/<?php if ( $logo < 10 ) { echo "0" . $logo; } else { echo "$logo"; } ?>.png')"> -->
    <div class="item sponsor-logo <?php if ( $i % $logos_per_page == 0 ) { echo 'active'; } ?>" >
      <img class="" src="images/sponsors/<?php if ( $logo < 10 ) { echo "0" . $logo; } else { echo "$logo"; } ?>.png">
    </div>
<?php
   }
?>      
      </div>
    </div>
  </li>
</ul>

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
  

<!--
<ul class="thumbnails sponsorList">
  <li>
    <div id="carousel1" class="sponsorCarousel carousel carousel-fade">
      <div class="carousel-inner">
<?php 
  $logos = range(1, 32);
  $logos_per_page = 10;

  shuffle($logos);  
  for ($i = 0; $i < 32 ; $i++) {
    $logo = array_pop($logos);
    if ( $i % $logos_per_page == 0 && $i > 0 ) {
      print "<li>";
        print '<div class="sponsorCarousel carousel carousel-fade">';
          print '<div class="carousel-inner">';
    }
?>
    <div class="item sponsor-logo <?php if ( $i % $logos_per_page == 0 ) { echo "active"; } ?>">
      <img class="thumbnail" src="images/sponsors/<?php if ( $logo < 10 ) { echo "0" . $logo; } else { echo "$logo"; } ?>.png">
    </div>
<?php
   }
?>      
      </div>
    </div>
  </li>
</ul>

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
  
-->
                
                
                
                
                







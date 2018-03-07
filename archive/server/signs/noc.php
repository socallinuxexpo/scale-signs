<?php

  $carousel_one = array(
    0 => array("name" => 'Current Wi-Fi Associations', "graph" => "noc/aggregate-6hourly-live.png" ),
    1 => array("name" => 'Total Wi-Fi Associations', "graph" => "noc/unique-6hourly-live.png" ),
    );

  $carousel_two = array(
    0 => array("name" => 'Show Floor Bandwidth Usage', "graph" => "noc/combined-day.png" ),
    1 => array("name" => 'Top Wi-Fi Device Manufacturers', "graph" => "noc/wifi_pie.png" ),
    );

  $carousel_three = array(
    0 => array("name" => 'Wi-Fi Spectrum Usage', "graph" => "noc/sums-6hourly-live.png" ),
    1 => array("name" => 'Total Internet Bandwidth Usage', "graph" => "noc/gateway-2.expo.socallinuxexpo.org-2-day.png" ),
    );

?>

<?php
  if (!empty($_GET["carousel"])) {
    switch ($_GET["carousel"]) {
      case 'one':
        $carousel_array = $carousel_one;
        break;
      case 'two':
        $carousel_array = $carousel_two;
        break;
      case 'three':
        $carousel_array = $carousel_three;
        break;
      case 'four':
        $carousel_array = $carousel_four;
        break;
      case 'five':
        $carousel_array = $carousel_five;
        break;
      case 'six':
        $carousel_array = $carousel_six;
        break;
    }
    for ($x = 0; $x < sizeof($carousel_array); $x++)
    {
      if ($x == 0) {
        echo "<!-- item active -->";
        echo "<div class='item active'>";
      } else {
        echo "<!-- item -->";
        echo "<div class='item'>";
      }
      echo "<!-- item -->";
      printf("<div><h3>%s</h3><img class='graph-image' src='images/%s'></div>", $carousel_array[$x]['name'], $carousel_array[$x]['graph']);
      echo "</div>";
    }
  } else {
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="refresh" content="300">
    <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

    <title>SCALE 16x <?php echo $orientation; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="grid.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="container main-container">

      <div class="header row">
          <!-- <img src="images/noc-penguin-header5.png"> -->
      </div>

      <div class="row"><hr></div>

      <?php if ($orientation == 'vertical') { ?>

      <!-- Begin Row -->
      <div class="row graph-row">
        <div class="graph col-md-12">
          <!-- Carousel One -->
          <div class="carousel carousel-fade" data-ride="carousel" data-interval="30000">
            <div id="carousel_one" class="carousel-inner">
            </div>
            <!-- End Carousel Inner -->
          </div>
          <!-- End Carousel One -->
        </div>
      </div>
      <!-- End Row -->

      <!-- Begin Row -->
      <div class="row graph-row">
        <div class="graph col-md-12">
          <!-- Carousel Four -->
          <div class="carousel carousel-fade" data-ride="carousel" data-interval="30000">
            <div id="carousel_two" class="carousel-inner">
            </div>
            <!-- End Carousel Inner -->
          </div>
          <!-- End Carousel Four -->
        </div>
      </div>
      <!-- End Row -->

      <!-- Begin Row -->
      <div class="row graph-row">
        <div class="graph col-md-12">
          <!-- Carousel Four -->
          <div class="carousel carousel-fade" data-ride="carousel" data-interval="30000">
            <div id="carousel_three" class="carousel-inner">
            </div>
            <!-- End Carousel Inner -->
          </div>
          <!-- End Carousel Four -->
        </div>
      </div>
      <!-- End Row -->

      <div class="row"><hr></div>

      <div class="header row">
          <!-- <img src="images/noc-penguin-header5.png"> -->
      </div>

      ?php } else { ?>

      <!-- Begin Row -->
      <div class="row graph-row">
        <div class="graph col-md-4">
          <!-- Carousel One -->
          <div class="carousel carousel-fade" data-ride="carousel" data-interval="30000">
            <div id="carousel_one" class="carousel-inner">
            </div>
            <!-- End Carousel Inner -->
          </div>
          <!-- End Carousel One -->
        </div>

        <div class="graph col-md-4">
          <!-- Carousel Four -->
          <div class="carousel carousel-fade" data-ride="carousel" data-interval="30000">
            <div id="carousel_two" class="carousel-inner">
            </div>
            <!-- End Carousel Inner -->
          </div>
          <!-- End Carousel Four -->
        </div>

        <div class="graph col-md-4">
          <!-- Carousel Four -->
          <div class="carousel carousel-fade" data-ride="carousel" data-interval="30000">
            <div id="carousel_three" class="carousel-inner">
            </div>
            <!-- End Carousel Inner -->
          </div>
          <!-- End Carousel Four -->
        </div>
      </div>
      <!-- End Row -->

      <div class="row"><hr></div>

      <div class="header row">
          <!-- <img src="images/noc-penguin-header5.png"> -->
      </div>

      <?php } ?>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  <script src="js/jquery-1.10.2.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript">

  $(document).ready(function() {

    // Ensure we're not caching data
    $.ajaxSetup ({
      cache: false
    });

    // updateClock();
    // setInterval('updateClock()', 1000 );

    // Hide the schedule until we've loaded the data
    $('#carousel_one').hide();

    var CarouselUpdateTime = 600000;
    var CarouselOneUrl = "noc.php?carousel=one";
    var CarouselTwoUrl = "noc.php?carousel=two";
    var CarouselThreeUrl = "noc.php?carousel=three";

    $("#carousel_one").load(CarouselOneUrl);
    $("#carousel_one").show();

    $("#carousel_two").load(CarouselTwoUrl);
    $("#carousel_two").show();

    $("#carousel_three").load(CarouselThreeUrl);
    $("#carousel_three").show();

    /* Reload and Refresh Carousel One once a minute */
    var CarouselOneRefreshId = setInterval(function() {
      $("#carousel_one").load(CarouselOneUrl);
    }, 60000);

    /* Reload and Refresh Carousel Two once a minute */
    var CarouselTwoRefreshId = setInterval(function() {
      $("#carousel_two").load(CarouselTwoUrl);
    }, 60000);

    /* Reload and Refresh Carousel Three once a minute */
    var CarouselThreeRefreshId = setInterval(function() {
      $("#carousel_three").load(CarouselThreeUrl);
    }, 60000);

  /* Check the page type */
  var checkPageTypeId = setInterval(function() {
      var pageType = $.ajax({type: "GET", url: "type.php", async: false}).responseText;
      if (pageType != 'noc' && pageType != '') {
          console.log('Type changed, reloading')
          location.reload()
      }
  }, 300000);

  });

  </script>
  </body>
</html>

<?php
  }
?>

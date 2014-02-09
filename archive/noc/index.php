<?php
  $carousel_one = array(
    0 => array("name" => 'Show Floor 3', "graph" => "show-floor-3-ap-daily.png" ),
    1 => array("name" => 'Show Floor 2', "graph" => "show-floor-2-ap-daily.png" ),
    2 => array("name" => 'Show Floor 6', "graph" => "show-floor-6-ap-daily.png" ),
    3 => array("name" => 'Show Floor 4', "graph" => "show-floor-4-ap-daily.png" ),
    4 => array("name" => 'Show Floor 5', "graph" => "show-floor-5-ap-daily.png" ),
    5 => array("name" => 'Show Floor 1', "graph" => "show-floor-1-ap-daily.png" ),    
    );

  $carousel_two = array(
    0 => array("name" => 'Show Floor 1', "graph" => "show-floor-1-ap-daily.png" ),
    1 => array("name" => 'Show Floor 4', "graph" => "show-floor-4-ap-daily.png" ),
    2 => array("name" => 'Show Floor 3', "graph" => "show-floor-3-ap-daily.png" ),
    3 => array("name" => 'Show Floor 5', "graph" => "show-floor-5-ap-daily.png" ),
    4 => array("name" => 'Show Floor 2', "graph" => "show-floor-2-ap-daily.png" ),
    5 => array("name" => 'Show Floor 6', "graph" => "show-floor-6-ap-daily.png" ),    
    );

  $carousel_three = array(
    0 => array("name" => 'Show Floor 1', "graph" => "show-floor-1-ap-daily.png" ),
    1 => array("name" => 'Show Floor 2', "graph" => "show-floor-2-ap-daily.png" ),
    2 => array("name" => 'Show Floor 3', "graph" => "show-floor-3-ap-daily.png" ),
    3 => array("name" => 'Show Floor 4', "graph" => "show-floor-4-ap-daily.png" ),
    4 => array("name" => 'Show Floor 5', "graph" => "show-floor-5-ap-daily.png" ),
    5 => array("name" => 'Show Floor 6', "graph" => "show-floor-6-ap-daily.png" ),    
    );

  $carousel_four = array(
    0 => array("name" => 'Show Floor 1', "graph" => "show-floor-1-ap-daily.png" ),
    1 => array("name" => 'Show Floor 2', "graph" => "show-floor-2-ap-daily.png" ),
    2 => array("name" => 'Show Floor 3', "graph" => "show-floor-3-ap-daily.png" ),
    3 => array("name" => 'Show Floor 4', "graph" => "show-floor-4-ap-daily.png" ),
    4 => array("name" => 'Show Floor 5', "graph" => "show-floor-5-ap-daily.png" ),
    5 => array("name" => 'Show Floor 6', "graph" => "show-floor-6-ap-daily.png" ),    
    );      

  $carousel_five = array(
    0 => array("name" => 'Show Floor 1', "graph" => "show-floor-1-ap-daily.png" ),
    1 => array("name" => 'Show Floor 2', "graph" => "show-floor-2-ap-daily.png" ),
    2 => array("name" => 'Show Floor 3', "graph" => "show-floor-3-ap-daily.png" ),
    3 => array("name" => 'Show Floor 4', "graph" => "show-floor-4-ap-daily.png" ),
    4 => array("name" => 'Show Floor 5', "graph" => "show-floor-5-ap-daily.png" ),
    5 => array("name" => 'Show Floor 6', "graph" => "show-floor-6-ap-daily.png" ),    
    );

  $carousel_six = array(
    0 => array("name" => 'Show Floor 1', "graph" => "show-floor-1-ap-daily.png" ),
    1 => array("name" => 'Show Floor 2', "graph" => "show-floor-2-ap-daily.png" ),
    2 => array("name" => 'Show Floor 3', "graph" => "show-floor-3-ap-daily.png" ),
    3 => array("name" => 'Show Floor 4', "graph" => "show-floor-4-ap-daily.png" ),
    4 => array("name" => 'Show Floor 5', "graph" => "show-floor-5-ap-daily.png" ),
    5 => array("name" => 'Show Floor 6', "graph" => "show-floor-6-ap-daily.png" ),    
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
    <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

    <title>SCALE 12x</title>

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
          <img src="noc-penguin-header4.png">
      </div>

      <div class="row"><hr></div>

      <!-- Begin Row -->
      <div class="row graph-row">
        <div class="graph col-md-4">
          <!-- Carousel One -->        
          <div class="carousel carousel-fade" data-ride="carousel" data-interval="5000">
            <div id="carousel_one" class="carousel-inner">
            </div>
            <!-- End Carousel Inner -->
          </div>
          <!-- End Carousel One -->
        </div>
        <div class="graph col-md-4">
          <!-- Carousel Two -->        
          <div class="carousel carousel-fade" data-ride="carousel" data-interval="5000">
            <div id="carousel_two" class="carousel-inner">
            </div>
            <!-- End Carousel Inner -->
          </div>
          <!-- End Carousel Two -->
        </div>
        <div class="graph col-md-4">
          <!-- Carousel Three -->        
          <div class="carousel carousel-fade" data-ride="carousel" data-interval="5000">
            <div id="carousel_three" class="carousel-inner">
            </div>
            <!-- End Carousel Inner -->
          </div>
          <!-- End Carousel Three -->
        </div>
      </div>
      <!-- End Row -->

      <!-- Begin Row -->
      <div class="row graph-row">
        <div class="graph col-md-4">
          <!-- Carousel Four -->        
          <div class="carousel carousel-fade" data-ride="carousel" data-interval="5000">
            <div id="carousel_four" class="carousel-inner">
            </div>
            <!-- End Carousel Inner -->
          </div>
          <!-- End Carousel Four -->
        </div>
        <div class="graph col-md-4">
          <!-- Carousel Five -->        
          <div class="carousel carousel-fade" data-ride="carousel" data-interval="5000">
            <div id="carousel_five" class="carousel-inner">
            </div>
            <!-- End Carousel Inner -->
          </div>
          <!-- End Carousel Five -->
        </div>
        <div class="graph col-md-4">
          <!-- Carousel Six -->        
          <div class="carousel carousel-fade" data-ride="carousel" data-interval="5000">
            <div id="carousel_six" class="carousel-inner">
            </div>
            <!-- End Carousel Inner -->
          </div>
          <!-- End Carousel Six -->
        </div>
      </div>
      <!-- End Row -->
      

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>    
  <script src="bootstrap/js/bootstrap.js"></script>
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
    var CarouselOneUrl = "index.php?carousel=one";
    var CarouselTwoUrl = "index.php?carousel=two";
    var CarouselThreeUrl = "index.php?carousel=three";
    var CarouselFourUrl = "index.php?carousel=four";
    var CarouselFiveUrl = "index.php?carousel=five";
    var CarouselSixUrl = "index.php?carousel=six";

    $("#carousel_one").load(CarouselOneUrl);
    $("#carousel_one").show();

    $("#carousel_two").load(CarouselTwoUrl);
    $("#carousel_two").show();

    $("#carousel_three").load(CarouselThreeUrl);
    $("#carousel_three").show();

    $("#carousel_four").load(CarouselFourUrl);
    $("#carousel_four").show();

    $("#carousel_five").load(CarouselFiveUrl);
    $("#carousel_five").show();

    $("#carousel_six").load(CarouselSixUrl);
    $("#carousel_six").show();

    /* Reload and Refresh Carousel One once a minute */
    var CarouselOneRefreshId = setInterval(function() {
      $("#carousel_one").load(CarouselOneUrl);
    }, CarouselUpdateTime);

    /* Reload and Refresh Carousel Two once a minute */
    var CarouselTwoRefreshId = setInterval(function() {
      $("#carousel_two").load(CarouselTwoUrl);
    }, CarouselUpdateTime);

    /* Reload and Refresh Carousel Three once a minute */
    var CarouselThreeRefreshId = setInterval(function() {
      $("#carousel_three").load(CarouselThreeUrl);
    }, CarouselUpdateTime);        

    /* Reload and Refresh Carousel Four once a minute */
    var CarouselFourRefreshId = setInterval(function() {
      $("#carousel_four").load(CarouselFourUrl);
    }, CarouselUpdateTime);        

    /* Reload and Refresh Carousel Five once a minute */
    var CarouselFiveRefreshId = setInterval(function() {
      $("#carousel_five").load(CarouselFiveUrl);
    }, CarouselUpdateTime);        

    /* Reload and Refresh Carousel Six once a minute */
    var CarouselSixRefreshId = setInterval(function() {
      $("#carousel_six").load(CarouselSixUrl);
    }, CarouselUpdateTime);        
  });

  </script>
  </body>
</html>

<?php
  }
?>


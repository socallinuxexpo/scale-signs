<?php

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
    <!-- <link href="grid.css" rel="stylesheet"> -->
    <link href="style.css" rel="stylesheet">

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
        <div class="col-md-8">
          <img src="header.png">
        </div>

        <div class="col-md-4">            
          <ul class="clock pull-right">
            <li><div id="h1" class="card">&nbsp;</div></li>
            <li><div id="h2" class="card">&nbsp;</div></li>          
            <li class="separator">:</li>
            <li><div id="m1" class="card">&nbsp;</div></li>
            <li><div id="m2" class="card">&nbsp;</div></li>
            <!--
            <li class="separator">:</li>
            <li><div id="s1" class="card">&nbsp;</div></li>
            <li><div id="s2" class="card">&nbsp;</div></li>
            -->
            <li class="separator">&nbsp;</li>          
            <li><div id="meridiem1" class="card">&nbsp;</div></li>
            <li><div id="meridiem2" class="card">&nbsp;</div></li>
          </ul>
        </div>

      </div>

      <div class="row"><hr></div>

      <!-- Begin Row -->
      
      <div class="row graph-row">
        <div class="graph col-md-12">
          <div id="schedule" class="row schedule"></div>
        </div>
      </div>
      <!-- End Row -->

      <div class="row"><hr></div>

      <div class="row graph-row">
        <div class="col-md-3">
          <div id="sponsors1">
          </div>
        </div>

        <div class="graph col-md-6">
          <div id="twitter-stream-content" class="row"></div>
        </div>

        <div class="col-md-3">
          <div id="sponsors2" class="pull-right">
          </div>
        </div>

      </div>
      <!-- End Row -->

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>    
  <script src="bootstrap/js/bootstrap.js"></script>
  <script src="js/clock.js"></script>
  <script src="js/timer.js"></script>

  <script type="text/javascript">
    
    $(document).ready(function() {

      // Ensure we're not caching data
      $.ajaxSetup ({
        cache: false  
      });
      
      updateClock();
      setInterval('updateClock()', 1000);

      // Hide the schedule until we've loaded the data
      $('#schedule').hide();
      $('#sponsors').hide();      
      $('#twitter-stream-content').hide();
      
      var loadScheduleUrl = "scroll.php";
      $("#schedule").load(loadScheduleUrl);
      $("#schedule").show();

      var loadSponsorsUrlOne = "sponsors.php?group=one";
      $("#sponsors1").load(loadSponsorsUrlOne);
      $("#sponsors1").show();

      var loadSponsorsUrlTwo = "sponsors.php?group=two";
      $("#sponsors2").load(loadSponsorsUrlTwo);
      $("#sponsors2").show();
      
      var loadTwitterUrl = "twitter.php";
      $("#twitter-stream-content").load(loadTwitterUrl);
      $('#twitter-stream-content').show();
      
      /* Reload and Refresh Twitter once a minute */
      var twitterRefreshId = setInterval(function() {
        //("#twitter-stream-content").fadeOut("slow").load(loadTwitterUrl).fadeIn("slow");
        $("#twitter-stream-content").load(loadTwitterUrl);        
      }, 60000);

      /* Reload & Shuffle sponsors every 2 minutes */
      var sponsors1RefreshId = setInterval(function() {
        //$("#sponsors").fadeOut("slow").load(loadSponsorsUrl).fadeIn("slow");
        $("#sponsors1").load(loadSponsorsUrl);        
      }, 120000);

       var sponsors2RefreshId = setInterval(function() {
        //$("#sponsors").fadeOut("slow").load(loadSponsorsUrl).fadeIn("slow");
        $("#sponsors2").load(loadSponsorsUrl);        
      }, 120000);
     
      /* Reload and Refresh Schedule once a minute */
      var scheduleRefreshId = setInterval(function() {
        //$("#schedule").fadeOut("slow").load(loadScheduleUrl).fadeIn("slow");
        $("#schedule").load(loadScheduleUrl);        
      }, 60000);
      
    });
        
    </script>
  </body>
</html>

<?php
  }
?>


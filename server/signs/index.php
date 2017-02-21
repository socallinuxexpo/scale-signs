<?php
  include 'ChromePhp.php';

  #$client = $_SERVER['HTTP_CLIENT_IP'];
  $client = $_SERVER["REMOTE_ADDR"];
  ChromePhp::log("client is $client");

  include('room_map.php');

  if (in_array($client, array_keys($room_map))) {
    switch($room_map[$client]['type']) {
        case 'noc':
            noc_sign($room_map[$client]['orientation']);
            break;
        case 'room':
            $year = $month = $day = $hour = $minute = '';
            if (!empty($_GET["year"])) {
                $year = $_GET['year'];
            }
            if (!empty($_GET["month"])) {
                $month = $_GET['month'];
            }
            if (!empty($_GET["day"])) {
                $day = $_GET['day'];
            }
            if (!empty($_GET["hour"])) {
                $hour = $_GET['hour'];
            }
            if (!empty($_GET["minute"])) {
                $minute = $_GET['minute'];
            }
            if (!empty($_GET["room"])) {
                room($_GET["room"], $year, $month, $day, $hour, $minute);
            } else {
                room($room_map[$client]["room"], $year, $month, $day, $hour, $minute);
            }
            break;
        case 'schedule':
            $year = $month = $day = $hour = $minute = '';
            if (!empty($_GET["year"])) {
                $year = $_GET['year'];
            }
            if (!empty($_GET["month"])) {
                $month = $_GET['month'];
            }
            if (!empty($_GET["day"])) {
                $day = $_GET['day'];
            }
            if (!empty($_GET["hour"])) {
                $hour = $_GET['hour'];
            }
            if (!empty($_GET["minute"])) {
                $minute = $_GET['minute'];
            }
            main($year, $month, $day, $hour, $minute);
            break;
        default:
            main();
            break;
    }
  } else {
      if (!empty($_GET["room"])) {
        switch ($_GET["room"]) {
            case 'ballroom-de':
            case 'ballroom-a':
            case 'ballroom-b':
            case 'ballroom-c':
            case 'ballroom-f':
            case 'ballroom-g':
            case 'ballroom-h':
            case 'ballroom-gh':
            case 'ballroom-i':
            case 'ballroom-j':
            case 'room-101':
            case 'room-103':
            case 'room-104':
            case 'room-106':
            case 'room-107':
            case 'room-211':
            case 'room-212':
            case 'room-209':
            case 'room-205':
            case 'room-215':
                $year = $month = $day = $hour = $minute = '';
                if (!empty($_GET["year"])) {
                    $year = $_GET['year'];
                }
                if (!empty($_GET["month"])) {
                    $month = $_GET['month'];
                }
                if (!empty($_GET["day"])) {
                    $day = $_GET['day'];
                }
                if (!empty($_GET["hour"])) {
                    $hour = $_GET['hour'];
                }
                if (!empty($_GET["minute"])) {
                    $minute = $_GET['minute'];
                }
                room($_GET["room"], $year, $month, $day, $hour, $minute);
                break;
            case 'room-205':
            case 'AV':
            case 'av':
                avnoc();
                break;
            case 'NOC':
            case 'noc':
                noc_sign('vertical');
                break;
            default:
                $year = $month = $day = $hour = $minute = '';
                if (!empty($_GET["year"])) {
                    $year = $_GET['year'];
                }
                if (!empty($_GET["month"])) {
                    $month = $_GET['month'];
                }
                if (!empty($_GET["day"])) {
                    $day = $_GET['day'];
                }
                if (!empty($_GET["hour"])) {
                    $hour = $_GET['hour'];
                }
                if (!empty($_GET["minute"])) {
                    $minute = $_GET['minute'];
                }
                main($year, $month, $day, $hour, $minute);
                break;
        }
      } else {
        $year = $month = $day = $hour = $minute = '';
        if (!empty($_GET["year"])) {
            $year = $_GET['year'];
        }
        if (!empty($_GET["month"])) {
            $month = $_GET['month'];
        }
        if (!empty($_GET["day"])) {
            $day = $_GET['day'];
        }
        if (!empty($_GET["hour"])) {
            $hour = $_GET['hour'];
        }
        if (!empty($_GET["minute"])) {
            $minute = $_GET['minute'];
        }
        main($year, $month, $day, $hour, $minute);
      }
  }
?>

<!--- Main -->
<?php
function main($year = '', $month = '', $day = '', $hour = '', $minute = '') {
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

    <title>SCALE 15x</title>

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
    <div id='top-container' class="container main-container">

      <div id='header-row' class="header row">
        <div class="col-md-4">
          <img src="images/15x/header.png">
        </div>

        <div class="col-md-4">
          <img src="images/15x/WiFi-Sign2.png" class="pull-right">
        </div>

        <!--
        <div class="col-md-4">            
          <ul class="clock pull-right">
            <li><div id="h1" class="card">&nbsp;</div></li>
            <li><div id="h2" class="card">&nbsp;</div></li>          
            <li class="separator">:</li>
            <li><div id="m1" class="card">&nbsp;</div></li>
            <li><div id="m2" class="card">&nbsp;</div></li>
            <li class="separator">&nbsp;</li>          
            <li><div id="meridiem1" class="card">&nbsp;</div></li>
            <li><div id="meridiem2" class="card">&nbsp;</div></li>
          </ul>
        </div>
        -->
      </div>

      <div id='schedule-row-hr' class="row"><hr></div>

      <!-- Begin Row -->
      
      <div id="schedule-row" class="row graph-row">
        <div class="graph col-md-12">
          <div id="schedule" class="row schedule"></div>
        </div>
      </div>
      <!-- End Row -->

      <div class="row"><hr id='bottom-row-hr'></div>

    </div> <!-- /container -->
    <div id='bottom-container' class="container main-container">

      <div id="bottom-row" class="row graph-row">
        <div class="col-md-3">
          <div id="sponsors1">
          </div>
        </div>

        <div id="twitter-column" class="graph col-md-6">
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
  <script src="js/jquery-1.10.2.min.js"></script>
  <script src="bootstrap/js/bootstrap.js"></script>
  <!-- <script src="js/clock.js"></script> -->
  <script src="js/timer.js"></script>

  <script type="text/javascript">

    function hexToRgb(hex) {
        var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16)
        } : null;
    }

    function refreshData()
    {
        x = 1;  // x = seconds
        var d = new Date()
        var h = d.getHours();
        var m = d.getMinutes();
        var s = d.getSeconds();
        
        if (h<=9) {h = '0'+h};
        if (m<=9) {m = '0'+m};
        if (s<=9) {s = '0'+s};
        
        //var color = '#'+h+m+s;
        var color = hexToRgb('#'+h+m+s);
        var color_rgba = "rgba(" + [color.r, color.g, color.b, '0.9'].join(', ') + ")";
        
        $("#schedule-row-hr").css("background-color", color_rgba );

        setTimeout(refreshData, x*1000);
    }

    //refreshData();

    $(document).ready(function() {

      // Ensure we're not caching data
      $.ajaxSetup ({
        cache: false  
      });
      
      //updateClock();
      //setInterval('updateClock()', 1000);

      // Hide the schedule until we've loaded the data
      $('#schedule').hide();
      $('#sponsors').hide();      
      $('#twitter-stream-content').hide();
      
      var loadScheduleUrl = "scroll.php?year=<?php echo $year;?>&month=<?php echo $month;?>&day=<?php echo $day;?>&hour=<?php echo $hour;?>&minute=<?php echo $minute;?>";
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
        $("#sponsors1").load(loadSponsorsUrlOne);        
      }, 120000);

       var sponsors2RefreshId = setInterval(function() {
        //$("#sponsors").fadeOut("slow").load(loadSponsorsUrl).fadeIn("slow");
        $("#sponsors2").load(loadSponsorsUrlTwo);        
      }, 120000);
     
      /* Reload and Refresh Schedule once a minute */
      var scheduleRefreshId = setInterval(function() {
        //$("#schedule").fadeOut("slow").load(loadScheduleUrl).fadeIn("slow");
        $("#schedule").load(loadScheduleUrl);        
      }, 60000);
      
      /* Check the page type */
      var checkPageTypeId = setInterval(function() {
          var pageType = $.ajax({type: "GET", url: "type.php", async: false}).responseText;
          if (pageType != 'schedule' && pageType != '') {
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

<!--- AV NoC Room -->
<?php
function avnoc() {
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

    <title>SCALE 15x</title>

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
          <img src="images/15x/header.png">
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
      <!-- End Row -->

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  <script src="js/jquery-1.10.2.min.js"></script>
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
      
      var loadScheduleUrl = "scroll.php";
      $("#schedule").load(loadScheduleUrl);
      $("#schedule").show();

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

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

    <title>SCALE 14x: <?php echo $room_lookup_table[$room]; ?></title>

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
      <div class="header row" style="text-align: center;">
        <div class="" style='text-align: center;'>
          <img src="images/15x/header.png">
        </div>
      </div>
      <!-- <div class="row roomHeader"><h3>Coming Up</h3></div> -->
      <div class="row graph-row roomHeader"><h3><?php echo $room_lookup_table[$room]; ?></h3></div>

      <!-- Begin Row -->
      <div class="row graph-row">
        <div class="graph col-md-12">
          <div id="schedule" class="row schedule"></div>
        </div>
      </div>
      <!-- End Row -->

    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  <script src="js/jquery-1.10.2.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <script src="js/clock.js"></script>
  <script src="js/timer.js"></script>

  <script type="text/javascript">


    $(document).ready(function() {

      // Ensure we're not caching data
      $.ajaxSetup ({
        cache: false  
      });
      
      // Hide the schedule until we've loaded the data
      $('#schedule').hide();
      
      var loadScheduleUrl = "room.php?room=<?php echo $room; ?>&year=<?php echo $year;?>&month=<?php echo $month;?>&day=<?php echo $day;?>&hour=<?php echo $hour;?>&minute=<?php echo $minute;?>";
      $("#schedule").load(loadScheduleUrl);
      $("#schedule").show();

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

<!--- NOC Room Display -->
<?php
function noc_sign($orientation) {
    include('noc.php');
}
?>

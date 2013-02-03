function updateTimer ( )
{

  var now = new Date ( );
  var startTime = new Date ( "February 22, 2013 9:00:00" );

  days = (startTime - now) / 1000 / 60 / 60 / 24;
  daysRound = Math.floor(days);
  
  hours = (startTime - now) / 1000 / 60 / 60 - (24 * daysRound);
  hoursRound = Math.floor(hours);
  
  minutes = (startTime - now) / 1000 /60 - (24 * 60 * daysRound) - (60 * hoursRound);
  minutesRound = Math.floor(minutes);
  
  seconds = (startTime - now) / 1000 - (24 * 60 * 60 * daysRound) - (60 * 60 * hoursRound) - (60 * minutesRound);
  secondsRound = Math.round(seconds);
  
  secs = (secondsRound == 1) ? " second." : " seconds";
  mins = (minutesRound == 1) ? " minute" : " minutes, ";
  hrs = (hoursRound == 1) ? " hour" : " hours, ";
  dys = (daysRound == 1)  ? " day" : " days, ";

  // Split up the hour, if under 10 put a 0 in the first spot
  if (daysRound >= 10) {
    document.getElementById("timer_d1").firstChild.nodeValue = String(daysRound).substr(0, 1);
    document.getElementById("timer_d2").firstChild.nodeValue = String(daysRound).substr(1, 2);
  } else {
    document.getElementById("timer_d1").firstChild.nodeValue = "0";
    document.getElementById("timer_d2").firstChild.nodeValue = String(daysRound);
  }

  // Split up the hour, if under 10 put a 0 in the first spot
  if (hoursRound >= 10) {
    document.getElementById("timer_h1").firstChild.nodeValue = String(hoursRound).substr(0, 1);
    document.getElementById("timer_h2").firstChild.nodeValue = String(hoursRound).substr(1, 2);
  } else {
    document.getElementById("timer_h1").firstChild.nodeValue = "0";
    document.getElementById("timer_h2").firstChild.nodeValue = String(hoursRound);
  }

  // Split up the hour, if under 10 put a 0 in the first spot
  if (minutesRound >= 10) {
    document.getElementById("timer_m1").firstChild.nodeValue = String(minutesRound).substr(0, 1);
    document.getElementById("timer_m2").firstChild.nodeValue = String(minutesRound).substr(1, 2);
  } else {
    document.getElementById("timer_m1").firstChild.nodeValue = "0";
    document.getElementById("timer_m2").firstChild.nodeValue = String(minutesRound);
  }

  if (secondsRound == 60) {
    document.getElementById("timer_s1").firstChild.nodeValue = "0";
    document.getElementById("timer_s2").firstChild.nodeValue = "0";
  } else {
    
    // Split up the hour, if under 10 put a 0 in the first spot
    if (secondsRound >= 10) {
      document.getElementById("timer_s1").firstChild.nodeValue = String(secondsRound).substr(0, 1);
      document.getElementById("timer_s2").firstChild.nodeValue = String(secondsRound).substr(1, 2);
    } else {
      document.getElementById("timer_s1").firstChild.nodeValue = "0";
      document.getElementById("timer_s2").firstChild.nodeValue = String(secondsRound);
    }

  }

}

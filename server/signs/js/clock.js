function updateClock ( )
{
  var currentTime = new Date ( );

  var currentHours = currentTime.getHours ( );
  var currentMinutes = currentTime.getMinutes ( );
  var currentSeconds = currentTime.getSeconds ( );

  // Pad the minutes and seconds with leading zeros, if required
  currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
  currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

  // Choose either "AM" or "PM" as appropriate
  var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";

  // Convert the hours component to 12-hour format if needed
  currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

  // Convert an hours component of "0" to "12"
  currentHours = ( currentHours == 0 ) ? 12 : currentHours;

  // Compose the string for display
  //var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;

  // Update the time display
  //document.getElementById("clock").firstChild.nodeValue = currentTimeString;
  
  // Split up the hour, if under 10 put a 0 in the first spot
  if (currentHours >= 10) {
      document.getElementById("h1").firstChild.nodeValue = String(currentHours).substr(0, 1);
      document.getElementById("h2").firstChild.nodeValue = String(currentHours).substr(1, 2);
  } else {
      document.getElementById("h1").firstChild.nodeValue = "0";
      document.getElementById("h2").firstChild.nodeValue = String(currentHours);
  }

  // Split up the minute, if under 10 put a 0 in the first spot
  document.getElementById("m1").firstChild.nodeValue = String(currentMinutes).substr(0, 1);
  document.getElementById("m2").firstChild.nodeValue = String(currentMinutes).substr(1, 2);
  
  //document.getElementById("s1").firstChild.nodeValue = String(currentSeconds).substr(0, 1);
  //document.getElementById("s2").firstChild.nodeValue = String(currentSeconds).substr(1, 2);
  
  document.getElementById("meridiem1").firstChild.nodeValue = String(timeOfDay).substr(0, 1);
  document.getElementById("meridiem2").firstChild.nodeValue = String(timeOfDay).substr(1, 2);

}

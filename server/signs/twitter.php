<?

function search_twitter()
{

	require "TwitterSearch.phps";
	
	$search = new TwitterSearch('#scale10x');
	$results = $search->results();
	
	foreach ($results as $i => $value) {
	
		//print_r($value);
		$logo = $value->profile_image_url;
		$user = $value->from_user;
		$user_name = $value->from_user_name;
		$comment = $value->text;
	
		#print "<img class=\"avatar\" alt=\"$user_name\" src=\"$logo\">";

		print "<p style=\"background-color: #fff;vertical-align: middle\">";
		print  "<b style=\"inherit;\">$user_name</b> ";
		print "(@$user)<br>";
		print "$comment";
		print "</p>";

	}
	
}

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="refresh" content="300" >
		<title>SCALE 10x</title>
	</head>
	<body bgcolor="#d0e4fe">

<marquee behavior="scroll" scrollamount="2" direction="up" width=100%>
	<?php search_twitter() ?>
</marquee>

</body>
</html>

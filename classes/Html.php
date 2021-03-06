<?php
class Html {

	public static function outputHeader($options = []) {
		echo <<<EOT
	<!DOCTYPE html>
<html>
<head>
		<!-- Latest compiled and minified JavaScript -->
		<script   src="https://code.jquery.com/jquery-3.1.0.min.js"   integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="   crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<title>Find Crime in Your Area | Crimify</title>
	<link rel="stylesheet" type="text/css" href="styles/main.css" />
	<script>
		function displayCrimes(crimeArea){
			$('.' + crimeArea + '-Breakdown').removeClass('crimeBreakdownInfo');
			$('.crimeBreakdownInfo').slideUp();
			$('.' + crimeArea + '-Breakdown').addClass('crimeBreakdownInfo');
			$('.' + crimeArea + '-Breakdown').slideToggle();
		}
	</script>
EOT;
	if(array_key_exists('script', $options)){
		echo $options['script'];
	}
	echo <<<EOT
</head>
<body>
<div class="jumbotron text-center header">
	<img class="logo" src="images/logo512.png">
	<h1>Crimify</h1>	
	<p>Find crime in your local area!</p> 
</div>
EOT;
	}
	public static function outputFooter(){
		echo <<<EOT
		<footer class="jumbotron text-center footer">
			<p><div class="tinyLogo"><img src="images/logo512.png"><p>Crimify</p></div><br />Luke 'CheerfulPlum' Pace 2016</p>
		</footer>
</body>
EOT;
	}
}
?>

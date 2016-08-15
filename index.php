<?php
// Include common in all scritps, common.php does things like setting up class auto-loading
require_once('common.php');

$errors = [];

if(!empty($_GET['postcode'])){
	try{
		$crimeData = new CrimeData($_GET['postcode']);
	}
	catch(Exception $e){
		$errors[] = $e->getMessage();
	}
}

echo <<<EOT
<!DOCTYPE html>
<html>
<head>
		<!-- Latest compiled and minified JavaScript -->
		<script   src="https://code.jquery.com/jquery-3.1.0.min.js"   integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="   crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<title>Find Crime in Your Area | Crime Finder</title>
	<link rel="stylesheet" type="text/css" href="styles/main.css" />
	<script>
		function displayCrimes(crimeArea){
			$('.' + crimeArea + '-Breakdown').slideToggle();
		}
	</script>
</head>
<body>

<div class="jumbotron text-center">
  <h1>Crime Finder</h1>
  <p>Find crime in your local area!</p> 
</div>
	<div class="text-center">
EOT;
if(count($errors)){
	echo '<ul class="error">';
	foreach($errors as $error){
		echo "<li>{$error}</li>";
	}
	echo '</ul>';
}
echo '
		<form>
		<input type="text" class="postCodeInput form-control" name="postcode" ' . (isset($_GET['postcode']) ? 'value="' . htmlspecialchars($_GET['postcode']) . '"' : '') . 'placeholder="Postcode">
		<br />
		<input type="submit" class="crimeButton btn btn-primary" value="Lookup Crimes">
		</form>
	</div>';
if(isset($crimeData)){
	echo <<<EOT
	<div class="crimeResults center-block">
		<h2>Results</h2>
		<table class="table table-hover">
			<tr>
				<th>Crime</th>
				<th>Total</th>
			</tr>
EOT;
	foreach($crimeData->total as $crimeType => $total){
		echo '<tr onclick="displayCrimes(\'' . str_replace(' ', '-', $crimeType) . '\')">
			<td>' . $crimeType . '</td>
			<td>' . $total .'</td>
		</tr>
		<tr class="noHoverCell">
			<td style="display: none;" colspan="3" class="noHoverCell ' . str_replace(' ', '-', $crimeType) . '-Breakdown">
			<div style="display: none;" colspan="3" class="noHoverCell ' . str_replace(' ', '-', $crimeType) . '-Breakdown">
			<table class="table-striped table-bordered crimeBreakdown">
				<tr>
					<th>Date</th>
					<th>Location</th>
					<th>Outcome</th>
				</tr><td>';
		foreach($crimeData->crimes as $crime){
			if($crime->category == $crimeType){
				echo '<tr>
						<td>' . $crime->date . '</td>
						<td>' . $crime->location['street'] . '</td>
						<td>' . $crime->outcome . '</td>
					</tr>';
			}
		}
		echo '
			</table>
			</div>
			</td>
		</tr>';
	}
	echo <<<EOT
	</div>
EOT;
}
echo <<<EOT
</body>
EOT;

?>

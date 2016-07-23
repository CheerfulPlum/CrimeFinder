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
	<title>Find Crime in Your Area | Crime Finder</title>
	<link rel="stylesheet" type="text/css" href="/styles/main.css" />
</head>
<body>
	<h1>Crime Finder</h1>
	<div class="centerBox">
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
		<input type="text" name="postcode" ' . (isset($_GET['postcode']) ? 'value="' . htmlspecialchars($_GET['postcode']) . '"' : '') . 'placeholder="Postcode">
		<input type="submit" value="Lookup Crimes">
		</form>
	</div>';
if(isset($crimeData)){
	echo <<<EOT
	<div class="centerBoxResults">
		<table>
			<tr>
				<th>Date</th>
				<th>Category</th>
				<th>Location</th>
				<th>Outcome</th>
			</tr>
EOT;
	foreach($crimeData->crimes as $crime){
		echo <<<EOT
			<tr>
				<td>{$crime->date}</td>
				<td>{$crime->category}</td>
				<td>{$crime->location['street']}</td>
				<td>{$crime->outcome}</td>


			</tr>
EOT;
	}
	echo <<<EOT
		</table>
	</div>
EOT;
}
echo <<<EOT
</body>
EOT;

?>
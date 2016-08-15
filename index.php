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
Html::outputHeader();
echo <<<EOT
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
Html::outputFooter();

?>

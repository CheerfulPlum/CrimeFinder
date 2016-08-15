<?php
require_once('common.php');
if(!isset($_GET['lat']) || !isset($_GET['long'])){
	Utility::redirect('index.php');
}
$script = <<<EOT
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJtm1CPtG05rkXEh6qiZSpH4RETKdVLPI"></script>
<script>
function initialize() {
  var mapProp = {
    center:new google.maps.LatLng(51.508742,-0.120850),
    zoom:5,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
	var myLatLng = {lat: 51.398901, lng: -1.255210 };
	var marker = new google.maps.Marker({
		position: myLatLng,
		map: map,
		title: 'Hello World!'
	});

}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
EOT;
Html::outputHeader(
	['script' => $script]
);
echo <<<EOT
<div id="googleMap" style="width:500px;height:380px;"></div>
EOT;
Html::outputFooter();
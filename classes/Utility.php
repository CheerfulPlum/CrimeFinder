<?php
class Utility {
	
	public static function redirect($urlToRedirectTo){
		header('Location: '.$urlToRedirectTo);
	}
	public static function convertMonthYear($monthYear){
		return DateTime::createFromFormat('Y-m', $monthYear)->format('F Y');
	}
	
}
?>

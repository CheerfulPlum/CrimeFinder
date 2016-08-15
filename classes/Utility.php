<?php
class Utility {
	
	public static function redirect($urlToRedirectTo){
		header('Location: '.$urlToRedirectTo);
	}
	
}
?>

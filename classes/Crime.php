<?php
class Crime {
	
	public $category;

	public $outcome;

	public $date;

	public $location = [];

	public function __construct(){
		// Just set some basic properties
		$this->location = [
			'latitude' => null,
			'longitude' => null,
			'street' => null
		]; 
	}
}
?>
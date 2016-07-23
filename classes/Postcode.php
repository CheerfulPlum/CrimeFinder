<?php
/**
 * Postcode class 
 *
 * This class should possibly be renamed to something more fitting
 * as Postcode isn't that accurate. Takes a standard UK postcode
 * does an API lookup on it to get a lat and long for the given
 * postcode getGeoPointsAroundPoint() then takes this point
 * and gets points that point to form a cirle in which to 
 * search for crimes
 *
 *
 * PHP version 5
 *
 * @author     Luke Pace <cheerfulplum@gmail.com>
 * @copyright  2016 Luke Pace
 */
class Postcode {

	public $postcode;

	public $latitude;

	public $longitude;

	public $pointsArroundPostcode = [];

	const POSTCODE_API_LOOKUP = 'https://api.postcodes.io/postcodes/';

	const POLAR_CIRCUMFERENCE = 110540;

	const EQUATORIAL_CIRCUMFERENCE = 111320;

	public function __construct($postcode){
		// file_get_contents is a really rubbish function, would usually use cURL but not all version of PHP come with cURL installed by default
		if(!$postcodeInfo = @json_decode(file_get_contents(self::POSTCODE_API_LOOKUP . $postcode))){
			throw new Exception('Postcode Not Found');
		}
		if($postcodeInfo->status == 200){
			$this->latitude = $postcodeInfo->result->latitude;
			$this->longitude = $postcodeInfo->result->longitude;
			$this->getGeoPointsAroundPoint($this->latitude, $this->longitude, 5000);
		}

	}
	public function getGeoPointsAroundPoint($latitude, $longitude, $radius){
		// Use various bearings to make something that looks like a cirle(ish)
		$bearings = [0, 45, 90, 135, 180, 225, 270];
		$latsAndLongs = [];

		foreach ($bearings as $bearing) {
			$dx = $radius*cos($bearing);
			$dy = $radius*sin($bearing);
			
			$deltaLongitude = $dx/(self::EQUATORIAL_CIRCUMFERENCE*cos($latitude));
			$deltaLatitude = $dy/(self::POLAR_CIRCUMFERENCE);

			$finalLongitude = $longitude + $deltaLongitude;
			$finalLatitude = $latitude + $deltaLatitude;

			$latsAndLongs[] = [
				'longitude' => $finalLongitude,
				'latitude'	=> $finalLatitude
			];

		}
		$this->pointsArroundPostcode = $latsAndLongs;
	}
}
?>
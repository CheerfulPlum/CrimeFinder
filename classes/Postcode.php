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
	/**
	* Postcode used to do the crime statistics lookup
	*
	* @var string
	* @access public
	*/
	public $postcode;

	/**
	* The latitude found for the given postcode
	*
	* @var float
	* @access public
	*/
	public $latitude;

	/**
	* The longitude found for the given postcode
	*
	* @var float
	* @access public
	*/
	public $longitude;

	/**
	* An array of the points around the postcode which
	* form a polygon in which to look for crime
	*
	* @var array
	* @access public
	*/
	public $pointsArroundPostcode = [];

	/**
	* The address of the API we are using to get the lat and long of postcode
	* @var string
	*/
	const POSTCODE_API_LOOKUP = 'https://api.postcodes.io/postcodes/';

	/**
	* The polar circumference of the earth
	* @var int
	*/
	const POLAR_CIRCUMFERENCE = 110540;

	/**
	* The equatorial circumference of the earth
	* @var int
	*/
	const EQUATORIAL_CIRCUMFERENCE = 111320;

	/**
	* Method that queries the postcode API
	*
	* This method quries the postcode API which returns back the long
	* and lat of the postcode, this is then used to generate a
	* co-ordinate polygon which is then used by the CrimeData class
	* to lookup in the polygon
	*
	* @param string $postcode the postcode being looked up
	* @return void
	*
	* @access public
	*
	*
	*/

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

	/**
	* Method that generates a an array of lat and long points
	*
	* This method takes the lat and long of the postcode being
	* checked and generates an array of lat and longs around
	* the point in which to look for crime
	* 
	* Method for getting these points was found on StackOverflow here:
	* http://stackoverflow.com/questions/2187657/calculate-second-point
	* -knowing-the-starting-point-and-distance
	*
	* @param float $latitude the latitude of the central point
	* @param float $longitude the longitude of the central point
	* @param int $radius the radius of the search area
	* @return void
	*
	* @access private
	*
	*
	*/

	private function getGeoPointsAroundPoint($latitude, $longitude, $radius){
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
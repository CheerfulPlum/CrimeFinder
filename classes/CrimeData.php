<?php
/**
 * CrimeData class 
 *
 * This class uses a UK government API to access crime statistics
 * for a given area, this area should be given as a valid UK postcode
 *
 * PHP version 5
 *
 * @author     Luke Pace <cheerfulplum@gmail.com>
 * @copyright  2016 Luke Pace
 */

class CrimeData {

	/**
	* An array of Crime objects
	*
	* @var array
	* @access public
	*/
	public $crimes = [];

	/**
	* The postcode to be looked up
	*
	* This postcode is used to create a search area looking for crimes
	*
	* @var array
	* @access public
	*/
	public $postcode;

	/**
	* The URL of the police API
	*
	* Full URL of the police API used when searching for crimes, query
	* parameter is included so just need to add the co-ordinates
	*
	*/
	const CRIME_API_LOOKUP = 'https://data.police.uk/api/crimes-street/all-crime?poly=';

	/**
	* Pretty basic constructor
	*
	* Takes 1 parameter that is the postcode, this postcode is then used
	* in getCrimeDataForArea() to a search area
	*
	* @param string $postcode the postcode being looked up
	* @return void
	*
	* @access public
	*
	*
	*/
	public function __construct($postcode){
		$this->postcode = $postcode;
		$this->getCrimeDataForArea();
	}
	/**
	* Method that queries police API
	*
	* Takes no parameters, creates a new postcode object which is contains
	* has a series of co-ordinates, these co-ordinates are then used to
	* create a polygon area in which to search for crimes using the police
	* API
	*
	* @return void
	*
	* @access private
	*
	*
	*/
	private function getCrimeDataForArea(){
		$areaData = new Postcode($this->postcode);
		$latAndLongString = '';
		$first = true;
		foreach($areaData->pointsAroundPostcode as $area){
			if(!$first){
				$latAndLongString .= ':';
			}
			$first = false;
			$latAndLongString .= $area['latitude'] . ',' . $area['longitude'];
		}
		// file_get_contents throws a warning if it doesn't get any content
		// back or a 404, just ignore this and do our own error handling
		$url = self::CRIME_API_LOOKUP . $latAndLongString;
		// $url needs to be in the format 'lat,long:lat,long:lat,long etc....'
		if(!$crimeInfo = @json_decode(file_get_contents($url))){
			throw new Exception('Crime Area Not Found');
			return false;
		}
		foreach ($crimeInfo as $crime) {
			$crimeObj= new Crime();

			$crimeObj->category = $crime->category;
			$crimeObj->outcome = (is_object($crime->outcome_status) ? $crime->outcome_status->category : 'No Outcome Yet');
			$crimeObj->date = $crime->month;
			$crimeObj->location['latitude'] = $crime->location->latitude;
			$crimeObj->location['longitude'] = $crime->location->longitude;
			$crimeObj->location['street'] = $crime->location->street->name;
			$this->crimes[] = $crimeObj;
		}

	}
}
?>
<?php
/**
 * Crime class 
 * Very basic class, just used to represent a crime
 * Having a class makes in easy to add to in the future
 *
 *
 * PHP version 5
 *
 * @author     Luke Pace <cheerfulplum@gmail.com>
 * @copyright  2016 Luke Pace
 */

class Crime {

	/**
	* The ID of the crime, this is taken from the API
	*
	* @var string
	* @access public
	*/
	public $id;
	
	/**
	* The category of the crime
	*
	* @var string
	* @access public
	*/
	public $category;

	/**
	* The outcome of the crime
	*
	* @var string
	* @access public
	*/
	public $outcome;

	/**
	* The date of the crime, is anonymized
	* so it's just month and year
	*
	* @var string
	* @access public
	*/
	public $date;

	/**
	* The location of the crime
	*
	* @var array
	* @access public
	*/
	public $location = [];

	/**
	* The address of the API we are using to look up details for a specific crime
	* @var string
	*/
	const CRIME_API_LOOKUP_URL = 'https://data.police.uk/api/outcomes-for-crime/';
	
	/**
	* Very basic constructor
	*
	* Just sets some default values
	* @param string $id the ID of the crime 
	* @return void
	*
	* @access public
	*
	*
	*/

	public function __construct($id = null){
		// If there is an ID passed then lookup the crime using the API
		if($id){
			$url = self::CRIME_API_LOOKUP_URL . $id;
			if(!$crime = @json_decode(file_get_contents($url))){
				throw new Exception('Crime Not Found Using ID');
				return false;
			}
			// Popluate object...
			else{
				// STUB
			}
		}
		// Just set some basic properties
		else{
			$this->location = [
				'latitude' => null,
				'longitude' => null,
				'street' => null
			];
		}
	}
}
?>
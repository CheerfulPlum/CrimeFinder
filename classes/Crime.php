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
	* Very basic constructor
	*
	* Just sets some default values
	* @return void
	*
	* @access public
	*
	*
	*/

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
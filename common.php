<?php
/**
 * Mostly does autoloading of classes
 *
 * Should be required_once() in every php script
 *
 * PHP version 5
 *
 * @author     Luke Pace <cheerfulplum@gmail.com>
 * @copyright  2016 Luke Pace
 */

error_reporting(E_ALL);
ini_set("display_errors", 1);

function __autoload($className) {
      if (file_exists('classes/' . $className . '.php')) {
          require_once 'classes/' . $className . '.php';
          return true;
      }
      return false;
} 
?>
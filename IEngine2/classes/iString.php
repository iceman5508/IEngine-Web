<?php

class iString {
	
	private $string; 
	
 public function __construct($string)
 {
 	$this->string = $string;
 }
 
 public function __destruct()
 {
 	unset($this->string);
 }
	
 
 /**
  * Compare the given string to the string in the iString class to see if they are equal
  * This ignores case
  * @param String $string
  */
 public function compare_NoCase($string)
 {
 	$value = strcasecmp($this->string, $string);
 	if($value==0)
 	{
 		return true;
 	}else
 	{
 		return false;
 	}
 }
 
/**
  * Compare the given string to the string in the iString class to see if they are equal
  * @param String $string
  */
 public function compare($string)
 {
 	$value = strcmp($this->string, $string);
 	if($value==0)
 	{
 		return true;
 	}else
 	{
 		return false;
 	}
 }
 
 /**
  * get the string in the iString class
  */
 public function getString()
 {
 	return $this->string;
 }
 
 

 public function __toString()
 {
 	return $this->string;
 }
 
 /**
  * Get part of the string
  * @param String $action - options are first and last<br>
  * first, set pointer to the start of the string.<br>
  * last, set pointer to the end of the string<br>
  * 
  * @param integer $numberOfChars - number of chars to include.<br>
  * if pointer is first, the char count will be from left to right.<br>
  * if point is last, the char count will be from right to left.
  */
 public function getPartOfString($action, $numberOfChars)
 {
 	if($numberOfChars<0)
 	{
 		$numberOfChars = $numberOfChars*-1;
 	}
 	else if($numberOfChars==0)
 	{
 		return $this->string;
 	
 	}else 	
 	if(strcasecmp($action,'last')==0)
 	{
 		
 		return substr($this->string, -$numberOfChars);
 		
 		
 	}else if(strcasecmp($action,'first')==0)
 	{
 		
 		return substr($this->string, 0,$numberOfChars);
 		
 	}else return $this->string;
 }
 
 /**
  * Break string into words
  * return array of strings
  */
 public function breakIntoWords()
 {
 	return explode(" ", trim($this->string));
 }
 
 /**
  * Check if a given value is in the string.
  * @param String $value
  */
 public function inString($value)
 {
 	return in_array($value, $this->breakIntoWords());
 }
 
 /**
  * Return the first instance of a give value in the string
  * @param String $value - value to search for
  */
 public function firstInstanceOf($value)
 {
 	if(array_search($value, $this->breakIntoWords())===false)
 	{
 		return false;
 	}else {
 		return array_search($value, $this->breakIntoWords());
 	}
 }
 
 /**
  * Return all instances of a value in the string
  * @param string $value
  */
 public function AllInstancesOf($value)
 {
 	if($this->inString($value))
 	{
 		$words = $this->breakIntoWords();
 		$positions=array();
 		for($i=0; $i<sizeof($words); $i++) 	
 		{
 			$value = strcasecmp($words[$i], $value);
 			if($value==0)
 			{
 				$positions[]=$i;
 			}
 		}
 		return $positions;
 		
 	}else
 	{
 		return false;
 	}
 		
 		
 }

}

?>
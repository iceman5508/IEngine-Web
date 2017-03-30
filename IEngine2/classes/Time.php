<?php
class Time{
	private static $timeZone;
	public static $timePassed;
	
	
	function __construct() {
	
		
	}
	
	
	function __destruct() {
		
		
	}

	/**
	 * Set the current timezone
	 * @param String $timeZone
	 */
	public static function setTimeZone($timeZone)
	{
		self::$timeZone = date_default_timezone_set($timeZone);
            
	}
	
	/**
	 * Return the current time
	 */
	public static function getTime()
	{
		return date('h:i a', time());
	}
	
	/**
	 * Get the current timestamp
	 * @return the timestamp
	 */
	public static function getTimeStamp()
	{
		return time();
	}
	
	/**
	 * Get the current hour
	 */
	public static function getHour()
	{
		return date('h', time());
	}
	
	/**
	 * get the minute of the hour
	 */
	public static function getMin()
	{
		return date('i', time());
	}
	
	/**
	 * Get the seconds from the hour
	 */
	public static function getSec()
	{
		return date('s', time());
	}
	
	/**
	 * Get the time passed between two dates.
	 * @param time $startTime
	 * @param time $secondTime
	 */
	public static function timePassed($startTime,$secondTime=null)
	{
		$then = new DateTime($startTime);
		if($secondTime===null)
		{
			$now = new DateTime();	
		}else {
			$now = new DateTime($secondTime);
		}	
		self::$timePassed = $then->diff($now);
		
	}
	

	

	
	

}

?>
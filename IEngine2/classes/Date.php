<?php
class Date {
	
	function __construct() {
	
		
	}
	
	
	function __destruct() {
		
		
	}

	/**
	 * Get current date
	 */
	public static function getDate()
	{
		return date("Y-m-d");
	}
	
	
	/**
	 * Get current date
	 */
	public static function getDateM()
	{
		return date("m-d-Y");
	}
	
	/**
	 * Get current year
	 */
	public static function getYear()
	{
		return date("Y");
	}
	
	/**
	 * Get current month
	 * @return string
	 */
	public static function getMonth()
	{
		return date("m");
	}
	
	/**
	 * Get current day
	 */
	public static function getDay()
	{
		return date("d");
	}
	
	/**
	 * Check if a specific date is greater than another
	 * @param unknown_type $date1
	 * @param unknown_type $date2
	 */
	public static function dateGreater($date1, $date2)
	{
		$timestamp1 = strtotime($date1);
		$timestamp2 = strtotime($date2);
		if($timestamp1 > $timestamp2){
		   return true;
		}else 
		{
			return false;
		}
	}
	
	/**
	 * Check if two dates are equal
	 * @param unknown_type $date1
	 * @param unknown_type $date2
	 */
	public static function datesEqual($date1, $date2)
	{
		$timestamp1 = strtotime($date1);
		$timestamp2 = strtotime($date2);
		if($timestamp1 == $timestamp2){
			return true;
		}else
		{
			return false;
		}
	}
	
	/**
	 * Check if current date is within a range of dates
	 * @param unknown_type $startDate
	 * @param unknown_type $endDate
	 */
	public static function inDateRange($startDate, $endDate)
	{
		if(self::datesEqual($startDate, $endDate) || self::dateGreater($endDate, $startDate))
		{
			return true;			
		}else
		{
			return false;
		}
	}
	
	/**
	 * Check if current date in date range
	 * @param unknown_type $startDate
	 * @param unknown_type $endDate
	 */
	public static function todayInDateRange($startDate, $endDate)
	{
		if(self::datesEqual($startDate, $endDate) || self::dateGreater($endDate, $startDate))
		{
			if(self::datesEqual(self::getDate(), $startDate) || self::dateGreater(self::getDate(),$startDate))
			{
				if(self::datesEqual(self::getDate(), $endDate) || self::dateGreater($endDate,self::getDate()))
				{
					return true;	
				}else
				{
					return false;
				}
			}else
			{
				return false;
			}
		}else
		{
			return false;
		}
	}
	
	
	/**
	 * Check days passed between two dates
	 * @param unknown_type $date1
	 * @param unknown_type $date2
	 * @return number
	 */
	public static function daysPassed($date1, $date2)
	{
		$timestamp1 = strtotime($date1);
		$timestamp2 = strtotime($date2);
		$datediff = $timestamp1 - $timestamp2;
		return floor($datediff/(60*60*24));
    }
    
    
    /**
     * Return years and months passed between two dates
     * @param unknown_type $date1
     * @param unknown_type $date2
     */
   public static function yearsMonthsPassed ( $date1, $date2 ) 
   {
    
    	$d1 = new DateTime( $date1 );
    	$d2 = new DateTime( $date2 );
    
    	$diff = $d2->diff( $d1 );
    
    	// Return array years and months
    	return array ( $diff->y,  $diff->m );
    }
}

?>
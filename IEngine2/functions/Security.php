<?php
/**
 *@name Security functions
 * @author Isaac Parker
 *  @version 2.0
 *  @uses help secure app and site
 *  @copyright 10-15-2014
 * 
*/

/**
 *@name escape
 *@uses escapes a string so that it is slightly safer.
 *@return escaped string
 *@param string the string you want to escape
 *@example escape"hi");
 *
 */
if(!function_exists('escape'))
{
	 function escape($string)
	{
		return htmlentities($string , ENT_QUOTES, 'UTF-8');
	}
}


/**
 *@name removeCode
 *@uses remove code so that string is slightly safer.
 *@return cleaned string
 *@param string the string you want to remove code from
 *@example ("hi");
 *
 */
if(!function_exists('removeCode'))
{
	function removeCode($string)
	{
		return strip_tags($string);
	}
}


/**
 *@name escapeCode
 *@uses escapes a string and remove code so that it is slightly safer.
 *@return escaped string
 *@param string the string you want to escape
 *@example ("hi");
 *
 */
if(!function_exists('escapeCode'))
{
	function escapeCode($string)
	{
		$str = escape($string);
		return removeCode($str);
	}
}






?>
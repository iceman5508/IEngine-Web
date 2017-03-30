<?php
/**
 *
 * @author Isaac Parker
 *  @version 2.0
 *  @uses create a config class to handle setting up site for use of other helper classes
 *  @copyright 7-23-2014
 *  @static
 */


class ConfigClass {

	
	
	/**
	 *@method get
	 *@access static
	 *@uses get information from the config file and function for use with other classes
	 *@return requested config information
	 *@param the path of the information requested
	 *      
	 */
	public static function get($path=NULL)
	{
		if($path)
		{
			$config = $GLOBALS['config'];
			$path = explode('/', $path);
			foreach($path as $fig)
			{
				if(isset($config[$fig]))
				{
					$config = $config[$fig];						
				}	
			}
			return $config;
		}
		return false;	
	}
	
	
}

?>
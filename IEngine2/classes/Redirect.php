<?php
/**
*Redirect Class. 
*
* redirect the user 
*
 * Copyright (c) 2014 Isaac Parker
 * Licensed under the GNU General Public License version 3.0 (GPLv3)
*@version 1.4.14
*@author Isaac Parker <isaacparker94@gmail.com>
*@package Class
*@Subpackage: 
*
*@LastEditDate:
*@Editor:
*@EditorNotes:
*
*
*					
*/

	


class Redirect 
{

	
	
/******************************Magic methods****************************/	
	
	
	
	
	
	
/*******************************public methods****************************/	
	
	
	 /**
	 *@MethodName:to
	 *@Purpose: where redirect will work at.
	 *@Precondition: 
	 *@Params: 
	 *@Params details: 
	 *					
	 *
	 *@Postcondition: 
	 *
	 *@MethodCallExample: 
	 */	
	public static function to($location = NULL)
	{
	
		if($location)
		{
			if(is_numeric($location))
			{
				switch($location)
				{
					case 404:
						 header('HTTP/1.1 404 Not Found');
						//include($error404);
						break;
					
				}
				
			}
				header('Location: '.$location.'');
				exit();
			
			
		}
		
	}	
	
	
/***************************private and protected methods*******************/	
	
	
	
/***************************************public variables******************/		
	
/*************************private and protected variables******************/	

	
	
}
/****************************end of class******************************/

/************************cLASS related funtions************************/



?>
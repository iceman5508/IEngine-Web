<?php
/**
*Sessions. 
*
*Work with token class to manage sessions and prevent app hacking. 
*
*@version 1.3.14
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


class Sessions
{
	
	
	
/******************************Magic methods****************************/	
	
	
	
	
	
	
/*******************************public methods****************************/	
/*@methodName: exists
*@purposee: check if a session exists
*@param: 
*@paramDetail: 
*@preCondition: 
*@postCondition: 
*@access: public/static
*/	
	
	public static function exists($name)
	{
		
		return (isset($_SESSION[$name])? true: false);
		
	}
	
	
/*@methodName: put
*@purposee: returns session name
*@param: 
*@paramDetail: 
*@preCondition: 
*@postCondition: 
*@access: public/static
*/	
	
	public static function put($name, $value)
	{
		
		return $_SESSION[$name] = $value;
		
	}
	
	/**@methodName: get
*@purposee: to get specific token value
*@param: 
*@paramDetail: 
*@preCondition: 
*@postCondition: 
*@access: public/static
**/	
	
	public static function get($name)
	{
		return $_SESSION[$name];
		
	}
	
	
/*@methodName: delete
*@purposee: to delete specific token
*@param: 
*@paramDetail: 
*@preCondition: 
*@postCondition: 
*@access: public/static
*/	
	
	public static function delete($name)
	{
		if(self::exists($name))
		{
			unset($_SESSION[$name]);
		}
		
	}
	
	
/*@methodName: flase
*@purposee: flash in data to user
*@param: 
*@paramDetail: 
*@preCondition: 
*@postCondition: 
*@access: public/static
*/	
	
	public static function flash($name, $string = ' ')
	{
		if(self::exists($name))
		{
			$session = self::get($name);
			self::delete($name);
			return $session;
		}
		else
		{
			self::put($name , $string);	
		}
	}
	
/***************************private and protected methods*******************/	
	
	
	
/***************************************public variables******************/		
	
/*************************private and protected variables******************/	
	
	
	
	
}
/****************************end of class******************************/

/************************cLASS related funtions************************/



?>
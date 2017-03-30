<?php
/**
*Token Class. 
*
*To protect agains cross site attacks 
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



class Token
{
	
	
	
/******************************Magic methods****************************/	
	
	
	
	
	
	
/*******************************public methods****************************/	
/*@methodName: makeToke
*@purposee: to make a token for the user
*@param: 
*@paramDetail: 
*@preCondition: 
*@postCondition: 
*@access: public/static
*/	
	
	public static function makeToke()
	{
		
		return Sessions::put(ConfigClass::get('session/tokeName'), md5(uniqid()));
		
	}
	
/*@methodName: check
*@purposee: to see if token exists or not
*@param: 
*@paramDetail: 
*@preCondition: 
*@postCondition: 
*@access: public/static
*/	
	
	public static function check($token)
	{
		$tokeName = ConfigClass::get('session/tokeName');
		if(Sessions::exists($tokeName) && $tokeName === Sessions::get($tokeName))
		{
			Sessions::delete($tokeName);
			return true;
			
		}
		return false;  
		
	}
/***************************private and protected methods*******************/	
	
	
	
/***************************************public variables******************/		
	
/*************************private and protected variables******************/	
	
	
	
	
}
/****************************end of class******************************/

/************************cLASS related funtions************************/



?>
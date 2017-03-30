<?php
/**
*Hash Class. 
*
*create hash class for securing passwords and other information that programmer feels
*need to be kept super duper safe. Yea i said super duper..sue me.
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
class Hash
{
	
	
	
/******************************Magic methods****************************/	
	
	
	
	
	
	
/*******************************public methods****************************/	
	
	 /**
	 *@MethodName:make
	 *@Purpose: make hash
	 *@Precondition: 
	 *@Params: 
	 *@Params details: 
	 *					
	 *@access: public/static
	 *@Postcondition: 
	 *
	 *@MethodCallExample: 
	 */	
	
	public static function make($string, $salt = '')
	{

		return hash('sha256', $string.$salt); 
	}
	
	
	 /**
	 *@MethodName:salt
	 *@Purpose: make salt
	 *@Precondition: 
	 *@Params: 
	 *@Params details: 
	 *					
	 *@access: public/static
	 *@Postcondition: 
	 *
	 *@MethodCallExample: 
	 */	
	
	public static function salt($length)
	{
		return mcrypt_create_iv($length);
	}
	
	
	
	 /**
	 *@MethodName:unique
	 *@Purpose: make unique hash
	 *@Precondition: 
	 *@Params: 
	 *@Params details: 
	 *					
	 *@access: public/static
	 *@Postcondition: 
	 *
	 *@MethodCallExample: 
	 */	
	
	public static function unique()
	{
		return self::make(uniqid());
	}
/***************************private and protected methods*******************/	
	
	
	
/***************************************public variables******************/		
	
/*************************private and protected variables******************/	
	
	
	
	
}
/****************************end of class******************************/

/************************cLASS related funtions************************/



?>
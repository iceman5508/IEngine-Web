<?php
/**
*Input Class. 
*
*to handle user inputs class
*
*@version 12.23.13
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

class Inputs 
{
	
	
	
/******************************Magic methods****************************/
	
/*******************************public methods****************************/
	
 /**
 *@methodName: submit
*@purposee: to check if data has been submitted
*@param: $type
*@paramDetail: $type: what data type is being submitted, ie. post or get
*@preCondition: 
*@postCondition: 
*@access: public
*
*
*/
public static function submit($type = 'post')
{
	switch($type)
	{
		case 'post':
			return (!empty($_POST)? true: false);
		break;
		
		case 'get':
			return (!empty($_GET)? true: false);
		break;
		
		default:
			return false;
		break;
	}	
	
}

/**
*@methodName: get
*@purposee: get submmited data field
*@param: $item
*@paramDetail: $item: the specicif field that is wanted
*@preCondition: 
*@postCondition: 
*@access: public
*
*
*/

public static function get($item)
{
	if(isset($_POST[$item]))
	{
		
		return $_POST[$item];
	}
	else
	if(isset($_GET[$item]))
	{
		
		return $_GET[$item];
	}
	return '';
	
}
/***************************private and protected methods*******************/	
	

/***************************************public variables******************/	

	
	
/*************************private and protected variables******************/	

	
	
}
/****************************end of class******************************/

/************************cLASS related funtions************************/



?>
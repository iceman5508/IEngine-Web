<?php
/**
*Php Validation functions list. 
*
*Used to validate data before being used for more important things 
*
*@version 12.23.13
*@author Isaac Parker <isaacparker94@gmail.com>
*@package Class
*@Subpackage: Validate
*@subpackage package: 
*
*@LastEditDate: 4-21-2014
*@Editor:        Isaac Parker
*@EditorNotes:    Added isMp3 function 
*
*Note: Most of these validations do not specifically
 validate the specific input but rather the 
 format of the input. However, using multiple validations
 should do the job of full validation.
*					
*/



/************Validates input**************/

/*****************************************Creditcard validation***********************************/
/****************Valid credit card number***************/
if(!function_exists('validCCNum'))
{
  function validCCNum($str)
  {
  
	  return preg_match('/^\d{16}$/' ,$str);
  }
}

/****************valid experation date*************/
if(!function_exists('validCExp'))
{
  function validCExp($str) 
  {
  return preg_match('/(0[1-9]|1[0-2])\/20[0-9]{2}$/', $str);
  }
}

/****************************************Validate phone numbers***************************************/
/************International numbers********************/
if(!function_exists('validIntlNum'))
{
  function validIntlNum($str)
  {
  	return preg_match('/^(\+|00)[1-9]{1,3}(\.|\s|-)?([0-9]{1,5}(\.|\s|-)?){1,3}$/', $str);
  }
}

/*************American Num**************************/
if(!function_exists('validUsNum'))
{
  function validUsNum($str)
  {
  	return preg_match('/^[2-9]\d{2}-\d{3}-\d{4}$/', $str);
  }
}

/****************India Num**************************/
if(!function_exists('validIndiNum'))
{
  function validIndiNum($str)
  {
  	return preg_match('/^\(0\d{2}\)\s?\d{8}$/', $str);
  }
}

/**********************************************US social security*******************/
/****Valid united states social security number**/
if(!function_exists('validSSN'))
{
  function validSSN($str)
  {
  	return preg_match('/^\d{3}\-\d{2}\-\d{4}$/', $str);
  }
}

/***********************Valid Email**************/
/****Valid email**/
if(!function_exists('validEmail'))
{
  function validEmail($str)
  {
  	return preg_match('/^([a-z0-9_-])+([\.a-z0-9_-])*@([a-z0-9-])+(\.[a-z0-9-]+)*\.([a-z]{2,6})$/', $str);
  }
}

/***********************Valid url********************/
if(!function_exists('validURL'))
{
  function validURL($str)
  {
  	return preg_match('/^(http|https|ftp):\/\/([a-z0-9]([a-z0-9_-]*[a-z0-9])?\.)+[a-z]{2,6}\/?([a-z0-9\?\._-~&#=+%]*)?/', $str);
  }
}


/***********************Is image******************/
/****Note is image only check for basic image files*
if you wish to create a full proof image checker that goes beyond just 
the basic file names you can extend the function*****/
if(!function_exists('isImage'))
{
	 function isImage($value)
	 {
		if(strpos($value, '.jpeg')!==false)
		{
			if(substr($value, -5) == '.jpeg')
		  {
			 return true; 
		  }else return false; 
		}
		else if(strpos($value,'.jpg')!==false)
		{
			if(substr($value, -4) == '.jpg')
		  {
			 return true; 
		  }else return false; 
		}
		else
		if(strpos($value,'.bmp')!==false)
		{
			if(substr($value, -4) == '.bmp')
		  {
			 return true; 
		  }else return false; ;
		}else
		if( strpos($value,'.png')!==false)
		{
			if(substr($value, -4) == '.png')
		  {
			 return true; 
		  }else return false; 
		}else
		if(strpos($value,'.gif')!==false)
		{
			if(substr($value, -4) == '.gif')
		  {
			 return true; 
		  }else return false; 
		}else return false;
      
  	 }
}

/***********************Is textfile******************/
if(!function_exists('isTextFile'))
{
	 function isTextFile($file)
	 {
		if(strpos($file, '.txt')!==false)
		{
		  if(substr($file, -4) == '.txt')
		  {
			 return true; 
		  }else return false; 		
		}
		else return false;
      
  	 }
}


/************is MP3*********/
/*Method Name: is MP3
 *Puropse: Search a file and check if specific item is an mp3 file
 *Precondition: folder must exsist
 *PostCondition: return true or false
 */
 if(!function_exists('isMP3'))
{	 
	 function isMP3($file)
	{	        
	  if(strpos($file, '.mp3')!==false)
	  {
		if(substr($file, -4) == '.mp3')
		{
		   return true; 
		}else return false; 		
	  }
	  else return false;		 
	}
}

/************iscsv*********/
/*Method Name: iscsv
 *Puropse: Search a file and check if specific item is an csv file
 *Precondition: folder must exsist
 *PostCondition: return true or false
 */
 if(!function_exists('isCsv'))
{	 
	 function isCsv($file)
	{	        
	  if(strpos($file, '.csv')!==false)
	  {
		if(substr($file, -4) == '.csv')
		{
		   return true; 
		}else return false; 		
	  }
	  else return false;		 
	}
}



/************isempty*********/
/*Method Name: isempty
 *Puropse: Search a file and check if specific item is empty or not
 *Precondition: 
 *PostCondition: return true or false
 */
if(!function_exists('isEmpty'))
{	function isEmpty($data)
	{
		if(is_array($data))
		{
			return (sizeof($data)>0 ? true: false);
			exit();	
		}
		if(is_string($data))
		{
			return (preg_match('/\S/', $data) ? false: true);
			exit();
		}
	}
}


/*Is url function */
if(!function_exists('isURL'))
{
  function isURL($url) 
  {
	  if (preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url)) {
		  return true;
	  } else {
		  return false;
	  }
  }
}





?>
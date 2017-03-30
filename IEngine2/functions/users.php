<?php
/**
*Users Class. 
*
* handles all user information for user related taskes.  
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
if(!function_exists('getIp'))
{
  function getIp() {
   $ipaddress = '';
	  if (isset($_SERVER['HTTP_CLIENT_IP']))
		  $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	  else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		  $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	  else if(isset($_SERVER['HTTP_X_FORWARDED']))
		  $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	  else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
	   $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	  else if(isset($_SERVER['HTTP_FORWARDED']))
		  $ipaddress = $_SERVER['HTTP_FORWARDED'];
	  else if(isset($_SERVER['REMOTE_ADDR']))
		  $ipaddress = $_SERVER['REMOTE_ADDR'];
	  else
		  $ipaddress = 'UNKNOWN';
   return $ipaddress;
  }
}





?>
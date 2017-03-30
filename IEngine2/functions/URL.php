<?php
/**
*Url functions
*Purpose: ease the task url related task
* Copyright (c) 2014 Isaac Parker
* Licensed under the GNU General Public License version 3.0 (GPLv3)
*Purpose : To manage holding of data
*Date: 1-10-2014
*Author: Isaac Parker
*Editor: 
*Last Edit date: 
*
*Editor notes: 			
*/

/*curent page name*/
 
if(!function_exists('pageName'))
{	
  
  function pageName()
  {
	  $pageName =  basename($_SERVER['PHP_SELF']);
		return $pageName;	
  }

}
 
 /*CUrrent url*/
  if(!function_exists('currentUrl'))
{	
  
  function currentUrl()
  {
	  $activeURL = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];	  
	  return $activeURL;
  }

}

/*CUrrent path*/
if(!function_exists('currentPath'))
{

	function currentPath()
	{
		return $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		
	}

}

/*CUrrent url*/
if(!function_exists('parentPath'))
{

	function parentPath()
	{
		$array = explode("/",  $_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI']);
		unset($array[sizeof($array)-1]);
		$location = implode("/", $array);
		return $location;
		
		
	}

}


if(!function_exists('parentUrl'))
{

	function parentUrl()
	{
		$array = explode("/",  $_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI']);
		unset($array[sizeof($array)-1]);
		$location = implode("/", $array);
		return "http://".$location;
		
	}

}

 
/**project folder path***/
 if(!function_exists('projectPath'))
{

	function projectPath()
	{
		$array = explode("/",  $_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI']);		
		$location = $array[0]."/".$array[1];
		return $location;
		
	}

}

/**project folder url***/
if(!function_exists('projectUrl'))
{

	function projectUrl()
	{
		$array = explode("/",  $_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI']);
		$location = $array[0]."/".$array[1];
		return "http://".$location;

	}

}


 
/*Host */
 /*CUrrent url*/
  if(!function_exists('host'))
{	
  
  function host()
  {
	  $activeURL = "http://".$_SERVER['HTTP_HOST'];	  
	  return $activeURL;
  }

}
 

 
 
 //remove extention from url
 if(!function_exists('removeUrlEx'))
{	
  
  function removeUrlEx()
  {
	  $activeURL = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	  $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $activeURL);
	  return $withoutExt;
  }

}
 
 
 
 
/*Remove any extra slashes from url*/
if(!function_exists('lastSlash'))
{	
  function lastSlash()
  {
  	$activeURL = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	if(substr($activeURL, -1) == '/') 
	{	
		$safe_url = rtrim($activeURL, '/');		
		header( 'Location: '.$safe_url.'' ) ;
	}
	
  }

}
 
 
 /*redirect function*/
 if(!function_exists('redirect_to')){
function redirect_to( $location = NULL ) {
		if ($location != NULL) {
			header("Location: {$location}");
			exit;
		}
	}
}


/*current Page*/
 if(!function_exists('currentPage'))
 {
 
   function currentPage($linkName)
   {  
      $currentPageName =  basename($_SERVER['PHP_SELF']);
	  if(strpos($currentPageName, $linkName)!==false)
	  {
		  return true;	
	  }
	  else return false; 	 
   }
 }
 
 
 /*current Page*/
 if(!function_exists('previousPage'))
 {
 
   function previousPage()
   {  
     
	  if(isset($_SERVER['HTTP_REFERER']))
	  {
		  return $_SERVER['HTTP_REFERER'] ;	
	  }
	  else return currentUrl(); 	 
   }
 }
 
/*encodeUrl*/
if(!function_exists('encodeURL'))
{
   function encodeURL($url)
  {
	$new = strtolower(ereg_replace(' ','_',$url));
	return($new);
  }
}

/*decodeURL*/
if(!function_exists('decodeURL'))
{
  function decodeURL($url)
  {
	$new = ucwords(ereg_replace('_',' ',$url));
	return($new);
  }
}


/*break url*/
if(!function_exists('breakUrl'))
{

	function breakUrl($url)
	{
		
		return explode("/", $url);
	}

}

/****root folder***/
if(!function_exists('absoluteRoot'))
{

	function absoluteRoot()
	{

		return __DIR__;
	}

}



 
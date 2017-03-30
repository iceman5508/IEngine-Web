<?php

class location {
	
	public static function cssFile($filename)
	{
		return  appDir::cssFolder().$filename;
	}
	
	public static function jsFile($filename)
	{
		return  appDir::jsFolder().$filename;
	}
	
	public static function imageFile($filename)
	{
		return  appDir::imagesFolder().$filename;
	}
	
	
	public static function route($page)
	{
		return "?app=".$page;
	}
	

}

?>
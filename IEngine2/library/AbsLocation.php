<?php

class AbsLocation {
	
	public static function cssFile($filename)
	{
		return  parentUrl()."/".appDir::cssFolder().$filename;
	}
	
	public static function jsFile($filename)
	{
		return  parentUrl()."/".appDir::jsFolder().$filename;
	}
	
	public static function imageFile($filename)
	{
		return   parentUrl()."/".appDir::imagesFolder().$filename;
	}
	
	
	public static function route($page)
	{
		return "?app=".$page;
	}
	

}

?>
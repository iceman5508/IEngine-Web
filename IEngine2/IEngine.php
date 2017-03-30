<?php
class IEngine
{
	private $loadedClasses;
	private static $instance = NULL;
	
	/**
	 * Get the current instance of the Engine
	 */
	public static function getInstance()
	{
	
		if(!isset(self::$instance))
		{
	
			self::$instance = new IEngine();
		}
		return self::$instance;
	
	
	}
	
	private function __construct() {
	
		$this->loadedClasses = Array('iNode','iArrayList','Redirect','Inputs'
		,'Date','Mail','iString','Hash','Sessions','Dir','iFiles','Time','iGlobal',
		'Forms');
		$this->autoClass();
		$this->autoFunction();	
	
	}
	
	
	function __destruct() {
			
			
			
		unset($this->loadedClasses);
		unset($this);
	
	}
	
	
	/**
	 * Use a specific class that does not come preloaded with the engine
	 * @param String $className
	 */
	public function using($className)
	{
		$dir =  self::dirHome().'IEngine2/classes/';
		if(file_exists($dir.$className.'.php'))
		{
			require_once $dir.$className.'.php';
		}else {
			echo $className.' does not exists';
		}
	
	}
	
	/**
	 * Use a specific package
	 * @param String $PackageName
	 */
	public function usingPackage($PackageName)
	{
		$dir =  self::dirHome().'IEngine2/classes/';
		if(file_exists($dir.$PackageName))
		{
			foreach(glob($dir.$PackageName.'/*.php') as $function)
			{
				require_once($function);
			}
		}else {
			echo $PackageName.' does not exists';
		}
	
	}
	
	
	/**
	 * Use a specific class from a specific package
	 * @param string $PackageName the package class is located in
	 * @param string $classname the class to use
	 */
	public function usingFromPackage($PackageName, $classname)
	{
		$dir =  self::dirHome().'IEngine2/classes/';
		if(file_exists($dir.$PackageName))
		{
			if(file_exists($dir.$PackageName."/".$classname.".php"))
			{
					
	
				require_once($dir.$PackageName."/".$classname.".php");
			}
			else {
				echo $classname.' does not exists';
			}
	
		}else {
			echo $PackageName.' does not exists';
		}
	
	}
	
	
	/**
	 * Get the home directory
	 */
	public static function dirHome()
	{
		//return 	getcwd().'/';
		return dirname(dirname(__FILE__))."/";
	}
	
	private function autoFunction()
	{
	
		$dir =  self::dirHome().'IEngine2/functions';
		foreach(glob($dir.'/*.php') as $function)
		{
			require_once($function);
		}
	}
	
	
	private function autoClass() {
	
		$dir =  self::dirHome().'IEngine2/classes/';
		foreach($this->loadedClasses as $class)
		{
				
			if(file_exists($dir.$class.'.php'))
			{
				require_once $dir.$class.'.php';
			}else {
				echo $class.' does not exists';
			}
		}
	}

	/**
	 * Load all files in a given directory
	 * @param String $dir
	 */
	public static function loadAll($dir)
	{
		foreach(glob($dir.'/*.php') as $function)
		{
			require_once($function);
		}
	}
	
	
	/**
	 * Create the basic framework for an IEngine web project
	 */
	public  static function makeProject()
	{
		//create files
		try
		{
			mkdir("public", 0755);
			mkdir("application", 0755);
			mkdir("application/configs", 0755);
			mkdir("application/controllers", 0755);
			mkdir("application/models", 0755);
			mkdir("application/views", 0755);
			mkdir("application/views/css", 0755);
			mkdir("application/views/images", 0755);
			mkdir("application/views/js", 0755);
			mkdir("application/views/template", 0755);
			/*********Create index file*******************/
			$file = "../IEngine2/project/index.php";
			$to = "index.php";
			copy($file, $to);
				
			/*$file = "../IEngine2/webproject/iGlobal.php";
			$to = "application/controllers/iGlobal.php";
			copy($file, $to);*/
			/**********************************************/
			 	
			/****************create access file*************/
			/*$file = "../IEngine2/webproject/.htaccess";
				$to = ".htaccess";
			copy($file, $to);*/
				
			/********************************************/
	
			return true;
		}catch(Exception $e)
		{
			return false;
		}
			
	}
	

}


?>
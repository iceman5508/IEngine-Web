<?php

/** 
 * @author Isaac Parker
 *  @version 2.0 
 *  @uses To ease the use of directories.
 *  @copyright 8-03-2014    
 *  
 * 
 */

class Dir {

	
	function __construct() {
		
		
	}
	
	
    function __destruct(){
		
		
	}
	
	
	/*********Static methods************/
	/**
	 *@method dirExists
	 *@access static
	 *@uses check if directory exists<br>
	 * then return true or false.
	 *@return bool
	 *@param the directory to scan
	 *@example Dir::disExists('home');
	 *
	 */
	public static function dirExists($dirName)
	{
		if(file_exists($dirName) && is_dir($dirName))
		{
			return true;			
		} else return false; 
	}	
	
	
	/**
	 *@method kids
	 *@access static
	 *@uses scans a given directory<br>
	 * and place content in an array.
	 *@return array
	 *@param the directory to scan
	 *@example Dir::scan('home');
	 *@todo: Note that this function will only give you one level access<br>
	 *to scan all files,folders and sub directories use the scanner method
	 */
	public static function scanKids($dirName)
	{ 
		if(self::dirExists($dirName))
		{
			return array_values(array_diff(scandir($dirName), array('..', '.')));
		}else die('Directory does not exist');
	}
	
	/**
	 *@method all kids
	 *@access static
	 *@uses scans a given directory<br>
	 * and place content in an array.
	 *@return array
	 *@param the directory to scan
	 *@example Dir::scanner('home');
	 *@todo: Note that this function will give you all level access<br>
	 *however it is slower than the one level access.<br> So for one level access
	 *use the scan method.
	 */
	public static function scanFamily($dir)
	{
		if(self::dirExists($dir))
		{
			if(!isset($allKids))
			{
				$allKids = glob("$dir/*");
			}	
			$grandKids = array();		
			foreach($allKids as $files)
			{
				if(is_dir($files))
				{
						
					$grandKids = self::scanner($files);
				}
			}
			if(sizeof($grandKids)>0)
			{
				$family = array_merge($allKids,$grandKids);
				return sort($family);
			}
			else return $allKids;
		}else die('Directory does not exist');
	}
	
	/**
	 *@method copyDir
	 *@access static
	 *@uses copy files from one directory to another<br>
	 *@return true or false if function works
	 *@param destination: Directory copy to<br>
	 		 source: Directory copy From
	 *@example Dir::copyDir('from', 'to');
	 *@todo : Note if the destination folder does not exist it will be created.
	 */
	 public static function copyDir($source,$destination)
	{
		if(self::dirExists($source))
		{
				
			if (!is_dir($destination))
		  	{
			  mkdir ($destination);
		    }
		  	$dh = opendir($source) or die ('Cannot open directory '.$source.'');	
		  	while (($file = readdir($dh)) !== false)
		   {
			  if ($file != '.' && $file != '..') 
			  {
				  if (is_dir($source.'/'.$file)) 
				  {
					 self::copyDir($source.'/'.$file, $destination.'/'.$file);
				  } 
				  else 
				  {
					  copy ($source.'/'.$file , $destination.'/'.$file)
					  or die ('Cannot copy file '.$file.'');
			 	  }
			 }
		   }
		   return true;
		}else die('Source directory does not exist');
	}
	
	/**
	 *@method deleteDir
	 *@access static
	 *@uses Delete a directory and all of its contents<br>
	 *@return true or false if function works
	 *@param dir: directory to delete<br>
	 		 
	 *@example Dir::deleteDir('dir');
	 */
	static function deleteDir($dir) 
	{
		if(self::dirExists($dir))
		{
			$dh = opendir($dir) or die ('Cannot open directory '.$dir.'');	
			while (($file = readdir($dh)) !== false) 
			{
				if ($file != '.' && $file != '..')
				{
					if (is_dir($dir.'/'.$file)) 
					{
						self::deleteDir($dir.'/'.$file);
					} 
					else 
					{
						unlink ($dir.'/'.$file) or die ('Cannot delete file '.$file.'');
					}
				}
			}
			closedir($dh);
			rmdir($dir);
			return true;
		}else die('Source directory does not exist');
	}
	
	
	/**
	 *@method createeDir
	 *@access static
	 *@uses create a directory<br>
	 *@return true or false if function works
	 *@param dir: directory to create<br>
	 		  permission: the directory permission
	 		 
	 *@example Dir::createeDir('example', 0777) ;
	 *@todo Defult permission is 777
	 */
	static function createDir($dir , $permission = 0777)
	{
		if(!self::dirExists($dir))
		{
			if(is_numeric($permission)==true)
			{
				mkdir($dir, $permission);//makes a direcotry and set its permissions
				return true;
			}else echo('Permission Error: Permission must be numeric.');
			
		}else echo('Director Error: Directory already exist.');
	}
	
	
	
	
}




?>
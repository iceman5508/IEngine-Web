<?php
class easyDB
{
	    	public static function update($table, $id, $field, $fieldData)
			{
				$sql = "UPDATE ".$table." SET ".$table.".".$field."='".$fieldData."' WHERE {$table}.id=".$id."";
				$get = Database::getInstance()->query2($sql);
				
				if($get->error()==false)
			   {
					return true;
				
				}
				else
				{
					return false;
				
				}		
		
				
			}
			
				public static function updateCustom($table, $whereField,$whereEqual, $field, $fieldData)
				{
						$sql = "UPDATE ".$table." SET ".$field."='".$fieldData."' WHERE ".$whereField."=".$whereEqual."";
						$get = Database::getInstance()->query2($sql);
					if($get->error()==false)
			   		{
						return true;
				
					}
					else
					{
						return false;
				
					}		
			}
			
			public static function sqlAction($sql)
			{
				$get = Database::getInstance()->query2($sql);
				if($get->error()==false)
				{
					return true;
			
				}
				else
				{
					return false;
			
				}
			}
			
			
			
			
		
		public static function insert($table, $fields = array())
		{	  
			
			if(Database::getInstance()->insert($table , $fields))
			{
				return true;
				
			}
			else
			{
				return false;
				
			}		
		
		}
	
		public static function get($id, $table)
		{
	  		$sql = "SELECT * FROM ".$table." WHERE ".$table.".id=".$id.""; 
			$get = Database::getInstance()->query2($sql);
			if($get->count()>0)
			{
				return $get->first();
				
			}
			else
			{
				return null;
				
			}		
		
		}
		
		
		
		public static function delete($table,$field, $equalField)
		{
	  
			 $sql = "DELETE FROM ".$table." WHERE ".$table.".".$field."=".$equalField.""; 		
			
			if(Database::getInstance()->query2($sql))
			{
				return true;
			}else { return false; }
					
		}
		
		
		
		public static function getCustom($table,$field, $equalField)
		{
	  
			$sql = "SELECT * FROM ".$table." WHERE ".$table.".".$field."=".$equalField.""; 		
			$get = Database::getInstance()->query2($sql);
			if($get->count()>0)
			{
				return $get->results();
				
			}
			else
			{
				return null;
				
			}		
		
		}
		
		public static function sqlGet($sql)
		{
			
			$get = Database::getInstance()->query2($sql);
			if($get->count()>0)
			{
				return $get->results();
		
			}
			else
			{
				return null;
		
			}
		
		}
		
		
	
}
?>
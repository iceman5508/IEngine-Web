<?php

class iGlobal {
	

	private static $globals; 
	
	
	public static function init()
	{
		if(self::$globals==null)
		{
			self::$globals = new iArrayList();
		}
	}
	
	public static function AddGlobal($glabalName, $globalVar)
	{
		$i=self::$globals->count;
		if($i==0)
		{
			self::$globals->add_iNode(new iNode($glabalName, $globalVar, $i, null));
		}else
		{
			self::$globals->add_iNode(new iNode($glabalName, $globalVar, self::$globals->last->id+1, null));
		}
	}
	
	public static function getGlobalVar($globalName)
	{
		return self::$globals->getNodeData1($globalName)->Data2;
	}
	
	public static function removeFromGlobal($globalName)
	{
		$i = self::$globals->getNodeData1($globalName)->id;
		self::$globals->removeNode($i);
	}
	
	


}

?>
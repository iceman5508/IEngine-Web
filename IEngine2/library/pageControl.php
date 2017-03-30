<?php

class pageControl {

	private $pageLocations = "public/";
	private static $instance=null;
	private $infomation;
	private $homepage,$fof;
	
	
	
	
	
	private function __construct()
	{
		
		$this->infomation = new iArrayList();
	}
	
	public function __destruct()
	{
		unset($this->pageLocations);
		unset($this->infomation);
		unset($this->homepage);
		unset($this->fof);
		
	}
	
	public static function getInstance()
	{
		if(!isset(self::$instance))
		{
		
			self::$instance = new pageControl();
		}
		return self::$instance;
	}
	
	public function addPage($DisplayName, $pageName)
	{
		$count = $this->infomation->count;
		if($count>0)
		{
		
			$this->infomation->add_iNode(new iNode($DisplayName, $this->pageLocations.$pageName, $count, null));
		}
	}
	
	
	public function setHomePage($home,$DisplayName)
	{
		$this->homepage=$this->pageLocations.$home;
		$this->infomation->add_iNode(new iNode($DisplayName, $this->pageLocations.$home, 0, null));
	}
	
	public function set404($fof,$DisplayName)
	{
		$count = $this->infomation->count;
		if($count>0)
		{
			$this->fof=$this->pageLocations.$fof;
			$this->infomation->add_iNode(new iNode($DisplayName, $this->pageLocations.$fof, 1, null));
		}
	}
	
	public function getPage($DisplayName)
	{
		$page = $this->infomation->getNodeData1($DisplayName);
		if($page!=false)
		{
			return $page;
		}else {
			return false;
		}
	}
	

	public function loadPage($pageName)
	{
		if($this->getPage($pageName)!=false)
		{			
			$page = $this->getPage($pageName);
			require_once($page->Data2);
		}
	}
	
	
	public function loadTemplate($headerFile)
	{
		require_once 'application/views/template/'.$headerFile;
	}
	
	
	
	
	
	
	
}


?>
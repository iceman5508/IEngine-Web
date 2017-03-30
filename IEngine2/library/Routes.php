<?php

class Routes {

	private $pageData,$location,$currentPage,$getVars;
	
	public function __construct(pageControl $control)
	{
		$this->pageData=$control;
	}
	
	public function __destruct()
	{
		unset($this->pageData);
		unset($this->location);
		unset($this->currentPage);
		unset($this->getVars);
		unset($this);
	}
	
	
	public function routeTo()
	{
		$this->pageData->loadPage($this->location);
	}
	
	
	public function scan($home,$notFound)
	{
		//remove last slash if one is there
		$cpath = trim(currentPath());
		
			
		
		while(substr($cpath, -1) == '/' )
		{
			$cpath = rtrim($cpath, '/');
			
		}
		
		
		//pull page location
		$url = breakUrl($cpath);
		
		$location = trim($url[sizeof($url)-1]);
		
		//set the location
		$location = $this->setGetVars($location);
		if($location===false)
		{
			$this->location=$home;
			$this->currentPage=$home;
		}
		else
		if(empty($location))
		{
			$this->location=$home;
			$this->currentPage=$home;
		}else
			if($this->pageData->getPage($location)!=false)
			{
		
				$this->location = $location;
				$this->currentPage=$location;
				
			}else
			{
				
				$this->location =$notFound;
				$this->currentPage=$notFound;
			}
		
	}
	
	
	public function getCurrentPage()
	{
		return $this->currentPage;
	}
	
	private function setGetVars($url)
	{   $gets = explode(" ", $url);
	    
		$gets = explode("?", $url);
		
		unset($gets[0]);
		$var = implode("/", $gets);
		$vars = explode("=", $var);
		
		if(sizeof($vars)%2==0)
		{
			$this->getVars = new iArrayList();
			for($i=0; $i<sizeof($vars); $i++)
			{
				
				$this->getVars->add_iNode(new iNode($vars[$i], $vars[$i+1], $i, null));
				$i++;
			}
		
			if($this->get_GETVarByName('app')!==false)
			{
				return $this->get_GETVarByName('app');
			}else {
				return false;
			}
			
		}else {
			return false;
		}
	}
	
	
	public function get_GET_VARS()
	{
		return $this->getVars;
	}
	
	public function get_GETVarByName($name)
	{
		if($this->getVars!=null)
		{
		if($this->getVars->getNodeData1($name)!=false)
		{
			return $this->getVars->getNodeData1($name)->Data2;
		}else
		{
			return false;
		}
		}else {
			return false;
		}
	}
	
}

?>
<?php

class Forms {
	
	private $submit, $iArray;
	
	function __construct() {
	
		$this->submit=$this->getFormData();
		
	}
	
	function __destruct() {
	
		unset($this->submit);
		unset($this->iArray);
	}
	
	
	private function getFormData()
	{
	
		$this->iArray = new iArrayList();
	
	
	
		//check which type it is
		if(Inputs::submit('post'))
		{
			$i=0;
			foreach($_POST AS $key => $value) {
				$this->iArray->add_iNode(new iNode($key,$value, $i,null));
				$i++;
			}
	
		}else if(Inputs::submit('get')&&isset($_GET["formSent"]))
		{
			foreach($_GET AS $key => $value) {
				$this->iArray->add_iNode(new iNode($key,$value, $i,null));
				$i++;
			}
	
		}else {
			return false;
		}
		return true;
	
	
	
	}
	
	
	public function getField($fieldName)
	{
		return $this->iArray->getNodeData1($fieldName)->Data2;
	}
	
	
	public function isSubmit()
	{
		return $this->submit;
	}
	
	
	public function isFieldEmpty($fieldname)
	{
		if(strlen($this->getField($fieldname))<1)
		{
			return true;
		}else
		{
			return false;
		}
	}
	
	public function dataCount($fieldname)
	{
		return strlen($this->getField($fieldname));
	}
	
	
	public function compareFields($fieldname1,$fieldname2)
	{
		if(strcasecmp ( $this->getField($fieldname1) , $this->getField($fieldname2))==0)
		{
			return true;
		}else
		{
			return false;
		}
	}
	

}

?>
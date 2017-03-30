<?php

class iNode{
	
	public $Next,$Data1,$Data2,$id;
	
	function __construct($data,$data2, $id, $next) {
	
		$this->Data1 = $data;
		$this->Data2 = $data2;
		$this->Next = $next;
		$this->id = $id;
	
	
	}
	
	/**
	 * Set the next value of the node
	 * @param iNode $i - the node to set next to
	 */
	public function setNext(iNode $i)
	{
		$this->Next = $i;
	}
	/**
	 *
	 */
	function __destruct() {
	
		unset($this->Data1);
		unset($this->Data2);
		unset($this->Next);
		unset($this->id);
		unset($this);
	}
	
	function __toString()
	{
		return "".$this->Data1." ".$this->Data2;
	}

}

?>
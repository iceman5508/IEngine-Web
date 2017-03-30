<?php

class iArrayList {
	
	public $first, $last, $count = 0;
	
	function __construct() {
	
	}
	
	function __destruct() {
		
		unset ( $this->first );
		unset ( $this->last );
		unset ( $this->count );
		unset ( $this );
	}
	
	/**
	 * Add a new iNode to the end of the array list
	 * 
	 * @param $iNode iNode       	
	 */
	public function add_iNode(iNode $iNode) {
		if ($this->count == 0) {
			$iNode->Next = null;
			$this->first = $iNode;
			$this->last = $iNode;
			$this->count ++;
		
		} else if ($this->count >= 1) {
			$iNode->Next = null;
			$this->last->Next = $iNode;
			$this->last = $iNode;
			$this->count ++;
		
		}
	
	}
	
	/**
	 * Add new inode at a specific index in the array list
	 * 
	 * @param $iNode iNode       	
	 * @param $i unknown_type       	
	 */
	public function add_iNodeAtPos(iNode $iNode, $i) {
		if ($this->count == 0) {
			$iNode->Next = null;
			$this->first = $iNode;
			$this->last = $iNode;
			$this->count ++;
		
		} else if ($this->count >= 1) {
			$nodeInPos = $this->getNode ( $i );
			if ($i == 0) {
				$iNode->Next = $nodeInPos;
				$this->first = $iNode;
				$this->count ++;
			} else if ($i == $this->count) {
				$this->last->Next = $iNode;
				$this->last = $iNode;
				$this->count ++;
			
			} else {
				$iNode->Next = $nodeInPos;
				$this->getNode ( $i - 1 )->Next = $iNode;
				$this->count ++;
			}
		}
	
	}
	
	/**
	 * get inode at specific index
	 * 
	 * @param $index unknown_type       	
	 */
	public function getNode($index) {
		if ($index == 0) {
			$temp = $this->first;
		} else if ($index == $this->count - 1) {
			$temp = $this->last;
		} else if ($index < $this->count - 1 && $index > 0) {
			
			$temp = $this->first;
			for($i = 1; $i < $this->count; $i ++) {
				
				$temp = $temp->Next;
				if ($i == $index) {
					
					break;
				}
			}
		
		} else {
			
			$temp = null;
		}
		return $temp;
	}
	
	/**
	 * Remove inode from specific index
	 * 
	 * @param $index unknown_type       	
	 */
	public function removeNode($index) {
		$temp = null;
		if ($index >= 0 && $index < $this->count) {
			if ($index == 0) {
				if ($this->count > 1) {
					$temp = $this->first->Next;
					unset ( $this->first );
					$this->first = $temp;
					$this->count --;
				} else {
					
					unset ( $this->first );
					$this->first = null;
					$this->last = null;
					$this->count --;
				}
			
			} else if ($index == $this->count - 1) 			// last
			{
				$temp = $this->getNode ( $index - 1 );
				$temp->Next = null;
				unset ( $last );
				$this->last = $temp;
				$this->count --;
			} else if ($index > 0) {
				$previous = $this->getNode ( $index - 1 );
				$target = $this->getNode ( $index );
				$previous->Next = $target->Next;
				unset ( $target );
				$this->count --;
			
			}
		
		}
	
	}
	
	/**
	 * Sort by data 1, assumes that all data 1 is of int type
	 */
	public function sortByData1() {
		
		for($i = 0; $i < $this->count; $i ++) {
			$temp = $this->getNode ( $i );
			
			for($j = 0; $j < $this->count; $j ++) {
				if ($temp->Data1 < $this->getNode ( $j )->Data1) {
					if ($temp != null && $this->getNode ( $j ) != null) {
						$data1 = $temp->Data1;
						$data2 = $temp->Data2;
						
						$nextData1 = $this->getNode ( $j )->Data1;
						$nextData2 = $this->getNode ( $j )->Data2;
						
						$temp->Data1 = $nextData1;
						$temp->Data2 = $nextData2;
						
						$this->getNode ( $j )->Data1 = $data1;
						$this->getNode ( $j )->Data2 = $data2;
					
					}
				}
			
			}
		}
	}
	
	/**
	 * Sort by data one in reverse order.
	 * Assumes all data one is of int type
	 */
	public function sortByData1_reverse() {
		
		for($i = 0; $i < $this->count; $i ++) {
			$temp = $this->getNode ( $i );
			
			for($j = 0; $j < $this->count; $j ++) {
				if ($temp->Data1 > $this->getNode ( $j )->Data1) {
					if ($temp != null && $this->getNode ( $j ) != null) {
						$data1 = $temp->Data1;
						$data2 = $temp->Data2;
						
						$nextData1 = $this->getNode ( $j )->Data1;
						$nextData2 = $this->getNode ( $j )->Data2;
						
						$temp->Data1 = $nextData1;
						$temp->Data2 = $nextData2;
						
						$this->getNode ( $j )->Data1 = $data1;
						$this->getNode ( $j )->Data2 = $data2;
					
					}
				}
			
			}
		}
	}
	
	/**
	 * Sort by data 2 assumes..data 2 is of int type
	 */
	public function sortByData2() {
		
		for($i = 0; $i < $this->count; $i ++) {
			$temp = $this->getNode ( $i );
			
			for($j = 0; $j < $this->count; $j ++) {
				if ($temp->Data2 < $this->getNode ( $j )->Data2) {
					if ($temp != null && $this->getNode ( $j ) != null) {
						$data1 = $temp->Data1;
						$data2 = $temp->Data2;
						
						$nextData1 = $this->getNode ( $j )->Data1;
						$nextData2 = $this->getNode ( $j )->Data2;
						
						$temp->Data1 = $nextData1;
						$temp->Data2 = $nextData2;
						
						$this->getNode ( $j )->Data1 = $data1;
						$this->getNode ( $j )->Data2 = $data2;
					
					}
				}
			
			}
		}
	}
	
	/**
	 * Sort by data 2 in reverse order assumes..data 2 is of int type
	 */
	public function sortByData2_reverse() {
		
		for($i = 0; $i < $this->count; $i ++) {
			$temp = $this->getNode ( $i );
			
			for($j = 0; $j < $this->count; $j ++) {
				if ($temp->Data2 > $this->getNode ( $j )->Data2) {
					if ($temp != null && $this->getNode ( $j ) != null) {
						$data1 = $temp->Data1;
						$data2 = $temp->Data2;
						
						$nextData1 = $this->getNode ( $j )->Data1;
						$nextData2 = $this->getNode ( $j )->Data2;
						
						$temp->Data1 = $nextData1;
						$temp->Data2 = $nextData2;
						
						$this->getNode ( $j )->Data1 = $data1;
						$this->getNode ( $j )->Data2 = $data2;
					
					}
				}
			
			}
		}
	}
	
	function __toString() {
		$string = '';
		for($i = 0; $i < $this->count; $i ++) {
			if ($this->getNode ( $i ) != null || $this->getNode ( $i )->Data1 != null) {
				$string .= $this->getNode ( $i )->Data1 . " " . $this->getNode ( $i )->Data2 . "<br>";
			}
		}
		return $string;
	}
	
	/**
	 * Get inode by data one value
	 * 
	 * @param $data unknown_type       	
	 * @return iNode boolean
	 */
	public function getNodeData1($data) {
		$temp = $this->first;
		$found = false;
		for($i = 0; $i < $this->count; $i ++) {
			
			if ($temp->Data1 == $data) {
				$found = true;
				break;
			} else {
				$temp = $temp->Next;
			}
		}
		if ($found == true) {
			return $temp;
		} else {
			return false;
		}
	}

}

?>
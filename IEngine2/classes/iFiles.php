<?php
class iFiles {
	
	private $filename, $exists, $lines = 0, $size = 0, $wordCount = 0;
	private $error = array ("101" => "iFiles ERROR 101: No such file exists!",
	 "102" => "iFiles ERROR 102: File could not be created!", 
	"103" => "iFiles ERROR 103: File could not be opened!", 
	"104" => "iFiles ERROR 104: File could not be closed!", 
	"105" => "iFiles ERROR 105: File could not be deleted!", 
	"106" => "iFiles ERROR 106: File being copied to does not exist!",
	 "107" => "iFiles ERROR 107: File cannot be read!" );
	
	function __construct($file) {
		if (file_exists ( $file ) && is_file ( $file )) {
			$this->filename = $file;
			$this->exists = true;
			$this->setMetta ();
		
		} else {
			$this->filename = $file;
			$this->exists = false;
		
		}
	
	}
	
	function __destruct() {
		unset ( $this->wordCount );
		unset ( $this->size );
		unset ( $this->filename );
		unset ( $this->exists );
		unset ( $this->lines );
		unset ( $this );
	}
	
	/**
	 * Create a file
	 */
	public function createFile() {
		if ($this->exists) {
			return false;
		} else {
			// create file
			$handler = fopen ( $this->filename, 'w' ) or die ( $this->error ['102'] );
			fclose ( $handler );
			$this->setMetta ();
			$this->exists = true;
			return true;
		}
	}
	
	/**
	 * delete the file
	 */
	public function deleteFile() {
		if ($this->exists) {
			unlink ( $this->filename ) or die ( $this->error ["105"] );
			$this->exists = false;
			$this->__destruct ();
			return true;
		} else {
			
			return false;
		}
	}
	
	/**
	 * read file by line.
	 * This should return an array of the file's content. <br>
	 * With each array index representing the line-1
	 */
	public function readByLine() {
		if ($this->exists) {
			
			$lines = file ( $this->filename ); // file in to an array
			return $lines; // line 2
		
		} else {
			
			return false;
		}
	}
	
	/**
	 * Read file from a specific line
	 *
	 * @param $index int
	 *       	 - the index number to check at
	 * @return string boolean returns the string of the file at the given index
	 */
	public function readAtLine($index) {
		if ($this->exists && $index < $this->lines) {
			
			$lines = $this->readByLine ();
			return trim ( $lines [$index] );
		
		} else {
			
			return false;
		}
	}
	
	/**
	 * read file content to a massive string
	 */
	public function readToString() {
		if ($this->exists) {
			// read file
			return file_get_contents ( $this->filename );
		
		} else {
			
			return false;
		}
	}
	
	/**
	 * Append to the end of the file
	 *
	 * @param $data string
	 *       	 - data that will be added
	 */
	public function append($data) {
		if ($this->exists) {
			
			$handle = fopen ( $this->filename, "a" ) or die ( $this->error ["103"] );
			fwrite ( $handle, $data );
			fclose ( $handle );
			
			return true;
		
		} else {
			
			return false;
		}
	}
	
	/**
	 * Append to a new line at the end of the file
	 *
	 * @param $data unknown_type       	
	 */
	public function appendNewLine($data) {
		if ($this->exists) {
			
			$handle = fopen ( $this->filename, "a" ) or die ( $this->error ["103"] );
			fwrite ( $handle, "\n" . $data );
			fclose ( $handle );
			return true;
		
		} else {
			
			return false;
		}
	}
	
	private function setNumLines() {
		if ($this->exists) {
			
			if ($fh = fopen ( $this->filename, 'r' )) {
				while ( ! feof ( $fh ) ) {
					if (fgets ( $fh )) {
						$this->lines ++;
					}
				}
			}
			fclose ( $fh );
		
		} else {
			
			return false;
		}
	}
	
	/**
	 * Get the number of lines in the file
	 */
	public function numLines() {
		return $this->lines;
	}
	
	/**
	 * read file one word at a time
	 *
	 * @return multitype: boolean
	 */
	public function readFileByWord() {
		if ($this->exists) {
			$filecontents = file_get_contents ( $this->filename );
			$words = preg_split ( '/[\s]+/', $filecontents, - 1, PREG_SPLIT_NO_EMPTY );
			return $words;
		} else {
			
			return false;
		}
	}
	
	/**
	 * Divide file content by specific seperator.
	 *
	 * @param $spacer unknown_type       	
	 */
	public function splitContentBySpacer($spacer) {
		$conent = $this->readToString ();
		if ($conent != false) {
			return explode ( $spacer, $conent );
		} else {
			return false;
		}
	}
	
	/**
	 * Copy file data to another file
	 *
	 * @param $fileTo unknown_type       	
	 */
	public function copyDataTo($fileTo) {
		if ($this->exists) {
			if (file_exists ( $fileTo )) {
				$data = file ( $this->filename ) or die ( $this->error ["103"] );
				$handle = fopen ( $fileTo, "a" ) or die ( $this->error ["103"] . " fileTo" );
				for($i = 0; $i < $this->lines; $i ++) {
					
					fwrite ( $handle, $data [$i] );
				
				}
				fclose ( $handle );
				return true;
			
			} else {
				die ( $this->error ["106"] );
			}
		
		} else {
			
			return false;
		}
	}
	
	/**
	 * Get content of file between specific line range.
	 *
	 * @param $start unknown_type       	
	 * @param $end unknown_type       	
	 */
	public function getConetntByLineRange($start, $end) {
		if ($this->exists) {
			if ($end < $start) {
				die ( "End point must be equal to or greater than starting point." );
			}
			$lineCounter = $start;
			$iarray = array ();
			while ( $lineCounter < $this->lines && $lineCounter <= $end ) {
				
				if ($lineCounter == $start) {
					$iarray [] = $this->readAtLine ( $lineCounter );
				} else {
					$iarray [] = $this->readAtLine ( $lineCounter );
				}
				
				$lineCounter ++;
			}
			
			return $iarray;
		
		} else {
			
			return false;
		}
	}
	
	private function setWordCount() {
		if ($this->exists) {
			$this->wordCount = sizeof ( $this->readFileByWord () );
		} else {
			return false;
		}
	}
	
	private function setFileSize() {
		if ($this->exists) {
			$this->size = filesize ( $this->filename );
		} else {
			return false;
		}
	}
	
	/**
	 * Get file size
	 */
	public function size() {
		return $this->size;
	}
	
	/**
	 * Get number of words in the file
	 *
	 * @return number
	 */
	public function wordCount() {
		return $this->wordCount;
	}
	
	public function setMetta() {
		$this->setWordCount ();
		$this->setNumLines ();
		$this->setFileSize ();
	}
	
	/**
	 * Get the index of a specific word
	 *
	 * @param $value unknown_type       	
	 */
	public function indexOfByWords($value) {
		$words = $this->readFileByWord ();
		$count = 0;
		$found = false;
		for($i = 0; $i < $this->wordCount (); $i ++) {
			$word = $words [$i];
			if (trim ( $value ) == ($word)) {
				$found = true;
				break;
			} else {
				$count ++;
			}
		
		}
		
		return ($found == true ? $count : - 1);
	
	}
	
	/**
	 * Get the line index a given word is on
	 *
	 * @param $value unknown_type       	
	 */
	public function indexOfByLine($value) {
		$storage = new iArrayList ();
		for($i = 0; $i < $this->lines; $i ++) {
			$wordsLine = $this->readAtLine ( $i );
			$string = new iString ( $wordsLine );
			$instance = $string->AllInstancesOf ( $value );
			if ($instance != false) {
				for($y = 0; $y < sizeof ( $instance ); $y ++) {
					$storage->add_iNode ( new iNode ( $i + 1, $instance [$y], null, null ) );
				}
			}
		
		}
		return $storage;
	}
	
	/**
	 * Get a specific word by line and index
	 *
	 * @param $line unknown_type       	
	 * @param $index unknown_type       	
	 * @return Ambigous <>
	 */
	public function getWordByLineIndex($line, $index) {
		$lines = $this->readAtLine ( $line );
		$words = explode ( " ", $lines );
		return $words [$index];
	
	}
	
	/**
	 * Copy file to a new location
	 *
	 * @param $copyLocation unknown_type       	
	 */
	public function copyFileTo($copyLocation) {
		if (file_exists ( $copyLocation ) == true) {
			if ($this->exists) {
				copy ( $this->filename, $copyLocation . "/" . $this->filename );
				return true;
			
			} else {
				return false;
			}
		
		} else
			die ( $this->error ["101"] );
	}
	
	/**
	 * Move file to a new location
	 *
	 * @param $copyLocation unknown_type       	
	 */
	public function moveFileTo($copyLocation) {
		if ($this->copyFileTo ( $copyLocation )) {
			return $this->deleteFile ();
		
		} else {
			return false;
		}
	}
	
	/**
	 * erase all contents in the file
	 */
	public function clearFile() {
		if ($this->exists) {
			// create file
			$handler = fopen ( $this->filename, 'w' ) or die ( $this->error ['102'] );
			$this->setMetta ();
			fclose ( $handler );
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Write data to file
	 *
	 * @param $data unknown_type       	
	 * @param $line unknown_type       	
	 * @param $index unknown_type       	
	 * @return boolean
	 */
	function writeToFile($data, $line = NULL, $index = NULL) {
		if ($this->exists && $data !== null) {
			if ($line == null && $index == null) {
				if ($this->wordCount > 0) {
					return $this->appendNewLine ( $data );
				} else {
					return $this->append ( $data );
				}
			} else if ($line !== null && $index === null) {
				if ($line > - 1 && $line < $this->lines) {
					$words = $this->readAtLine ( $line );
					$words = $words . " " . $data . "\n";
					$lines = $this->readByLine ();
					$lines [$line] = $words;
					$this->clearFile ();
					for($i = 0; $i < sizeof ( $lines ); $i ++) {
						$this->writeToFile ( $lines [$i] );
					}
					
					return true;
				} else {
					return false;
				}
			
			} else if ($line !== null && $index !== null) {
				
				$words = $this->readAtLine ( $line );
				$wordList = explode ( " ", $words );
				$arrayList = new iArrayList ();
				for($i = 0; $i < sizeof ( $wordList ); $i ++) {
					
					$arrayList->add_iNode ( new iNode ( $wordList [$i], null, null, null ) );
				
				}
				
				$arrayList->add_iNodeAtPos ( new iNode ( $data, null, null, null ), $index );
				$wordList = array ();
				for($i = 0; $i < $arrayList->count; $i ++) {
					$wordList [] = $arrayList->getNode ( $i )->Data1;
				}
				$arrayList->__destruct ();
				$words = implode ( " ", $wordList );
				$allWords = $this->readByLine ();
				$allWords [$line] = $words . "\n";
				$this->clearFile ();
				for($i = 0; $i < sizeof ( $allWords ); $i ++) {
					$this->writeToFile ( $allWords [$i] );
				}
				return true;
			
			} else {
				return false;
			}
		
		} else {
			return false;
		
		}
	}
	
	/**
	 * Delete specific data from file
	 *
	 * @param $data unknown_type       	
	 * @param $line unknown_type       	
	 * @param $index unknown_type       	
	 */
	public function deleteFromFile($data, $line = NULL, $index = NULL) {
		if ($this->exists && $data !== null) {
			$string = new iString ( $data );
			
			if ($line === null && $index === null) {
				$lineData = $this->readByLine ();
				$this->clearFile ();
				for($i = 0; $i < sizeof ( $lineData ); $i ++) {
					$words = $lineData [$i];
					$listOfWords = explode ( " ", $words );
					for($y = 0; $y < sizeof ( $listOfWords ); $y ++) {
						
						if ($string->compare_NoCase ( trim ( $listOfWords [$y] ) )) {
							$listOfWords [$y] = "";
						}
					}
					
					$listOfWords = array_values ( $listOfWords );
					$words = implode ( " ", $listOfWords );
					if (! isEmpty ( $words )) {
						$this->writeToFile ( trim ( $words ) . "\n" );
					}
				
				}
				
				return true;
			
			} else if ($line !== null && $index === null) {
				$lineData = $this->readByLine ();
				$this->clearFile ();
				$words = $lineData [$line];
				$listOfWords = explode ( " ", $words );
				for($y = 0; $y < sizeof ( $listOfWords ); $y ++) {
					
					if ($string->compare_NoCase ( trim ( $listOfWords [$y] ) )) {
						$listOfWords [$y] = "";
					}
				}
				$listOfWords = array_values ( $listOfWords );
				$words = implode ( " ", $listOfWords );
				if (isEmpty ( $words )) {
					unset ( $lineData [$line] );
					$lineData = array_values ( $lineData );
				} else {
					$lineData [$line] = trim ( $words ) . "\n";
				}
				
				for($y = 0; $y < sizeof ( $lineData ); $y ++) {
					$this->writeToFile ( $lineData [$y] );
				}
				
				return true;
			
			} else if ($line !== null && $index !== null) {
				$wordToMove = $this->getWordByLineIndex ( $line, $index );
				$this->deleteFromFile ( $wordToMove, $line );
				
				return true;
			
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * Replace specific word with another
	 *
	 * @param $data unknown_type       	
	 * @param $replacement unknown_type       	
	 * @param $line unknown_type       	
	 * @param $index unknown_type       	
	 */
	public function replaceWordWith($data, $replacement, $line = NULL, $index = NULL) {
		if ($this->exists && $data !== null) {
			$string = new iString ( $data );
			
			if ($line === null && $index === null) {
				$lineData = $this->readByLine ();
				$this->clearFile ();
				for($i = 0; $i < sizeof ( $lineData ); $i ++) {
					$words = $lineData [$i];
					$listOfWords = explode ( " ", $words );
					for($y = 0; $y < sizeof ( $listOfWords ); $y ++) {
						
						if ($string->compare_NoCase ( trim ( $listOfWords [$y] ) )) {
							$listOfWords [$y] = $replacement;
						}
					}
					
					$listOfWords = array_values ( $listOfWords );
					$words = implode ( " ", $listOfWords );
					
					$this->writeToFile ( trim ( $words ) . "\n" );
				
				}
				
				return true;
			
			} else if ($line !== null && $index === null) {
				$lineData = $this->readByLine ();
				$this->clearFile ();
				$words = $lineData [$line];
				$listOfWords = explode ( " ", $words );
				for($y = 0; $y < sizeof ( $listOfWords ); $y ++) {
					
					if ($string->compare_NoCase ( trim ( $listOfWords [$y] ) )) {
						$listOfWords [$y] = $replacement;
					}
				}
				$listOfWords = array_values ( $listOfWords );
				$words = implode ( " ", $listOfWords );
				$lineData [$line] = trim ( $words ) . "\n";
				
				for($y = 0; $y < sizeof ( $lineData ); $y ++) {
					$this->writeToFile ( $lineData [$y] );
				}
				
				return true;
			
			} else if ($line !== null && $index !== null) {
				$wordToMove = $this->getWordByLineIndex ( $line, $index );
				$this->replaceWordWith ( $wordToMove, $replacement, $line );
				
				return true;
			
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * Replace a specific line in the file with another
	 *
	 * @param $data unknown_type       	
	 * @param $line unknown_type       	
	 */
	public function replaceLineWith($data, $line) {
		if ($this->exists && $data !== null && $line !== null) {
			$lineData = $this->readByLine ();
			$this->clearFile ();
			$lineData [$line] = $data . "\n";
			for($y = 0; $y < sizeof ( $lineData ); $y ++) {
				$this->writeToFile ( $lineData [$y] );
			}
			
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Swap two lines in the file
	 *
	 * @param $line1 unknown_type       	
	 * @param $line2 unknown_type       	
	 */
	public function swapLines($line1, $line2) {
		if ($this->exists && $line1 !== null && $line2 !== null) {
			$lineData = $this->readByLine ();
			
			$inodes = new iArrayList ();
			for($y = 0; $y < sizeof ( $lineData ); $y ++) {
				$inodes->add_iNode ( new iNode ( $lineData [$y], null, null, null ) );
			}
			$data1 = $inodes->getNode ( $line1 )->Data1;
			$data2 = $inodes->getNode ( $line2 )->Data1;
			$inodes->getNode ( $line1 )->Data1 = $data2;
			$inodes->getNode ( $line2 )->Data1 = $data1;
			$this->clearFile ();
			for($y = 0; $y < $inodes->count; $y ++) {
				$this->writeToFile ( $inodes->getNode ( $y )->Data1 );
			}
			$inodes->__destruct ();
			return true;
		
		} else {
			return false;
		}
	}
	
	/**
	 * Delete a specifc line from the file
	 *
	 * @param $line unknown_type       	
	 */
	public function deleteLine($line) {
		if ($this->exists && $line !== null) {
			$lineData = $this->readByLine ();
			
			$inodes = new iArrayList ();
			for($y = 0; $y < sizeof ( $lineData ); $y ++) {
				$inodes->add_iNode ( new iNode ( $lineData [$y], null, null, null ) );
			}
			
			$inodes->removeNode ( $line );
			
			$this->clearFile ();
			
			for($y = 0; $y < $inodes->count; $y ++) {
				$this->writeToFile ( $inodes->getNode ( $y )->Data1 );
			
			}
			
			$inodes->__destruct ();
			
			return true;
		
		} else {
			return false;
		}
	}
}

?>
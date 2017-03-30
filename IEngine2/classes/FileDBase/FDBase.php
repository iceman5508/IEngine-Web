<?php

class FDBase {
	
	private static $instance = NULL;
	private $host, $username, $password, $database, $open = false;
	private $location, $dbFound = false;
	private $lastTable;
	
	private $result = array (), $rows = null, $errors = null;
	private $error = array ("101" => "FBD ERROR 101: No such host exists!", "102" => "FBD ERROR 102: Please Check your username and password!", "103" => "FBD ERROR 103: Database already exist!", "104" => "FBD ERROR 104: table already exist!", "105" => "FBD ERROR 105: Database not open!", "106" => "FBD ERROR 106: table does not exist!", "107" => "FBD ERROR 107: Field not found!" );
	
	private $tables, $fields;
	
	private $allowCode = true;
	
	public function __destruct() {
		
		unset ( $this->result );
		unset ( $this->host );
		unset ( $this->username );
		unset ( $this->password );
		unset ( $this->database );
		unset ( $this->location );
		unset ( $this->error );
		unset ( $this->dbFound );
		unset ( $this->tables );
		unset ( $this->open );
		unset ( $this->lastTable );
		unset ( $this->allowCode);
		unset ( $this );
	
	}
	
	/**
	 * ********************************Init
	 * Section**************************************************
	 */
	private function __construct($host, $username, $password, $database) {
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;
		
		/**
		 * *********check if file exists*********
		 */
		
		if (file_exists ( $host ) && is_dir ( $host )) {
			if (file_exists ( $host . "/DB" ) && is_dir ( $host . "/DB" )) {
				
				// cheeck userinfo
				$loginCheck = new iFiles ( $host . "/DB/connfig/ini.txt" );
				if ((base64_encode ( "%iceman5508%/" . $username ) == trim ( $loginCheck->readAtLine ( 0 ) )) && (base64_encode ( "%indianpride%/" . $password ) == trim ( $loginCheck->readAtLine ( 1 ) ))) {
					$this->database = $database;
					$this->location = $host . "/DB/" . $database;
					$dbCheck = new iFiles ( $host . "/DB/connfig/tabs.txt" );
					$this->dbFound = $dbCheck->indexOfByWords ( base64_encode ( "%spurs%/" . $database . "\n" ) );
					if ($this->dbFound > - 1) {
						$this->dbFound = true;
					} else {
						$this->dbFound = false;
					}
					$dbCheck->__destruct ();
					$loginCheck->__destruct ();
					
					$this->tables = new iArrayList ();
				} else {
					throw new Exception ( $this->error ["102"] );
					die ();
				}
				
				/*
				 * if(file_exists($host."/DB/".$database)) { }
				 */
			
			} else {
				Dir::createDir ( $host . "/DB" );
				Dir::createDir ( $host . "/DB/connfig" );
				$ini = new iFiles ( $host . "/DB/connfig/ini.txt" );
				$ini->createFile ();
				$ini->writeToFile ( base64_encode ( "%iceman5508%/" . $username ) );
				$ini->appendNewLine ( base64_encode ( "%indianpride%/" . $password ) );
				
				$ini2 = new iFiles ( $host . "/DB/connfig/tabs.txt" );
				$ini2->createFile ();
				$this->database = $database;
				$this->location = $host . "/DB/" . $database;
				// $ini2->writeToFile(base64_encode("%spurs%/".$database));
				$ini2->__destruct ();
				$ini->__destruct ();
				$this->tables = new iArrayList ();
			}
			$this->fields = new iArrayList ();
		
		} else {
			throw new Exception ( $this->error ['101'] );
			die ();
		}
	
	}
	
	/**
	 *
	 *
	 *
	 *
	 * Get the current Instance of the FDBase class
	 *
	 * @param $host String
	 *       	 db hostname
	 * @param $username String
	 *       	 db username
	 * @param $password String
	 *       	 db password
	 * @param $database String
	 *       	 database name
	 * @return current FDBase insatnce
	 */
	
	public static function getInstance($host, $username, $password, $database) {
		
		if (! isset ( self::$instance )) {
			
			self::$instance = new FDBase ( $host, $username, $password, $database );
		}
		return self::$instance;
	
	}
	
	/**
	 * Makes the database if it does not exist.
	 *
	 * Note if database does exist, then error will be thrown.
	 *
	 * @throws Exception
	 */
	public function makeDB() {
		
		if ($this->dbFound === true) {
			throw new Exception ( $this->error ["103"] );
			die ();
		} else {
			Dir::createDir ( $this->location );
			$ini2 = new iFiles ( $this->host . "/DB/connfig/tabs.txt" );
			$ini2->writeToFile ( base64_encode ( "%spurs%/" . $this->database . "\n" ) );
			$ini2->__destruct ();
		}
	
	}
	
	/**
	 * Opens the database connection for crud features.
	 */
	public function openDB() {
		if ($this->dbFound == true) {
			$tables = Dir::scanKids ( $this->location );
			for($i = 0; $i < sizeof ( $tables ); $i ++) {
				$this->tables->add_iNode ( new iNode ( basename ( $tables [$i], ".fbd" ), $this->location . "/" . $tables [$i], null, null ) );
			}
			$this->open = true;
		}
	}
	
	/**
	 * Close the database and end the database session.
	 */
	public function closeDB() {
		$this->__destruct ();
	}
	
	/**
	 * Creates a table from the given name
	 *
	 * @param $tableName String
	 *       	 name of table to create.
	 *       	 If table found exception will be thrown.
	 * @throws Exception
	 */
	public function makeTable($tableName) {
		
		if ($this->open == false) {
			$this->openDB ();
		}
		if ($this->tables->getNodeData1 ($tableName) == false) {
			
			$table = new iFiles ($this->location ."/".$tableName.".fbd" );
			$table->createFile ();
			$table->__destruct ();
			$this->openDB ();
		} else {
			throw new Exception ( $this->error ["104"] );
			die ();
		}
	}
	
	/**
	 * Deletesthe database table with the given name
	 *
	 * @param $tableName String
	 *       	 name of table to delete.
	 *       	 If table not found then exception will be thrown.
	 * @throws Exception
	 */
	public function deleteTable($tableName) {
		try {
			if ($this->open) {
				if ($this->tables->getNodeData1 ( $tableName ) != false) {
					$file = new iFiles ( $this->tables->getNodeData1 ( $tableName )->Data2 );
					$file->deleteFile ();
					$this->openDB ();
				} else {
					
					throw new Exception ( $this->error ["106"] );
					die ();
				}
			
			} else {
				throw new Exception ( $this->error ["105"] );
				die ();
			}
		} catch ( Exception $e ) {
			throw new Exception ( $this->error ["105"] );
			die ();
		}
	}
	
	/**
	 * Deletes the current database
	 */
	public function deleteDB() {
		$ini2 = new iFiles ( $this->host . "/DB/connfig/tabs.txt" );
		$ini2->deleteFromFile ( base64_encode ( "%spurs%/" . $this->database . "\n" ) );
		Dir::deleteDir ( $this->location );
		$this->__destruct ();
	}
	
	/**
	 * Set fields name for a given table
	 *
	 * @param $table String
	 *       	 table to set field names for
	 * @param $fields array
	 *       	 the names to use as fields
	 *       	 throws exception when given table is not found
	 * @throws Exception
	 */
	public function setFields($table, array $fields) {
		
		if ($this->open) {
			if ($this->tables->getNodeData1 ( $table ) != false) {
				$currentTableFields = new iArrayList ();
				for($i = 0; $i < sizeof ( $fields ); $i ++) {
					
					$currentTableFields->add_iNode ( new iNode ( $fields [$i], $i, null, null ) );
				
				}
				$this->fields->add_iNode ( new iNode ( $table, $currentTableFields, null, null ) );
			} else {
				throw new Exception ( $this->error ["106"] );
				die ();
			}
		} else {
			throw new Exception ( $this->error ["105"] );
			die ();
		}
	
	}
	
	/**
	 * **********************************************************************************
	 */
	
	/**
	 * ************************************Operation
	 * section*******************************
	 */
	
	/**
	 * Get information from table where a field equals a given data
	 *
	 * @param $table String
	 *       	 table to search
	 * @param $fieldId String
	 *       	 the name of the field to check.
	 *       	 This function assums the setFields method was used prior.
	 * @param $data String
	 *       	 the data the field should equal to
	 * @throws Exception
	 */
	public function get($table, $fieldId,$data) {
		
		if ($this->open) {
			if ($this->tables->getNodeData1 ( $table ) != false) {
				
				$file = new iFiles ( $this->tables->getNodeData1 ( $table )->Data2 );
				$tableFields = $this->fields->getNodeData1 ( $table )->Data2;
				
				for($i = 0; $i < $file->numLines (); $i ++) {
					$returnLine = $file->getWordByLineIndex ( $i, $tableFields->getNodeData1 ( $fieldId )->Data2 );
					if (strtolower ( $this->toDBString ( trim ( $data ) ) ) == strtolower ( trim ( $returnLine ) )) {
						$this->result [] = $file->readAtLine ( $i );
						$this->rows = sizeof ( $this->result );
						$this->lastTable = $table;
					}
				}
				$this->errors = false;
			} else {
				throw new Exception ( $this->error ["106"] );
				die ();
			}
		
		} else {
			throw new Exception ( $this->error ["105"] );
			die ();
		}
		
		
		
	}
	
	/**
	 * Get information from table where a field equals a given data
	 *
	 * @param $table String
	 *       	 table to search
	 * @param $fieldId String
	 *       	 the name of the field to check.
	 *       	 This function assums the setFields method was used prior.
	 * @param $data String
	 *       	 the data the field should equal to
	 * @param $fieldId2 String
	 *       	 the second field to check
	 * @param $data2 String
	 *       	 the data that field should equal to
	 * @throws Exception
	 */
	public function getAnd($table, $fieldId, $data, $fieldId2, $data2) {
		if ($this->open) {
			if ($this->tables->getNodeData1 ( $table ) != false) {
				
				$file = new iFiles ( $this->tables->getNodeData1 ( $table )->Data2 );
				$tableFields = $this->fields->getNodeData1 ( $table )->Data2;
				
				for($i = 0; $i < $file->numLines (); $i ++) {
					$returnLine = $file->getWordByLineIndex ( $i, $tableFields->getNodeData1 ( $fieldId )->Data2 );
					$returnLine2 = $file->getWordByLineIndex ( $i, $tableFields->getNodeData1 ( $fieldId2 )->Data2 );
					if (strtolower ( $this->toDBString ( trim ( $data ) ) ) == strtolower ( trim ( $returnLine ) )) {
						if (strtolower ( $this->toDBString ( trim ( $data2 ) ) ) == strtolower ( trim ( $returnLine2 ) )) {
							$this->result [] = $file->readAtLine ( $i );
							$this->rows = sizeof ( $this->result );
							$this->lastTable = $table;
						}
					}
				}
				$this->errors = false;
			} else {
				throw new Exception ( $this->error ["106"] );
				die ();
			}
		
		} else {
			throw new Exception ( $this->error ["105"] );
			die ();
		}
	}
	
	/**
	 * Get information from table where a field equals a given data
	 *
	 * @param $table String
	 *       	 table to search
	 * @param $fieldId String
	 *       	 the name of the field to check.
	 *       	 This function assums the setFields method was used prior.
	 * @param $data String
	 *       	 the data the field could equal to
	 * @param $fieldId2 String
	 *       	 the second field to check
	 * @param $data2 String
	 *       	 the data that field could equal to
	 * @throws Exception
	 */
	public function getOr($table, $fieldId, $data, $fieldId2,  $data2) {
		if ($this->open) {
			if ($this->tables->getNodeData1 ( $table ) != false) {
				
				$file = new iFiles ( $this->tables->getNodeData1 ( $table )->Data2 );
				$tableFields = $this->fields->getNodeData1 ( $table )->Data2;
				
				for($i = 0; $i < $file->numLines (); $i ++) {
					$returnLine = $file->getWordByLineIndex ( $i, $tableFields->getNodeData1 ( $fieldId )->Data2 );
					$returnLine2 = $file->getWordByLineIndex ( $i, $tableFields->getNodeData1 ( $fieldId2 )->Data2 );
					if (strtolower ( $this->toDBString ( trim ( $data ) ) ) == strtolower ( trim ( $returnLine ) )) {
						
						$this->result [] = $file->readAtLine ( $i );
						$this->rows = sizeof ( $this->result );
						$this->lastTable = $table;
					
					} else if (strtolower ( $this->toDBString ( trim ( $data2 ) ) ) == strtolower ( trim ( $returnLine2 ) )) {
						$this->result [] = $file->readAtLine ( $i );
						$this->rows = sizeof ( $this->result );
						$this->lastTable = $table;
					}
				}
				$this->errors = false;
			} else {
				throw new Exception ( $this->error ["106"] );
				die ();
			}
		
		} else {
			throw new Exception ( $this->error ["105"] );
			die ();
		}
	}
	
	/**
	 * Search table and return all rows where given field does not equal given
	 * data
	 *
	 * @param $table String
	 *       	 table to search
	 * @param $fieldId String
	 *       	 field name to check
	 * @param $data String
	 *       	 the data field should not equal to
	 * @throws Exception
	 */
	public function getNot($table,$fieldId, $data) {
		if ($this->open) {
			if ($this->tables->getNodeData1 ( $table ) != false) {
				
				$file = new iFiles ( $this->tables->getNodeData1 ( $table )->Data2 );
				$tableFields = $this->fields->getNodeData1 ( $table )->Data2;
				
				for($i = 0; $i < $file->numLines (); $i ++) {
					$returnLine = $file->getWordByLineIndex ( $i, $tableFields->getNodeData1 ( $fieldId )->Data2 );
					
					if (strtolower ( $this->toDBString ( trim ( $data ) ) ) != strtolower ( trim ( $returnLine ) )) {
						
						$this->result [] = $file->readAtLine ( $i );
						$this->rows = sizeof ( $this->result );
						$this->lastTable = $table;
					
					}
				}
				$this->errors = false;
			} else {
				throw new Exception ( $this->error ["106"] );
				die ();
			}
		
		} else {
			throw new Exception ( $this->error ["105"] );
			die ();
		}
	}
	
	/**
	 * Get all rows from a given table
	 *
	 * @param $table String
	 *       	 table to return all row data from
	 */
	public function getAll( $table) {
		if ($this->open) {
			if ($this->tables->getNodeData1 ( $table ) != false) {
				$this->lastTable = $table;
				$file = new iFiles ( $this->tables->getNodeData1 ( $table )->Data2 );
				return $this->toReadString ( $file->readByLine () );
			} else {
				$this->errors [] = $this->error ["106"];
			}
		
		} else {
			$this->errors [] = $this->error ["105"];
		}
	}
	
	/**
	 * Delete data from the table that match the given details
	 *
	 * @param $table String
	 *       	 the table to delete from
	 * @param $fieldId String
	 *       	 the field name to check.
	 *       	 This method assums setFields method was used prior.
	 * @param $data String
	 *       	 the matching data to check for.
	 */
	public function delete($table,  $fieldId,  $data) {
		if ($this->open) {
			if ($this->tables->getNodeData1 ( $table ) != false) {
				
				$file = new iFiles ( $this->tables->getNodeData1 ( $table )->Data2 );
				$tableFields = $this->fields->getNodeData1 ( $table )->Data2;
				
				for($i = 0; $i < $file->numLines (); $i ++) {
					$returnLine = $file->getWordByLineIndex ( $i, $tableFields->getNodeData1 ( $fieldId )->Data2 );
					if ($this->toDBString ( $this->toDBString ( strtolower ( trim ( $data ) ) ) ) == strtolower ( trim ( $returnLine ) )) {
						$this->lastTable = $table;
						$file->deleteLine ( $i );
					
					}
				}
				
				$this->result = $file->readByLine ();
				$this->rows = sizeof ( $this->result );
				$this->errors = false;
			} else {
				$this->errors [] = $this->error ["106"];
			}
		
		} else {
			$this->errors [] = $this->error ["105"];
		}
	}
	
	/**
	 * Delete data from the table that match the given details
	 *
	 * @param $table String
	 *       	 the table to delete from
	 * @param $fieldId String
	 *       	 the field name to check.
	 *       	 This method assums setFields method was used prior.
	 * @param $data String
	 *       	 the matching data to check for.
	 *       	
	 * @param $fieldId2 String
	 *       	 the second field name to check.
	 *       	 This method assums setFields method was used prior.
	 * @param $data2 String
	 *       	 the matching data to check for.
	 */
	public function deleteAnd($table,  $fieldId,  $data,  $fieldId2, $data2) {
		if ($this->open) {
			if ($this->tables->getNodeData1 ( $table ) != false) {
				
				$file = new iFiles ( $this->tables->getNodeData1 ( $table )->Data2 );
				$tableFields = $this->fields->getNodeData1 ( $table )->Data2;
				
				for($i = 0; $i < $file->numLines (); $i ++) {
					$returnLine = $file->getWordByLineIndex ( $i, $tableFields->getNodeData1 ( $fieldId )->Data2 );
					$returnLine2 = $file->getWordByLineIndex ( $i, $tableFields->getNodeData1 ( $fieldId2 )->Data2 );
					if ($this->toDBString ( $this->toDBString ( strtolower ( trim ( $data ) ) ) ) == strtolower ( trim ( $returnLine ) )) {
						if ($this->toDBString ( $this->toDBString ( strtolower ( trim ( $data2 ) ) ) ) == strtolower ( trim ( $returnLine2 ) )) {
							$this->lastTable = $table;
							$file->deleteLine ( $i );
						}
					
					}
				}
				
				$this->result = $file->readByLine ();
				$this->rows = sizeof ( $this->result );
				$this->errors = false;
			} else {
				$this->errors [] = $this->error ["106"];
			}
		
		} else {
			$this->errors [] = $this->error ["105"];
		}
	}
	
	
	/**
	 * Delete data from the table that match the given details
	 *
	 * @param $table String
	 *       	 the table to delete from
	 * @param $fieldId String
	 *       	 the field name to check.
	 *       	 This method assums setFields method was used prior.
	 * @param $data String
	 *       	 the matching data to check for.
	 *
	 * @param $fieldId2 String
	 *       	 the second field name to check.
	 *       	 This method assums setFields method was used prior.
	 * @param $data2 String
	 *       	 the matching data to check for.
	 */
	public function deleteOr($table, $fieldId, $data, $fieldId2,  $data2) {
		if ($this->open) {
			if ($this->tables->getNodeData1 ( $table ) != false) {
	
				$file = new iFiles ( $this->tables->getNodeData1 ( $table )->Data2 );
				$tableFields = $this->fields->getNodeData1 ( $table )->Data2;
	
				for($i = 0; $i < $file->numLines (); $i ++) {
					$returnLine = $file->getWordByLineIndex ( $i, $tableFields->getNodeData1 ( $fieldId )->Data2 );
					$returnLine2 = $file->getWordByLineIndex ( $i, $tableFields->getNodeData1 ( $fieldId2 )->Data2 );
					if ($this->toDBString ( $this->toDBString ( strtolower ( trim ( $data ) ) ) ) == strtolower ( trim ( $returnLine ) )) {
						
							$this->lastTable = $table;
							$file->deleteLine ( $i );				
							
					}else 	if ($this->toDBString ( $this->toDBString ( strtolower ( trim ( $data2 ) ) ) ) == strtolower ( trim ( $returnLine2 ) )) {
							$this->lastTable = $table;
							$file->deleteLine ( $i );
						}
				}
	
				$this->result = $file->readByLine ();
				$this->rows = sizeof ( $this->result );
				$this->errors = false;
			} else {
				$this->errors [] = $this->error ["106"];
			}
	
		} else {
			$this->errors [] = $this->error ["105"];
		}
	}
	
	
	/**
	 * Delete data from the table that match the given details
	 *
	 * @param $table String
	 *       	 the table to delete from
	 * @param $fieldId String
	 *       	 the field name to check.
	 *       	 This method assums setFields method was used prior.
	 * @param $data String
	 *       	 the matching data to check for. Note anything not equal this data will be deleted
	 *
	 *
	 */
	public function deleteNot($table,  $fieldId,  $data) {
		if ($this->open) {
			if ($this->tables->getNodeData1 ( $table ) != false) {
	
				$file = new iFiles ( $this->tables->getNodeData1 ( $table )->Data2 );
				$tableFields = $this->fields->getNodeData1 ( $table )->Data2;
	
				for($i = 0; $i < $file->numLines (); $i ++) {
					$returnLine = $file->getWordByLineIndex ( $i, $tableFields->getNodeData1 ( $fieldId )->Data2 );
					
					if ($this->toDBString ( $this->toDBString ( strtolower ( trim ( $data ) ) ) ) != strtolower ( trim ( $returnLine ) )) {
	
						$this->lastTable = $table;
						$file->deleteLine ( $i );
							
					}
				}
	
				$this->result = $file->readByLine ();
				$this->rows = sizeof ( $this->result );
				$this->errors = false;
			} else {
				throw new Exception( $this->error ["106"]);
				die();
			}
	
		} else {
			throw new Exception( $this->error ["105"]);
		}
	}
	
	/**
	 * Insert data into the table
	 *
	 * @param $table String
	 *       	 the table to insert data to
	 * @param $fieldId array
	 *       	 the data to enter.
	 *       	 Note that number of data provided must match number of fields
	 *       	 the table has
	 * @throws Exception
	 */
	public function insert( $table, array $fieldId) {
		if ($this->open) {
			if ($this->tables->getNodeData1 ( $table ) != false) {
				
				$file = new iFiles ( $this->tables->getNodeData1 ( $table )->Data2 );
				$tableFields = $this->fields->getNodeData1 ( $table )->Data2;
				
				if (sizeof ( $fieldId ) == $tableFields->count) {
					
					for($i = 0; $i < sizeof ( $fieldId ); $i ++) {
						$value = $fieldId [$i];
						if ($i == 0) {
							if ($this->numRowsInTable ( $table ) > 0) {
								$file->appendNewLine ( $this->toDBString ( $value ) );
							} else {
								$file->append ( $this->toDBString ( $value ) );
							}
						
						} else {
							$file->append ( " " . $this->toDBString ( $value ) );
						}
					
					}
					$this->lastTable = $table;
					$this->result = $file->readByLine ();
					$this->rows = sizeof ( $this->result );
					$this->errors = false;
				} else {
					throw new Exception ( "Please fill in all columns of the table" );
					die ();
				}
			
			} else {
				throw new Exception ( $this->error ["106"] );
				die ();
			}
		
		} else {
			throw new Exception ( $this->error ["105"] );
			die ();
		}
	
	}
	
	/**
	 * Update data in a given table
	 *
	 * @param $table String
	 *       	 table where data will be updated
	 * @param $id String
	 *       	 the id of the data being updated
	 * @param $fieldId String
	 *       	 the field the update will occur
	 * @param $data String
	 *       	 the updated data
	 * @throws Exception
	 */
	public function update( $table, $id,  $fieldId,  $data) {
		if ($this->open) {
			if ($this->tables->getNodeData1 ( $table ) != false) {
				
				$file = new iFiles ( $this->tables->getNodeData1 ( $table )->Data2 );
				$tableFields = $this->fields->getNodeData1 ( $table )->Data2;
				
				$field = $tableFields->getNodeData1 ( $fieldId )->Data2;
				if ($field !== false) {
					$file->replaceWordWith ( "", $this->toDBString ( $data ), $id, $field );
					$this->result = $file->readByLine ();
					$this->rows = sizeof ( $this->result );
					$this->errors = false;
					$this->lastTable = $table;
				} else {
					throw new Exception ( "Field does not exist!" );
					die ();
				}
			
			} else {
				throw new Exception ( $this->error ["106"] );
			}
		
		} else {
			throw new Exception ( $this->error ["105"] );
			die ();
		}
	
	}
	
	/**
	 * Get number of rows in a given table
	 *
	 * @param $table String
	 *       	 table to check
	 * @throws Exception
	 */
	public function numRowsInTable($table) {
		if ($this->open) {
			if ($this->tables->getNodeData1 ( $table ) != false) {
				
				$file = new iFiles ( $this->tables->getNodeData1 ( $table )->Data2 );
				return sizeof ( $file->readByLine () );
			} else {
				throw new Exception ( $this->error ["106"] );
				die ();
			}
		}
	}
	
	/**
	 * Get all data associated with a given field in the table
	 *
	 * @param $index unknown_type       	
	 * @param $field String
	 *       	 the field to get data for
	 * @return mixed
	 */
	public function pullField($index = 0, $field) {
		if (sizeof ( $this->result ) > 0) {
			
			$tableFields = $this->fields->getNodeData1 ( $this->lastTable )->Data2;
			$fields = $tableFields->getNodeData1 ( $field )->Data2;
			
			$data = explode ( " ", $this->result [$index] );
			
			return $this->toReadString ( $data [$fields] );
		
		} else {
			throw new Exception( $this->error ["107"] );
			die();
		}
	}
	
	/**
	 * *************************************************************
	 */
	
	public function indexResults() {
		if (count ( $this->result ) == 1) {
			
			if($this->allowCode==true)
			{
				return $this->toReadString(explode ( " ", $this->result [0] ));
			}else
			{
				return $this->toReadString(explode ( " ", escapeCode(($this->result [0] ))));
			}
		}
	}
	
	public function indexResults_raw() {
		if (count ( $this->result ) == 1) {
				
			if($this->allowCode==true)
			{
				return (explode ( " ", $this->result [0] ));
			}else
			{
				return (explode ( " ", escapeCode(($this->result [0] ))));
			}
		}
	}
	
	
	public function emptyResultsBuffer()
	{
		$this->result = array();
	}
	
	/**
	 * *****************************Returns
	 * sections**************************************
	 */
	/**
	 * returns the results of a get statament
	 */
	public function results() {
		if($this->allowCode)
		{
		return $this->toReadString ( $this->result );
		}else {
			return $this->toReadString ( escapeCode($this->result ));
		}
	}
	
	
	/**
	 * returns the raw results of a get statament
	 */
	public function results_raw() {
		if($this->allowCode)
		{
			return ( $this->result );
		}else {
			return  ( escapeCode($this->result ));
		}
	}
	
	
	/**
	 * Returns all database error
	 *
	 * @return array
	 */
	public function errors() {
		return $this->errors;
	}
	
	/**
	 * Return the number of rows from a get statement
	 */
	public function rows() {
		return $this->rows;
	}
	
	/**
	 * Returns all tables for the current database
	 */
	public function getTables() {
		return $this->tables;
	}
	
	private function toDBString($data) {
		return str_replace ( ' ', '_', $data );
	}
	
	private function toReadString($data) {
		return str_replace ( '_', ' ', $data );
	}

	/**
 * *******************************************************************
 */
	
	
	public function clearTable($table)
	{
		if ($this->open) {
			if ($this->tables->getNodeData1 ( $table ) != false) {
		
				$file = new iFiles ( $this->tables->getNodeData1 ( $table )->Data2 );
				$file->clearFile();
				
			} else {
				throw new Exception ( $this->error ["106"] );
				die ();
			}
		}
	}
	
	
	public function noCode()
	{
		$this->allowCode = false;
	}
	
	public function getAllTables()
	{
		return $this->tables;
	}
}

?>
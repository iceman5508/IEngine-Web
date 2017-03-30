<?php

class Database {
	
	private function __construct() 
	{
		
		try
		{
			$this->pdo = new PDO('mysql:host='.ConfigClass::get('mysql/host').';dbname='.ConfigClass::get('mysql/db').'',ConfigClass::get('mysql/username'),ConfigClass::get('mysql/password'));
				
		}
		catch(PDOException $e)
		{
			die($e->getMessage());
				
		}
	}
	
	public static function getInstance()
	{
	
		if(!isset(self::$instance))
		{
	
			self::$instance = new Database();
		}
		return self::$instance;	
	}
	
	public function query2($sql)
	{
		$this->error=false;
		if($this->query = $this->pdo->prepare($sql))
		{
	
			if($this->query->execute())
			{
				$this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
				$this->count = $this->query->rowCount();
			}
			else
			{
				$this->error = true;
			}
		}
		return $this;
	
	}
	
	public function query($sql, $params = array())
	{
		$this->error=false;
		if($this->query = $this->pdo->prepare($sql))
		{
			$n=1;
			if(count($params))
			{
				foreach($params as $param)
				{
					$this->query->bindValue($n, $param);
					$n++;
				}
			}
			if($this->query->execute())
			{
				$this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
				$this->count = $this->query->rowCount();
			}
			else
			{
				$this->error = true;
			}
		}
		return $this;
	
	}
	
	public function error()
	{
		return $this->error;
	}
	
	
	public function get($table, $where)
	{
		return $this->action('SELECT *',$table,$where);
	}
	
	public function delete($table, $where)
	{
		return $this->action('DELETE',$table,$where);
	}
	
	public function count()
	{
		return $this->count;
	}
	
	
	public function results()
	{
		return $this->results;
	}
	
	public function first()
	{
		$result = $this->results();
		return $result[0];
	}
	
	/**
	 *@MethodName: insert
	 *@Purpose: insert data in database
	 *@Precondition:
	 *@Params:
	 *@Params
	 *
	 *@access : public
	 *@Postcondition:
	 *
	 *@MethodCallExample:
	 *
	 */
	public function insert($table , $fields = array())
	{
		if(count($fields))
		{
			$keys = array_keys($fields);
			$values = ' ';
			$x= 1;
			foreach($fields as $field)
			{
				$values .= '?';
				if($x < count($fields))
				{
					$values .= ', ';
				}
				$x++;
					
			}
	
			$sql = 'INSERT INTO '.$table.' (`'.implode('`, `', $keys).'`)VALUES('.$values.')';
	
			if(!$this->query($sql, $fields)->error())
			{
				return true;
					
			}
	
		}
		return false;
	}
	
	
	/**
	 *@MethodName: update
	 *@Purpose: updates data in the datbase
	 *@Precondition:
	 *@Params:
	 *@Params
	 *
	 *@access : public
	 *@Postcondition:
	 *
	 *@MethodCallExample:
	 *
	 */
	public function update($table, $id, $fields)
	{
		$set = ' ';
		$x=1;
	
		foreach($fields as $field => $value)
		{
			$set .= ''.$field.' = ? ';
			if($x < count($fields))
			{
				$set .= ' , ';
			}
			$x++;
		}
	
		$sql = 'UPDATE '.$table.' SET '.$set.' WHERE id = '.$id.' ';
		if(!$this->query($sql, $fields)->error())
		{
			return true;
		}else
		{
			return false;
		}
			
	}
	/***************************private and protected methods*******************/
	
	/**
	 *@MethodName: action
	 *@Purpose: perform query action to make inputing query request easy
	 *@Precondition:
	 *@Params: $table, $where $action
	 *@Params details: $table: database table that will be used
	 *					$where: table value being checked.
	 *					$action: the action that will be used.
	 *
	 *@access : private
	 *@Postcondition:
	 *
	 *@MethodCallExample:
	 *
	 */
	private function action($action, $table, $where = array())
	{
		if(count($where)===3)
		{
			$operator = array('>','<','<=','>=','=','!=', 'AND','NOT','OR','+','-','%','*','/','<>','!<','!>','ALL','LIKE');
	
			$field = $where[0];
			$op = $where[1];
			$value = $where[2];
			if(in_array($op,$operator))
			{
				if(is_array($table))
				{
					$sql = ''.$action.' FROM '.$table[0].','.$table[1].' WHERE '.$field.''.$op.'?';
				}
				else
				{
					$sql = ''.$action.' FROM '.$table.' WHERE '.$field.''.$op.'?';
				}
				if(!$this->query($sql, array($value))->error())
				{
					return $this;
	
				}
			}
	
		}
		return false;
	}
	
	/***************************************public variables******************/
	
	public function getPDO()
	{
		
		return $this->pdo;
	}
	
	/*************************private and protected variables******************/
	private static $instance = NULL;
	private $pdo, $query, $error = false, $results, $count = 0;
	
	
	
	
	function __destruct() {
	
			unset($this->pdo);
			unset($this->query);
			unset($this->error);
			unset($this->results);
			unset($this->count);
	}
}

?>
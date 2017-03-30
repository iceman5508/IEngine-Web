<?php
/**
*Users Class. 
*
* handles all user information for user related taskes.  
*
 * Copyright (c) 2014 Isaac Parker
 * Licensed under the GNU General Public License version 3.0 (GPLv3)
*@version 1.4.14
*@author Isaac Parker <isaacparker94@gmail.com>
*@package Class
*@Subpackage: 
*
*@LastEditDate:
*@Editor:
*@EditorNotes:
*
*
*					
*/
class Users
{
	
	
	
/******************************Magic methods****************************/	
	
	
	 /**
	 *@MethodName: __construct
	 *@Purpose: Defult execution once class is called
	 *@Precondition: 
	 *@Params: 
	 *@Params details: 
	 *					
	 *
	 *@Postcondition: open Form
	 *
	 *@MethodCallExample: $objectName = new Users();
	 *					
	 */	
	public function __construct($table=NULL,$user=NULL,$userField=NULL)
	{
	
		$this->DBase = Database::getInstance();
		$this->session = ConfigClass::get('session/sessionName');
		
		if(!$user)
		{
			
			$this->loggedin=false;	
			$this->set=false;
			
		}
		else
		{
			
			$this->find($table,$user,$userField);
			
			
		}
		
	}	
	
	
	
	
/*******************************public methods****************************/	
	
	
	 /**
	 *@MethodName:create
	 *@Purpose: create a user by inserting them into database
	 *@Precondition: 
	 *@Params: 
	 *@Params details: 
	 *					
	 *
	 *@Postcondition: 
	 *
	 *@MethodCallExample: 
	 */	
	public function create($table,$fields=array())
	{
	
		if(!$this->DBase->insert($table , $fields))
		{
			throw new Exception('data could not be added, please try again later.'); 
			
		}
		
	}	
	
	
	/**
	 *@MethodName:find
	 *@Purpose: find a specific value in a didbase
	 *@Precondition: 
	 *@Params: 
	 *@Params details: 
	 *					
	 *
	 *@Postcondition: 
	 *
	 *@MethodCallExample: 
	 */	
	public function find($table,$username=NULL,$usernameField=NULL)
	{
		if($username)
		{
		 
			$field = (is_numeric($username)? 'id' : $usernameField);
			
			$data = $this->DBase->get($table , array($field, '=', $username));
			
			if($data->count())
			{
				$this->set=true;
				$this->dbData = $data->first();
				return true;
			}else
			{
				$this->set=false;
				return false;	
			}
			
		}else
		{
			$this->set=false;
			return false;
		}
		
	}	
	
	/**
	 *@MethodName:login
	 *@Purpose: to log user in
	 *@Precondition: 
	 *@Params: 
	 *@Params details: 
	 *					
	 *
	 *@Postcondition: 
	 *
	 *@MethodCallExample: 
	 */	
	public function hashlogin($username=NULL, $password=NULL, $table=NULL, $usernameField=NULL,$passwordField=NULL,$hashField=NULL)
	{
		if($username && $password)
		{
			
			$user = $this->find($table,$username,$usernameField);
			if($user)
			{
				if($this->data()->$passwordField === Hash::make($password , $this->data()->$hashField))
				{
					
					Sessions::put($this->session, $this->data()->id);
					return true;
				}
				
			}
			
		}else
		{
			return false;
		}
		
	}
	
	public function md5login($username=NULL, $password=NULL, $table=NULL, $usernameField=NULL, $passwordField= NULL)
	{
		if($username && $password)
		{
			
			$user = $this->find($table,$username,$usernameField);
			if($user)
			{
				if($this->data()->$passwordField  === md5($password))
				{
					
					Sessions::put($this->session, $this->data()->id);
					return true;
				}
				
			}
			
		}else
		{
			return false;
		}
		
	}		
	
	
	public function simpleLogin($username=NULL, $password=NULL, $table=NULL, $usernameField=NULL, $passwordField= NULL)
	{
		if($username && $password)
		{
				
			$user = $this->find($table,$username,$usernameField);
			if($user)
			{
				if($this->data()->$passwordField  === $password)
				{
						
					Sessions::put($this->session, $this->data()->id);
					return true;
				}
	
			}
				
		}else
		{
			return false;
		}
	
	}
	
	
	/**
	 *@MethodName:logout
	 *@Purpose: to log user out
	 *@Precondition: 
	 *@Params: 
	 *@Params details: 
	 *					
	 *
	 *@Postcondition: 
	 *
	 *@MethodCallExample: 
	 */	
	 public function logout()
	 {
		 
		if(Sessions::delete($this->session))
		{
			return true;
		}
		else 
		{
		 return false;	
		}
	 }
	 
	 /**
	 *@MethodName:info
	 *@Purpose: get user informaion
	 *@Precondition: 
	 *@Params: 
	 *@Params details: 
	 *					
	 *
	 *@Postcondition: 
	 *
	 *@MethodCallExample:
	 **/
	 public function info($key)
	 {
		if(is_string($key))
		{
			return $this->data()->$key;		
		}		 
		 
	 }
	 
	 
	 /**
	 *@MethodName:getStatus
	 *@Purpose: get the session status of user
	 *@Precondition: 
	 *@Params: 
	 *@Params details: 
	 *					
	 *
	 *@Postcondition: 
	 *
	 *@MethodCallExample:
	 **/
	 public function getStatus()
	 {
		return $this->loggedin;	 
		 
	 }
	 
	  
	 
	 /**
	 *@MethodName:update
	 *@Purpose: update user data
	 *@Precondition: 
	 *@Params: 
	 *@Params details: 
	 *					
	 *
	 *@Postcondition: 
	 *
	 *@MethodCallExample:
	 **/
	 public function update($table,$id=NULL,$fields = array())
	 {
		 if(!$id && $this->loggedin)
		 {
			$id = $this->info('id'); 
		 }
		if(!$this->DBase->update($table,$id=NULL, $fields))
		{
			throw new Exception('There was a problem updating');
				
		}
		 
	 }
/***************************private and protected methods*******************/	
	/**
	 *@MethodName: data
	 *@Purpose: pull speific data from database
	 *@Precondition: 
	 *@Params: 
	 *@Params details: 
	 *					
	 *
	 *@Postcondition: 
	 *
	 *@MethodCallExample: 
	 */	
	private function data()
	{
		
		return $this->dbData;
		
	}
	
/***************************************public variables******************/		
	
/*************************private and protected variables******************/	
private $DBase, $dbData, $session, $loggedin;
public $set;
	
	
	
}
/****************************end of class******************************/

/************************cLASS related funtions************************/



?>
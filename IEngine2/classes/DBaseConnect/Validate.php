<?php
/**
*Validate Class. 
*
*A validation class
*
*@version 1.3.14
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


class Validate
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
	 *@MethodCallExample: $objectName = new Validate();
	 *					
	 */	
	public function __construct()
	{
	
		$this->dbase = Database::getInstance();
		
	}	
	
	
/*******************************public methods****************************/	
/*@methodName: check
*@purposee: check data that is being validated
*@param: 
*@paramDetail:  
*@preCondition: 
*@postCondition: 
*@access: public
*
*
*/
public function check($source, $items= array())
{
	foreach($items as $item => $rules)
	{
		foreach($rules as $rule => $data)
		{
			
			$value = trim($source[$item]);
			
			$name = implode(',' , $rules);
			$name = explode(',' , $name) ;
			$tbUsers = $name[1];
			$name = escape($name[0]);
			
			if($rule === 'required' && empty($value) )
			{
				
								
				$this->addError(''.$name.' is required.');
				
			}
			else if(!empty($value))
			{
				switch($rule)
				{
					case 'min':
						if(strlen($value) <$data)
						{
							$this->addError(''.$name.' must be at least '.$data.' characters.');
						}
					break;
					case 'max':
					if(strlen($value) >$data)
						{
							$this->addError(''.$name.' must be at most '.$data.' characters.');
						}
					break;
					case 'unique':
						$check = $this->dbase->get($data , array($tbUsers ,'=', $value));
												
						if($check->count())
						{
							$this->addError('This '.$name.' is already taken');
						}
					break;
					default:
					break;
					
				}
			}
			
		}
		
	}
	
	if(empty($this->error))
	{
		$this->passed = true; 
		
	}
	
	return $this;
}



/*@methodName: errors
*@purposee: return list of errors
*@param: 
*@paramDetail:  
*@preCondition: 
*@postCondition: 
*@access: public
*
*
*/
public function errors()
{
	return $this->error;	
}

/*@methodName: passed
*@purposee: returns if valid test passed or not
*@param: 
*@paramDetail:  
*@preCondition: 
*@postCondition: 
*@access: public
*
*
*/
public function passed()
{
	return $this->passed;	
}
/***************************private and protected methods*******************/	
/*@methodName: addError
*@purposee: add into the error array
*@param: $error
*@paramDetail: $error: The error that will be added into array.  
*@preCondition: 
*@postCondition: 
*@access: private
*
*
*/

private function addError($error)
{
	$this->error[] = $error;	
}	

/***************************************public variables******************/	

	
	
/*************************private and protected variables******************/	
private $passed = false, $error = array(), $dbase = NULL;
	
	
}
/****************************end of class******************************/

/************************cLASS related funtions************************/



?>
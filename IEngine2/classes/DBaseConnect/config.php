<?php


/**
 *@name configConnection
 *@uses setup use of config class
 *@param requested information
 */
function configConnection($host=null,$dbUser=null,$dbPass=null,$db=null,$cookieName=null,$killTime=null,$sessionName=null,$tokenName=null)
{
	return $GLOBALS['config'] = array(
			'mysql' => array(
					'host' => $host,
					'username' => $dbUser,
					'password' => $dbPass,
					'db' => $db
			),
			'remember' => array(

					'cookieName' => $cookieName,
					'cookieDie' =>  (int)$killTime
			),
			'session' =>array(
					'sessionName' => $sessionName,
					'tokeName' => $tokenName
			)
	);
}


?>
<?php
/**
*@author Isaac Parker
*@date 1-13-2016
*@detail
*	This is an email script to allow to userrs who were added into the database
*	to be contacted. This also allows the peoplpe who were removed from the database to be 
*	emailed.
*	
*@version 1.0 1-13-2016 4:00:00
*/

class Mail
{

	/**
	 * Send email 
	 * @param email address is going to be sent to $To
	 * @param sublect of the email $subject
	 * @param the messgae $Message
	 * @param who is the email from $FromMessage
	 */
	public static function emailToUser($To, $subject,$Message, $FromMessage)
	{
		 if(mail($To, $subject, $Message, "From:" . $FromMessage))
		 {
			return true; 
		 
		 }
		 else
	 	{
			return false; 
		 }
	
	}

}












?>
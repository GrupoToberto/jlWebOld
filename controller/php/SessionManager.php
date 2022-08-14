<?php
	namespace com\grupotoberto\controller\php      

	class SessionManager
	{
		private static $loginTime=3600; // 1 hour
		
		public static function setLoginTime($loginTime)
		{
			$self::$loginTime=$loginTime;
		}
		
		public static function resetLoginDate()
		{
			$cookieData=session_get_cookie_params(); 
			session_set_cookie_params($self::$loginTime,$cookieData["path"], 
			$cookieData["domain"], $cookieData["secure"], 
			$cookieData["httponly"]);
			
			session_start();
			
			$_SESSION['loginDate']=time();
		}
		
		public static function logout()
		{
			unset($_SESSION); 
			$cookieData=session_get_cookie_params(); 
			setcookie(session_name(), NULL, time()-999999, $cookieData["path"], 
			$cookieData["domain"], $cookieData["secure"], 
			$cookieData["httponly"]); 
		}
		
		private static function getLastAccess()
		{
			$lastAccess=0; 
			
			if(isset($_SESSION['loginDate']))
				$lastAccess=$_SESSION['loginDate']; 
				
			return $lastAccess; 
		}
		
		private static function getSesionStatus()
		{
			$status=false; 
			$lastAccess=$self::getLastAccess(); 
			$lastAccessLimit=$lastAccess+$self::$loginTime; //In seconds
			
			if($lastAccessLimit>time())
			{ 
				$status=true; 
				$_SESSION['loginDate']=time();
			}
			return $status;
		}
		
		public static function validateSession()
		{
			if(!$self::getSesionStatus())
			{ 
				$self::logout();
				return false;
			} 
			else
				return true;
		}
	}
	
?>

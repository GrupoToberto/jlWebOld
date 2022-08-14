<?php
	namespace com\grupotoberto\controller\php      

	class SessionManager
	{
		private static $loginTime=3600; // 1 hour
		
		public static function setLoginTime($loginTime)
		{
			$self::$loginTime=$loginTime;
		}
		
		public function resetLoginDate()
		{
			$cookieData=session_get_cookie_params(); 
			session_set_cookie_params($this->loginTime,$cookieData["path"], 
			$cookieData["domain"], $cookieData["secure"], 
			$cookieData["httponly"]);
			
			session_start();
			
			$_SESSION['loginDate']=time();
		}
		
		public function logout()
		{
			unset($_SESSION); 
			$cookieData=session_get_cookie_params(); 
			setcookie(session_name(), NULL, time()-999999, $cookieData["path"], 
			$cookieData["domain"], $cookieData["secure"], 
			$cookieData["httponly"]); 
		}
		
		private function getLastAccess()
		{
			$lastAccess=0; 
			
			if(isset($_SESSION['loginDate']))
				$lastAccess=$_SESSION['loginDate']; 
				
			return $lastAccess; 
		}
		
		private function getSesionStatus()
		{
			$status=false; 
			$lastAccess=$this->getLastAccess(); 
			$lastAccessLimit=$lastAccess+$this->loginTime; //In seconds
			
			if($lastAccessLimit>time())
			{ 
				$status=true; 
				$_SESSION['loginDate']=time();
			}
			return $status;
		}
		
		public function validateSession()
		{
			if(!$this->getSesionStatus())
			{ 
				$this->logout();
				return false;
			} 
			else
				return true;
		}
	}
	
?>

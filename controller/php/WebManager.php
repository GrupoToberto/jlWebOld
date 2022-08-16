<?php
        namespace com\grupotoberto\controller;  

	class WebManager
	{
		private static $dbMysqli;
		private static $docsFolder; //This folder must be protected
		private static $photosFolder;
		private static $strings="strings.xml";
		private static $errors="errors.xml";
        private static $resFolder;
		
		public static function closeDB_Mysqli()
		{
			self::$dbMysqli->close();
		}

		public static function getDB_Mysqli()
		{
			return self::$dbMysqli;
		}

		public static function getDocsFolder()
		{
			return self::$docsFolder;
		}

		public static function getError($name)
		{
			$filename=$_SERVER['DOCUMENT_ROOT'].self::$resFolder.self::$errors;
			
			if(\file_exists($filename))
			{
				$xml=\simplexml_load_file($filename);
				
				if(!$xml)
                    throw new \Exception('Error parsing XML document.');
				
				foreach($xml->error as $error)
				{
					if($error['name']==$name)
						return $error;
				}
			}
			else
                throw new \Exception('File not found.');
		}
		
		public static function getMaxFileSize()
		{
			return self::return_bytes(\ini_get('upload_max_filesize'));
		}
		
		public static function getPhotosFolder()
		{
			return self::$photosFolder;
		}
		
		public static function getPostMaxSize()
		{
			return self::return_bytes(ini_get('post_max_size'));
		}
		
		public static function getString($name)
		{
			$filename=$_SERVER['DOCUMENT_ROOT'].self::$resFolder.self::$strings;
			
			if(\file_exists($filename))
			{
				$xml=\simplexml_load_file($filename);
				
				if(!$xml)
					throw new \Exception('Error parsing XML document.');
				
				foreach($xml->string as $string)
				{
					if($string['name']==$name)
						return $string;
				}
			}
			else
				throw new \Exception('File not found.');
		}
		
		public static function return_bytes($val)
		{
			$val = \trim($val);
			$last = \strtolower($val[\strlen($val)-1]);
			switch($last) 
			{
				case 'g':
					$val *= 1024;
				case 'm':
					$val *= 1024;
				case 'k':
					$val *= 1024;
			}

			return $val;
		}
		
		public static function setDocsFolder($docsFolder){
			self::$docsFolder=$docsFolder;
		}

		public static function setPhotosFolder($photosFolder){
			self::$photosFolder=$photosFolder;
		}

		public static function setResFolder($resFolder){
			self::$resFolder=$resFolder;
		}

		public static function startDB_Mysqli($host, $username, $pwd, $db)
		{
			self::$dbMysqli = new \mysqli($host, $username, $pwd, $db);
			$dbMysqli=self::$dbMysqli;
			$dbMysqli->set_charset("utf8");
		}
		
		public static function verifyFilesSize($Files)
		{
			foreach($Files as $file)
			{
				if($file['size']>self::getMaxFileSize())
				{
					throw new \Exception('The size of a file is longer than maximum permitted size.');
				}
			}
		}
	
	}

?>

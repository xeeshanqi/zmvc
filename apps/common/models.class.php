<?php
namespace DSSpark;

require_once("config.php");
foreach (glob("apps/utility/*.class.php") as $filename){ require_once ($filename); }

	class Models{
		private $username;
		private $password;
		private $dsn;

		static $DB_USR;
	    static $DB_PWD;
	    static $DB_DSN;

		static function init() {
		  $whitelist = array('127.0.0.1', '::1');
	      if(\Services::ip_is_private($_SERVER['REMOTE_ADDR'])==false){
            	self::$DB_USR = "";
	    		self::$DB_PWD = "";
	    		self::$DB_DSN = "mysql:host=localhost;dbname=database";
	       } 
           if(\Services::ip_is_private($_SERVER['REMOTE_ADDR'])) {
	            self::$DB_USR = "root";
		        self::$DB_PWD = "";
		        self::$DB_DSN = "mysql:host=localhost;dbname=database";
           }
           if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
	            self::$DB_USR = "root";
		        self::$DB_PWD = "";
		        self::$DB_DSN = "mysql:host=localhost;dbname=database";
           }
		}
		
		public function __construct(){			
			$whitelist = array('127.0.0.1', '::1');
	      	if(\Services::ip_is_private($_SERVER['REMOTE_ADDR'])==false){
            	$this->username = "";
	    		$this->password = "";
	    		$this->dsn = "mysql:host=localhost;dbname=database";
	        } 
	        if(\Services::ip_is_private($_SERVER['REMOTE_ADDR'])) {
	            $this->username = "root";
		        $this->password = "";
		        $this->dsn = "mysql:host=localhost;dbname=database";
           }
           if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
	            $this->username = "root";
		        $this->password = "";
		        $this->dsn = "mysql:host=localhost;dbname=database";
           }
		}
		
		public function _DBCon(){
			$cn = new \PDO($this->dsn, $this->username, $this->password);
			$cn->setAttribute(PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			return $cn;
		}

		public static function _sDBCon(){
			$cn = new \PDO(self::$DB_DSN, self::$DB_USR, self::$DB_PWD);
			$cn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			return $cn;
		}
	}

	Models::init();
?>
<?php
require_once("modules.php");
require_once("router.class.php");

class Superb{
	public $_dir = '';

    function __construct($dir){ 
    	$this->_dir = $dir;
    }
	
   public function Viewer($page, $param=array() ) {
      $dir = $_SERVER["DOCUMENT_ROOT"];
      Template::view($dir ."/apps/views/" . $this->_dir . "/" . $page . ".html", $param);
   }
}
?>
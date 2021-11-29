<?php
namespace Spark;

/*** Run URI against our Map array to get class/method/id-page numbers */
class Router {
    private $_controller = '';
    private $_method = '';
    public  $page_number = '';
    public  $id_number = '';
    public  $_data = array();

    public function __construct(){ }

    public function __uriSetter(array $uri_map){
        $request_uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $script_name = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));
        $parts = array_diff_assoc($request_uri, $script_name);

        if (empty($parts)){
            $path = '/';
        }

        $path = implode('/', $parts);
        if (($position = strpos($path, '?')) !== FALSE){
            $path = substr($path, 0, $position);
        }
      
        $uri = $path;
        
        foreach ($uri_map as $rUri => $rRoute){
          if (preg_match("#^{$rUri}$#Ui", $uri, $uri_digits)){
              //if page number and ID number in uri then set it locally
              $this->page_number = (isset($uri_digits['page_number']) ? $uri_digits['page_number'] : null);
              $this->id_number = (isset($uri_digits['id_number']) ? $uri_digits['id_number'] : null);
              $this->_controller = $rRoute['controller'];
              $this->_method = $rRoute['method'];
              break;
          } else {
              $this->page_number = '';
              $this->id_number = '';
              $this->_controller = '404';
              $this->_method = '404';
          }
        }
    }

    public function check_user_agent ( $type = NULL ) {
          $user_agent = strtolower ( $_SERVER['HTTP_USER_AGENT'] );
          if ( $type == 'bot' ) {
                  // matches popular bots
                  if ( preg_match ( "/googlebot|adsbot|yahooseeker|yahoobot|msnbot|watchmouse|pingdom\.com|feedfetcher-google/", $user_agent ) ) {
                          return true;
                          // watchmouse|pingdom\.com are "uptime services"
                  }
          } else if ( $type == 'browser' ) {
                  // matches core browser types
                  if ( preg_match ( "/mozilla\/|opera\//", $user_agent ) ) {
                          return true;
                  }
          } else if ( $type == 'mobile' ) {
                  // matches popular mobile devices that have small screens and/or touch inputs
                  // mobile devices have regional trends; some of these will have varying popularity in Europe, Asia, and America
                  // detailed demographics are unknown, and South America, the Pacific Islands, and Africa trends might not be represented, here
                  if ( preg_match ( "/phone|iphone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent ) ) {
                          // these are the most common
                          return true;
                  } else if ( preg_match ( "/mobile|pda;|avantgo|eudoraweb|minimo|netfront|brew|teleca|lg;|lge |wap;| wap /", $user_agent ) ) {
                          // these are less common, and might not be worth checking
                          return true;
                  }
          }
          return false;
     }
  		
     public function dispatcher(){
       if(
          file_exists($_SERVER['DOCUMENT_ROOT'] .'/apps/controllers/'. $this->_controller . '.class' . '.php') || 
          file_exists(__DIR__."../../controllers/". $this->_controller . '.class' . '.php')
       ){   
          require_once (__DIR__."../../controllers/". $this->_controller . '.class' . '.php');  
          $controllerName = ucfirst($this->_controller);
          $controller_instance = new $controllerName();
       
          $method = $this->_method;
           
          if (method_exists($controller_instance, $this->_method)){
              $controller_instance->$method($this->id_number);
          } else {
              echo "NO METHOD";
          }
        } else {
              header('Location: err');
        }
     }
}
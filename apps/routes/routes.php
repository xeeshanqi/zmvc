<?php
$router = new Spark\Router();
$ismob = $router->check_user_agent('mobile');

if($ismob){
    $URIs= array( 
        //Home Controller
        '' => array('controller' => 'mob_home', 'method' => 'mshowHome','id_number' => '', 'page_number' => ''),
        '/' => array('controller' => 'mob_home', 'method' => 'mshowHome'),
        'home' => array('controller' => 'mob_home', 'method' => 'mshowHome'),       
    );
} else {
    $URIs= array(
        //Home Controller
        '' => array('controller' => 'home', 'method' => 'showHome','id_number' => '', 'page_number' => ''),
        '/' => array('controller' => 'home', 'method' => 'showHome'),
        'home' => array('controller' => 'home', 'method' => 'showHome'),
    );
}

$router->__uriSetter($URIs);
$router->dispatcher();
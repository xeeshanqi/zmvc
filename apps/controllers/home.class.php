<?php

class Home extends Superb{

    function __construct(){
      parent::__construct("general");
    } 
	
    function showHome() {
      $this->Viewer('index', [
              'colors' => ['red','blue','green']
          ]);
    }
}
?>
<?php
/* BASE MODULE */
require_once("controller.class.php");
require_once("models.class.php");
require_once ("router.class.php");

/* CONFIG */
require_once("config.php");

/* TEMPLATE */
require_once("Template.php");

/* MODELS */
foreach (glob("apps/models/*.model.php") as $filename){
    require_once ($filename);
}

/* UTILITY */
foreach (glob("apps/utility/*.class.php") as $filename){
    require_once ($filename);
}

/* CONTOLLER */
foreach (glob("apps/controllers/*.class.php") as $filename){
    require_once ($filename);
}

/* ROUTER */
foreach (glob("apps/routes/*.php") as $filename){
    require_once ($filename);
}

?>
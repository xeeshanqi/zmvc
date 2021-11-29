<?php session_start();
	
	ini_set("display_errors", 1);

	function errorHandler($errno, $errstr, $errfile, $errline) { 
	    switch ($errno) {
	        case E_NOTICE:
	        case E_USER_NOTICE:
	        case E_DEPRECATED:
	        case E_USER_DEPRECATED:
	        case E_STRICT:
	            error_log("STRICT error $errstr at $errfile:$errline \n");
	            break;
	 
	        case E_WARNING:
	        case E_USER_WARNING:
	            error_log("WARNING error $errstr at $errfile:$errline \n");
	            break;
	 
	        case E_ERROR:
	        case E_USER_ERROR:
	        case E_RECOVERABLE_ERROR:
	            error_log("FATAL error $errstr at $errfile:$errline \n");
	 
	        default:
	            error_log("Unknown error at $errfile:$errline \n");
	    }
	}

	set_error_handler("errorHandler"); //register_shutdown_function('errorHandler');


	function handleException($exception){
		echo $exception->getMessage(); // "An Exception has Occurred";
		error_log($exception->getMessage());
	}

	set_exception_handler('handleException');
?>
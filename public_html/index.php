<?php
 session_start();
 
 //disable default PHP error reporting and handle them by PHPTree
  ini_set('error_reporting', 0);
  ini_set('display_errors', 0);
  
 define('DIR', dirname(__DIR__));
 define('START_TIME_DEBUG', microtime(true) );

 require_once ( DIR . '/vendor/autoload.php');

//Handle all PHP Errors by PHPTree handler
  set_error_handler(array(new \PHPTree\Core\PHPTreeErrors(),"handleError"));
   
  //Handle all Exceptions by PHPTree handler
  set_exception_handler(array(new \PHPTree\Core\PHPTreeErrors(), 'handleException'));
  
 new \PHPTree\Core\PHPTreeCore();
?>
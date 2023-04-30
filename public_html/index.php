<?php
 session_start();
 
 define('DIR', dirname(__DIR__));
 define('START_TIME_DEBUG', microtime(true) );

 require_once ( DIR . '/vendor/autoload.php');

 new \PHPTree\Core\PHPTreeCore();
?>
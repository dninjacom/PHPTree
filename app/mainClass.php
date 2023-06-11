<?php
namespace app\mainClass;

use PHPTree\Core\PHPTreeRoute as Route;
use PHPTree\Core\PHPTreeRouteManager AS RouteManager;

/*
	MEM
*/

class mainClass {
	
	public function __construct(){
	
		//Add Dynamic routes
		$number = 1;
	
		//Route as closure execution;
		RouteManager::add("/closure/route/{user}/{email}/{id}", 
						 array( 'id' => '[0-9-a-z-A-Z-_!]+', 'email' => '[0-9-a-z-A-Z]+', 'user' => '[0-9-a-z-A-Z]+' ), 
						 function( $params ) use ($number) : int{
							
							echo "closure is working , test number : $number";
							echo "Params : <pre>";
							print_r($params);
						
						 }, Route::GET) ;
			
		//Route by class method
		RouteManager::add("/class/method/{user}/{email}/{id}", 
						  array( 'id' => '[0-9-a-z-A-Z-_!]+', 'email' => '[0-9-a-z-A-Z]+', 'user' => '[0-9-a-z-A-Z]+' ), 
						  array($this,'useThisMethod') , Route::GET) ;
		
		//Fetch and execute the available route if Auto route is false in .env
		if ( $route = RouteManager::fetch() ) {
			
			RouteManager::load($route,array());
				
		}else
		//Go 404
		{
			http_response_code(404);
		}		
	
		
	}
	
	public function useThisMethod($params) : void {
	
		echo "Class method route is working!";
	}

}


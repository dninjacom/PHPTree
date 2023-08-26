<?php
namespace app;

use PHPTree\Core\PHPTreeRoute as Route;
use PHPTree\Core\PHPTreeSecure as Secure;
use PHPTree\Core\PHPTreeLogs AS Logs;

class initialize {
	
	
	/*
	
		Initialize All script routes 
		you can enable or disable based on user verification .
		
		Below all available routes Examples.	
	
	*/
	public function __construct(){
	
		//Basic route ( namespace+classname@method )
		Route::get("/")->setMethod("app\\admin\\views@dashboard");		
	
		//Route with dynamic params 
		Route::get("/profile/{id}")
				->setMethod("app\\admin\\views@user_profile")
				->setGroup("user_profile")
				->where(['id' => '[0-9]+'])
				->enabled(true); 
		
		//Closure route		
		$param = "Hello";
		
	    Route::get("/closure")	  
			->setMethod( function() use ( $param ) {
				
				echo "$param . You've called a closure route . ";
				
			} );
				
				
		//Redirect route
		Route::get("/google")->redirect("http://www.google.com",302);
		
		//We've set this route to use it inside Admin dashboard as example
		Route::get("/multiplication/{number}")->setMethod( array(initialize::class,'multiplication',true) )
											  ->where(['number' => '[0-9]+']);			
			
		//Post request route, using static method array( class , method , static true or false )
		Route::post("/login_api")
				->setMethod( array(initialize::class,'verify_login',true)  )
				->enabled(true);	
			
				
		//Fetch route 
		if ( $route = Route::fetch() ) {
			
			//Route found , load it.
			Route::load($route);
			
		}else
		//Go 404
		{
			http_response_code(404);
		}		
		
	}
	
	public static function multiplication( $params ) : int {
		return ( $params['number'] ? $params['number'] : 0 ) * 10;
	}
	
	public static function verify_login(){
		
		echo "Login verified";
		
	}

}


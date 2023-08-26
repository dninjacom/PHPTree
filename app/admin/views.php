<?php
namespace app\admin;

use PHPTree\Core\PHPTreeRoute as Route;
use PHPTree\Core\PHPTreeSecure as Secure;


class views {
	
	
	public function __construct(){
		
		//Class will init 1 time per request
		//Add your code here ... 
		
	}
	
	public function dashboard(){
		
		$number = 8;
		
		//User route to call another method from another classes 
		$result =  Route::load( Route::fetch("/multiplication/$number") ) ;
		
		echo "Welcome to the example dashboard :) <br > Results of Multiplication for ($number) is : $result";
		
		
		//Post encrypted data 
		$post_token = Secure::generateToken( ['name'=>'Jack' , 'gender' => 'male'] );
		
		
		//Bring safe data 
		$post = Secure::safePost(); 
		
		if (  isset($post['token']) and
			  $data = Secure::validateToken( $post['token'] ) )
		{
			
			if ( $data->isValid() )
			{
				echo "<br /><p />Token verified with Data : ". json_encode($data->payload);
			}else{
				echo "<br /><p />invalid token!";
			}
			
			
		}else{
			echo "<br /><p />Test Encrypted form Data <form method='post'><input type='submit' /><input type=hidden name=token value='$post_token'><form>";
		}
		
	}
	
	public function user_profile( $params ){
		
		echo " User profile request for ID : " . $params['id'];
	}
	

	
}
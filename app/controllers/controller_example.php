<?php

use PHPTree\Core\PHPTreeRoute as Route;
use PHPTree\DB\PHPTreePDO as DB;

class example  {
	
	
	var $db = null; //Database connection
	
	public function __construct()
	{
		
		//Log Database errors
		DB::$debug_file = DIR . "/var/logs/sql.text";
		
		//Create new Database PDO instance
		$this->db =	new DB( array('host' => 'mysql:host=localhost;' , 'username' => 'root' , 'password' => 'root') );
		//Or make instance with selected database
		//$this->db =	new DB( array('host' => 'mysql:host=localhost;dbname=example_phptree' , 'username' => 'root' , 'password' => 'root') );
	}
	
	/*
		Home page 
	*/
	#[Route('/')]
	public function Home_example(){
		echo "Hellow World";
	}
	
	/*
		Database connection check
	*/
	#[Route('/database')]
	public function database_example(){
		
	
		if ( !$this->db->is_connected )
		{
			echo "<br />Database is not connected make sure you set username and password correctly";
			die();
		}
		
		//Create database
		if ( $this->db->query("CREATE DATABASE example_phptree") )
		{
			echo "<br />Database created.";
		}
	
		//User our example Database
		$this->db->query("use example_phptree");
		
		
		//Create example table
		$query = "CREATE TABLE Persons (
										Personid int NOT NULL AUTO_INCREMENT,
										LastName varchar(255) NOT NULL,
										FirstName varchar(255),
										Age int,
										PRIMARY KEY (Personid)
									);";
		
		$this->db->query($query);
		
		//Insert demo Data
		$data   = array();
		$data[] = array(":LastName" , "Fouani",\PDO::PARAM_STR);
		$data[] = array(":FirstName" , "Jack",\PDO::PARAM_STR);
		$data[] = array(":Age" , 38,\PDO::PARAM_INT);
			
		$id = $this->db->insert("INSERT INTO Persons (`LastName`,`FirstName`,`Age`) VALUES (:LastName,:FirstName,:Age) ",$data);
		
		echo "<br/>New record added with ID : ". $id ;
		
		//Update data
		$data   = array();
		$data[] = array(":LastName" , "Fouani",\PDO::PARAM_STR);
		$data[] = array(":FirstName" , "Jack",\PDO::PARAM_STR);
			
		$this->db->update("UPDATE  Persons  SET `LastName` = :LastName WHERE `FirstName` = :FirstName  ",$data);
		
		//Count number of records 
		echo "<br />Number of records inside  'Persons' table : " . $this->db->count("SELECT * FROM Persons");
		
		//Select 1 record
		echo "<br/>select one : ". json_encode( $this->db->selectOne("SELECT * FROM Persons") );
		
		//Select all 
		echo "<br/>select All : ". json_encode( $this->db->select("SELECT * FROM Persons") );
		
		//Delete record
		//$this->db->delete("DELETE FROM Persons WHERE `LastName` = :LastName ", array( array(":LastName" , "Fouani",\PDO::PARAM_STR)  ) );
			
	}
	
	/*
		404 Page not found route
	*/
	#[Route('/404')]
	public function page_not_found_example(){
		echo "404 page not found!!";
	}
	
	/*
		example of route accepting only post request
	*/
	#[Route('/post/data',array(),Route::POST)]
	public function post_data_example( $api ){
		
		echo "Data posted";
	}
	
	/*
		example with a route with dynamic params
	*/
	#[Route('/hello/{user}/{id}', array( 'user' => '[a-z-A-Z]+' ,'id' => '[0-9]+') )]
	public function example_dynamic_route_example( $params ){
		
		$name = $params['user'];
		$id = $params['id'];
	
		echo "Hello $name your ID is ($id) ";
	}
	
}
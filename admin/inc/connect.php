<?php 

$dsn = "mysql:host=localhost;dbname=mblog";
$username = "root";
$password = "";

try{
     
     //connecting 
	$con = new PDO($dsn,$username,$password);
	// setting error attribute
	$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	
	//echo "DATABASE CONNECTED";
}

catch(exception $e){

  // Here if any error is done while connecting it will be catched and a message will be displayed
 echo "ERROR !! : " . $e->getMessage();
}




?>
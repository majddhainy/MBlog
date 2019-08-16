<?php


function get_categories()
{
	include 'connect.php';
	$sql = "SELECT name FROM categories"; // always result is as form of array where index is col u need 
	try {

	$results = $con->query($sql);
	return $results;
}

catch(exception $e) {

	echo "ERROR : " . $e.getMessage();
	return Array(); // to except error while looping on them in another file
}

}

function insert_post($datetime,$title,$author,$body,$category,$excerpt,$tags,$image_name) {
     		include 'connect.php';
     		$fields = Array($datetime,$title,$author,$body,$category,$excerpt,$tags,$image_name);
     		// never insert them directly to avoid sql injection !
     		$sql = "INSERT INTO posts (datetime,title,author,body,category,excerpt,tags,image_name) VALUES (?,?,?,?,?,?,?,?) ";

     			try {

     				$result = $con->prepare($sql);
     				for ($i=1; $i<=8 ; $i++) { 
     					$result->bindValue($i,$fields[$i-1],PDO::PARAM_STR);
     				}
                      return $result->execute();

     			}catch(exception $e){
     				echo "Error ! " . $e->getMessage();
     			}

}

function get_posts()
{
	include 'connect.php';
	$sql = "SELECT * FROM posts"; // always result is as form of array where index is col u need 
	try {

	$results = $con->query($sql);
	return $results;
}

catch(exception $e) {

	echo "ERROR : " . $e.getMessage();
	return Array(); // to except error while looping on them in another file
}

}

?>
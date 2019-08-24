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

function get_posts($id = "")
{
	// use optional parameter to never duplicate the function 
	include 'connect.php';
	if (empty($id)) {
		// to sort them according to date ... 
	   $sql = "SELECT * FROM posts ORDER BY datetime DESC";
	}
	else
	$sql = "SELECT * FROM posts WHERE id=?"; // always result is as form of array where index is col u need 
	try {
		    if (empty($id)) {
		    	$results = $con->query($sql);
			return $results;
		     }
		    else {
				$result = $con->prepare($sql);
				$result->bindValue(1,$id,PDO::PARAM_INT);
				$result->execute();
				// here we dont want to return true/false as delete .. 
				// we need to return data  - PDO::FETCH_ASSOC to return indexed array of columns 
				return $result->fetch(PDO::FETCH_ASSOC);
			}
    }

catch(exception $e) {

	echo "ERROR : " . $e.getMessage();
	return Array(); // to except error while looping on them in another file
}

}

function delete_row($table,$id) {
    include 'connect.php';
    $sql = "DELETE FROM $table WHERE id = ? " ;
    try {
        	$result = $con->prepare($sql);
        	$result->bindValue(1,$id,PDO::PARAM_INT);
        	return $result->execute();
    }catch(exception $e){

    	echo "Error : " . $e->getMessage();
    }




}


function redirect($location){
	// go to posts page again 
		     	header("Location: " . $location);
		     	// never execute anything below u 
		     	exit;  
}


function update_post($title,$body,$category,$excerpt,$tags,$image_name = "",$id) {
          //image is optional param bcz maybe the user will not edit the image 
	include 'connect.php';
	$fields = Array($title,$body,$category,$excerpt,$tags,$image_name,$id);
	print_r($fields);
	$sql = "";
	if (!empty($image_name)) {
		$sql = "UPDATE posts SET  title = ?, body = ?,category = ?,excerpt = ?,tags = ?,image_name = ? WHERE ID = ?" ;
	}
	else {
		$sql = "UPDATE posts SET  title = ?, body = ?,category = ?,excerpt = ?,tags = ? WHERE ID = ?" ;
	}

try {
	$query = $con->prepare($sql);
	for ($i=1; $i < 7 ; $i++) { 
	      if ($i <= 5) {
	      	// we need to insert 1st 6 values in call cases
	      	$query->bindValue($i,$fields[$i-1],PDO::PARAM_STR);
	      }
	      else {
		      if (!empty($image_name)) {
		      	//insert img name at #7
		      	$query->bindValue(6,$fields[5],PDO::PARAM_STR);
		      	// & ID at #8
		      	$query->bindValue(7,$fields[6],PDO::PARAM_INT);
		      }
		      else {
		      	// insert id at #7 only bcz there id no img
		      	$query->bindValue(6,$fields[6],PDO::PARAM_INT);
		      }

	      }

	}

 			return $query->execute();
}

catch(exception $e){
	return "Error : " . $e->getMessage();
	return false ;
}




}

?>
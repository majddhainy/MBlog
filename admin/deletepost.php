<?php 
include 'inc/functions.php';


if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (isset($_POST['deletepost'])) {
			
			//  HERE U MUST confrim the user is deleting his comment !!!!!!
           

             // filtering ID confirming its number removing any thing not INT 
             $id = filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
		     if (delete_row('posts',$id)) {
		     	redirect('posts.php');

		     } 


		     else {
		     	echo "Not Deleted";
		     }



	}

}


?>
<?php
include 'inc/header.php'; 
include 'inc/navbar.php';
include 'inc/connect.php'; 
include 'inc/functions.php'; 
?> 

<?php 
// do we have a POST Request ? 
if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
    // exactly pressed on addpost button in that form (maybe we have 2 forms)
	if (isset($_POST['addpost'])) {
		                                              
		// Server side validation Filtering user Input 
		$title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING);
		$body = filter_input(INPUT_POST,'body',FILTER_SANITIZE_STRING);
		$category = filter_input(INPUT_POST,'category',FILTER_SANITIZE_STRING);
		$excerpt = filter_input(INPUT_POST,'excerpt',FILTER_SANITIZE_STRING);
		$tags = filter_input(INPUT_POST,'tags',FILTER_SANITIZE_STRING);
		$author = "majd";
		// set time as time in your country
		date_default_timezone_set("Asia/Beirut");
		$datetime = date('M-D-Y h:m',time());
		// Image validation ... 
	    $image = $_FILES['image'];
	    $img_name = $image['name'];
	    // take last extension after last DOT (.) to catch x.jpg.php 
	    $img_ext =  strtolower(substr( $img_name, strrpos( $img_name, '.' ) + 1)); 
	    $img_type = $image['type'];
	    $img_size = $image['size'];
	    $img_tmp = $image['tmp_name'];
	    // checking type and extension carefully ... 
	    // extensions size and MEME type and getimagesize to make sure its image
	    if (!empty($img_name)) {
	    	# code...
	    
	    if( ( $img_ext == 'jpg' || $img_ext == 'jpeg' || $img_ext == 'png' ) && 
        ( $img_size < 100000 ) && 
        ( $img_type == 'image/jpeg' || $img_type == 'image/png' ) && getimagesize($img_tmp) ) 
        	{
         	 $new_image_name = md5( "sec" . rand(0,1000) . uniqid() . $img_name ) . '.' . $img_ext; 
         	 
         	 // OK IT'S AN IMAGE AND DATA IS FILTERED LET'S INSERT IT !

         	 if (insert_post($datetime,$title,$author,$body,$category,$excerpt,$tags,$new_image_name)) {

         	 	if (! empty($img_name)) {
         	 		$new_path = "upload/posts/" . $new_image_name ;
         	 		move_uploaded_file($img_tmp ,$new_path);
         	 	}
         	 	# success 
         	 //	echo "Post Added Successfully";
         	 	 header("Location:post.php");
     		     exit;
         	 }

         	else {
                   //fail 
         		echo "Error" ;
         		 header("Location:post.php");
     		      exit;
         	}






        }
        else {

        }
    }
	


	}

  
}


?>

<div class="container-fluid">
	<div class="row">
		<!-- 2 coloumns from 12 to this section from small devices and up -->
      <div class="col-sm-2">
      <?php include 'inc/sidebar.php'; ?>
      </div>

<!-- or col-sm only means rest of columns is for this section ! -->
<div class="col-sm-10">	
<div class="post">
<h3> Add New Post </h3>
<!-- Client Side Validation  -->
<div class="alert-danger" role="alert">
	<ul>
<li class="error title-error"><p class="err"> Title must be between 50 and 200 characters </p></li>
<li class="error body-error"><p class="err"> Body must be between 200 and 10,000 characters </p></li>
<li class="error excerpt-error"><p class="err">  Excerpt must be between 50 and 200 characters </p></li>
<!-- <p class="error title-error"> </p> -->
	</ul>
</div>
<form action="post.php" method="post" enctype="multipart/form-data">
	<div class="form-group">	
       <input class="form-control" type="text" name="title" placeholder="Title" required autocomplete="off">
	</div>

	<div class="form-group">	
<textarea  required   placeholder="Body" name="body" rows="6" autocomplete="off" class="form-control"></textarea>
	</div>

	<div class=form-group>	
		<select class="form-control" name="category">
           <?php 
                 // Grabbing all categories from DB 
               foreach (get_categories() as $result) {
               		//echo " <option> ok </option>";
               	    echo "<option>";
               	    echo $result['name'];
               	    echo "</option>";
               }

           ?>


		</select>

	</div>
	<div class="form-group">	
       <input class="form-control" type="text" name="excerpt" placeholder="Excerpt (Optional)"  autocomplete="off">
	</div>
	<div class="form-group">	
       <input class="form-control" type="text" name="tags" placeholder="Tags"  autocomplete="off">
	</div>
	<div class="form-group">	
       <input class="form-control" type="file" name="image">
	</div>
<input value="Add Post" type="submit" name="addpost" class="btn btn-primary" style="float: right;margin-right: 30px">
</form>


</div>
</div>

</div>
</div>
<?php
include 'inc/footer.php'; 
?>


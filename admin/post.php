<?php
include 'inc/header.php';
include 'inc/navbar.php';
include 'inc/connect.php';
include 'inc/functions.php';
?> 

       
    
<?php
$title    = "";
$body     = "";
$category = "";
$excerpt  = "";
$tags     = "";
// do we have a POST Request ? 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // exactly pressed on addpost button in that form (maybe we have 2 forms)
    if (isset($_POST['addpost']) || isset($_POST['editpost'])) {
        
        // Server side validation Filtering user Input BOTH ON EDIT AND INSERT
        if (isset($_POST['editpost'])) {
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        }
        $title    = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $body     = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_STRING);
        $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
        $excerpt  = filter_input(INPUT_POST, 'excerpt', FILTER_SANITIZE_STRING);
        $tags     = filter_input(INPUT_POST, 'tags', FILTER_SANITIZE_STRING);
        $author   = "majd";
        // set time as time in your country
        date_default_timezone_set("Asia/Beirut");
        $datetime = date('M-D-Y h:m', time());
        // Image validation ... 
        $image    = $_FILES['image'];
        $img_name = $image['name'];
        // take last extension after last DOT (.) to catch x.jpg.php 
        $img_ext  = strtolower(substr($img_name, strrpos($img_name, '.') + 1));
        $img_type = $image['type'];
        $img_size = $image['size'];
        $img_tmp  = $image['tmp_name'];
        // checking type and extension carefully ... 
        // extensions size and MEME type and getimagesize to make sure its image
        //if no image uploaded or if image is not a real image the name will stay "" !
        $new_image_name = "";
        if (!empty($img_name)) {
             // check type carefully and size less than 1mb 
            if (($img_ext == 'jpg' || $img_ext == 'jpeg' || $img_ext == 'png') && ($img_size < 1000000) && ($img_type == 'image/jpeg' || $img_type == 'image/png') && getimagesize($img_tmp)) {
            	//changing name from empty to the new one 
                $new_image_name = md5("sec" . rand(0, 1000) . uniqid() . $img_name) . '.' . $img_ext;

            }

        }

        
        
        
        // OK IT'S AN IMAGE AND DATA IS FILTERED LET'S INSERT IT !
        
        // if admin is adding a new post and not editing !
        if (isset($_POST['addpost'])) {
            
            if (insert_post($datetime, $title, $author, $body, $category, $excerpt, $tags, $new_image_name)) {
                
                // check wether vaildate returns true !
                if (!empty($new_image_name)) {
                    $new_path = "upload/posts/" . $new_image_name;
                    move_uploaded_file($img_tmp, $new_path);
                }
                # success 
                //    echo "Post Added Successfully";
                // controlling session if session is not opened start it !
                if (!session_id()) {
                	session_start();
                }
                $_SESSION['success'] = "Post has been added Successfully !";
                

                redirect('posts.php');
            }
            
            else {
                //fail 
                // echo "Error";
                redirect('posts.php');
            }

          // if admin is editing an post   
        } elseif (isset($_POST['editpost'])) {
            //  HERE U MUST confrim the user is editing his post !!!!!!
			            if (update_post($title,$body,$category,$excerpt,$tags,$new_image_name,$id)) {
					            		if (!empty($new_image_name)) {
							                    $new_path = "upload/posts/" . $new_image_name;
							                    move_uploaded_file($img_tmp, $new_path);
						                }
						                # success 
						                //    echo "Post Updated Successfully";
						                // controlling session if session is not opened start it !
						        if (!session_id()) {
                				session_start();
                			     }
                				$_SESSION['success'] = "Post has been updated Successfully !";
						                redirect('posts.php');
                			
                						
						    }


						            
						            else {
						                //fail 
						                echo "Error";
						                redirect('posts.php');



						            }
				            
				            
            
            
            }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    }
    
    
}

elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    if (!empty($_GET['id'])) {
        
        $id       = filter_input(INPUT_GET, 'id');
        $post     = get_posts($id);
        $title    = $post['title'];
        $body     = $post['body'];
        $category = $post['category'];
        $excerpt  = $post['title'];
        $tags     = $post['tags'];
    }
    
    
}


?>

<div class="container-fluid">
    <div class="row">
        <!-- 2 coloumns from 12 to this section from small devices and up -->
      <div class="col-sm-2">
      <?php
include 'inc/sidebar.php';
?>
     </div>

<!-- or col-sm only means rest of columns is for this section ! -->
<div class="col-sm-10">    
<div class="post">
	 <?php

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
?>
<h3> Edit Post </h3>
<?php } else { ?> 
	<h3> Add New Post </h3>
<?php } ?>
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
        <input type="hidden" name="id" value="<?php
echo $id;
?>">
       <input value="<?php
echo $title;
?>"class="form-control" type="text" name="title" placeholder="Title" required autocomplete="off">
    </div>

    <div class="form-group">    
<textarea required   placeholder="Body" name="body" rows="6" autocomplete="off" class="form-control"><?php
echo $body;
?></textarea>
    </div>

    <div class=form-group>    
        <select class="form-control" name="category">
           <?php
// Grabbing all categories from DB 
foreach (get_categories() as $result) {
    //echo " <option> ok </option>";
    if ($result['name'] == $category) {
        echo "<option selected=\"selected\">";
    } else {
        echo "<option>";
    }
    echo $result['name'];
    echo "</option>";
}

?>


        </select>

    </div>
    <div class="form-group">    
       <input  value="<?php
echo $excerpt;
?>"class="form-control" type="text" name="excerpt" placeholder="Excerpt (Optional)"  autocomplete="off">
    </div>
    <div class="form-group">    
       <input value="<?php
echo $tags;
?> " class="form-control" type="text" name="tags" placeholder="Tags"  autocomplete="off">
    </div>
    <?php
if (!empty($post['image_name'])) {
    
?>
   <label>Post Image :</label>
    <img width="100" src="upload/posts/<?php
    echo $post['image_name'];
?>">
<?php
} else {
?>
   <label>No Image</label>
<?php
}
?>
   <div class="form-group">    
       <input class="form-control" type="file" name="image">
    </div>
    <?php

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
?>
       <input value="Update Post" type="submit" name="editpost" class="btn btn-primary" style="float: right;margin-right: 30px">
<?php
} else {
?>
   <input value="Add Post" type="submit" name="addpost" class="btn btn-primary" style="float: right;margin-right: 30px">
<?php
}
?>
</form>


</div>
</div>

</div>
</div>
<?php
include 'inc/footer.php';
?>
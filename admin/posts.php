<?php
include 'inc/header.php'; 
include 'inc/navbar.php';
include 'inc/connect.php'; 
include 'inc/functions.php'; 
?> 

<div class="container-fluid">
	<div class="row">
		<!-- 2 coloumns from 12 to this section from small devices and up -->
      <div class="col-sm-2">
      <?php include 'inc/sidebar.php'; ?>
      </div>

<!-- or col-sm only means rest of columns is for this section ! -->
<div class="col-sm-10">	
	<div class="posts">
<h4> Posts </h4>
<!-- make table comf. with devices  -->
<div class="table-responsive">
	<table class="table table-hover table-striped  table-dark">
	  <thead>
	    <tr>
	      <th scope="col">#</th>
	      <th scope="col">Datetime</th>
	      <th scope="col">Title</th>
	      <th scope="col">Body</th>
	      <th scope="col">Category</th>
	      <th scope="col">Image</th>
	      <th scope="col">Author</th>
	      <th scope="col">Actions</th>
	    </tr>
	  </thead>
	  <tbody>
           <?php 
	  	   $i = 1;
           foreach (get_posts() as $post) { ?> 
           		<tr>
                <th scope="row"><?php echo $i ?> </th>
               <td><?php echo $post['datetime']; ?></td>
					      <td class="title">
					      	<?php 
					      	//printing only small part not all of it !
					      	if(strlen($post['title']) > 100 ){
					      		echo substr($post['title'], 0,100) . '...';
					      	}else {
					      		echo $post['title'];
					      	}
					      	?>
					      	
					      </td>
					      <td>
					      	<?php 
					      	if(strlen($post['body']) > 250 ){
					      		echo substr($post['body'], 0,250) . '...';
					      	}else {
					      		echo $post['body'];
					      	}
					      	?>
					      	
					      </td>
					      <td><?php echo $post['category']; ?></td>
                           
					      <td>
			               <td class="table_class">
			                 	<?php if(! empty($post['image_name'])) { ?>
								 <img class="" alt="Post Banner" width="150" height="150"  style="margin: 2px;" src="upload/posts/<?php echo $post['image_name']; ?>">	
							 <?php  } else {
								     echo "No Image";
								      }
								  ?></td>
               <td class="table_class"><?php echo  $post['author'];?></td>
              <td class="action-links">
					      	<a class="btn btn-primary btn-sm" href="post.php?id=<?php echo $post['ID'] ?>">Edit</a>
					      	<form onsubmit="return confirm('Are you sure you want to delete this post ? ') " action="deletepost.php" method="post">
					      	<input type="hidden" name="id" value=<?php echo $post['ID'];?>>
					      	<input type="submit" name="deletepost" class="btn btn-danger btn-sm" value="Delete" /> 
					      </form>
			   </td>
               </tr>
           		


           		<?php $i++;

                 } ?>

	  </tbody>
	</table>
	<a class="btn btn-info" style="float: right;"href="post.php">Add New Post</a>
</div>

</div>
</div>

</div>
</div>
<?php
include 'inc/footer.php'; 
?>


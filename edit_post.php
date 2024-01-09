<?php
require_once("includes/header.php");



?>

<style>
    
.tags-input-wrapper{
  background: transparent;
  padding: 10px 0px;
  border-radius: 4px;
  /* max-width: 400px; */
  border: 1px solid #ccc
}
.tags-input-wrapper input{
  border: none;
  background: transparent;
  outline: none;
  width: 140px;
  margin-left: 8px;
  hidden:false;
}
.tags-input-wrapper .tag{
  display: inline-block;
  background-color: #00695C;
  color: white;
  border-radius: 40px;
  padding: 0px 3px 0px 7px;
  margin-right: 5px;
  margin-bottom:5px;
  box-shadow: 0 5px 15px -2px #00695C
}
.tags-input-wrapper .tag a {
  margin: 0 7px 3px;
  display: inline-block;
  cursor: pointer;
}
</style>


<?php
 // select category 
 $query = "SELECT * FROM categories ORDER BY id DESC";
 $categories = $db->select($query);



if ($_GET['id']) {

$id = base64_decode($_GET['id']);

$query = "SELECT * FROM posts WHERE id = $id";
$posts = $db->select($query);
}

 if ($_SERVER['REQUEST_METHOD'] == "POST") {

  if (!Session::get('login')) {

    echo "<script>window.open('login.php')</script>";
  } else {
 


    $title = $_POST['title'];
    $category = $_POST['category'];
    $details = $_POST['details'];
    $status = $_POST['status'];
    $tags = $_POST['tags'];
    $user_id = Session::get('userId');
    $slug = $hp->slug($title);
    $user_name=Session::get('name');

    // phpto upload 

    $filename = $_FILES['image']['name'];
    $tempname = $_FILES['image']['tmp_name'];
    $folder =  $filename;
    move_uploaded_file($tempname,'./admin/uploads/'. $folder);


    $query = "UPDATE posts SET title = '$title',details='$details',category_id='$category',
    user_id='$user_id',status = '$status',slug='$slug',tags='$tags',image='$folder', updated_at = now() ,added_by='USR' WHERE id = '$id'";
   $update = $db->update($query);
   

    if ($update) {
        echo "<div class='alert alert-success' role='alert'>
          Post Updated Successfully
        </div>";

        ?>
        <script>
            setTimeout(function(){
                window.location.href = "user_posts.php?user=<?php echo $user_id ?>&&name=<?php echo $user_name ?>";
            },2000);
        </script>
   <?php } else{
        echo "<div class='alert alert-danger' role='alert'>
          Post Updated Fail!
        </div>";
   }
     
 }

}

 ?>






    
    <div id="Post-page" class="container">
    	<div class="bg">
	       	
    		<div class="row">  	
	    		<div class="col-sm-8">
	    			<div class="contact-form">
	    				<h2 class="title text-center">Edit Post</h2>
              <?php 
                            if ($posts) {
                                while($result = $posts->fetch_assoc() ){ 
                                        
                                    ?>
				    	<form  method="post" enctype="multipart/form-data"  id="main-post-form" class="post-form " name="post-form" >
				            <div class="form-group col-md-6">
				                <input type="text" name="title" class="form-control"  value="<?php echo $result['title'] ?>"  placeholder="Enter post title" required>

				            </div>
				            <div class="form-group col-md-6">

                    <select name="category" id="category" class="form-control ">
                       <option value=""> Select Category</option>
                        <?php 
                        while ($category = $categories->fetch_assoc()) { ?>
                        <option <?php echo $category['id'] == $result['category_id']? 'selected':'' ?> value="<?php echo $category['id'] ?>"> <?php echo $category['name'] ?></option>
                        <?php }
                        ?>
        
             
                 </select>
                  
				            </div>

				            <div class="form-group col-md-6">
                    <select name="status" id="status" class="form-control ">
                            <option <?php echo  $result['status'] ==  '1' ? 'selected':'' ?> value="1"> Active</option>
                            <option <?php echo  $result['status'] == '0' ? 'selected':'' ?> value="0"> InActive</option>
                            </select>
                       </div>
				            <div class="form-group col-md-12">
                     <?php 
                       $text = str_replace("," ,"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $result['tags']);
                 
                        echo "current tags : ". $text;
                        ?> 
            
                     <input type="text" id="tag-input1" class="form-control " name="tags" value="<?php echo  $result['tags'] ;?>"
                           data-role="tagsinput"  >
            				</div>


				            <div class="form-group col-md-12">
                    <textarea name="details" id="details" class="form-control  ckeditor" cols="30" placeholder="Enter Post Details " rows="10">
                      <?php echo $result['details'] ?>
                  </textarea>
				            </div>                        
				            <div class="form-group col-md-12">
                    <input class="form-control" name="image" type="file" required>

				            </div>                        
				            <!-- <div class="form-group col-md-12"> -->
                        <button class="btn btn-primary" name="update_post" type="submit"><i class="bi bi-check-circle-fill me-2"></i>Update Post</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="#"><i class="bi bi-x-circle-fill me-2"></i>Cancel</a>

				            <!-- </div> -->
				        </form>
                <?php } } ?>

	    			</div>
	    		</div>
	    	  			
	    	</div>  
    	</div>	
    </div><!--/#post-page-->






<?php
    include_once('includes/footer.php');
  
  ?>
<?php
  include_once('./includes/header.php');

?>
<?php
  include_once('./includes/nav.php');

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


 if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (!Session::get('admin_login')) {

        echo "<script>window.open('login.php')</script>";
      } else {
     


    $title = $_POST['title'];
    $category = $_POST['category'];
    $details = $_POST['details'];
    $status = $_POST['status'];
    $tags = $_POST['tags'];
    $user_id = Session::get('admin_id');
    $slug = $hp->slug($title);

    // phpto upload 

    $filename = $_FILES['image']['name'];
    $tempname = $_FILES['image']['tmp_name'];
    $folder =  $filename;
    move_uploaded_file($tempname,'uploads/'. $folder);


    $query = "INSERT INTO posts(title,category_id,user_id,status,details,image,slug,tags,added_by) VALUES ('$title','$category','$user_id','$status','$details','$folder','$slug','$tags','ADM')";
    $insert = $db->insert($query);

    if ($insert) {
        echo "<div class='alert alert-success' role='alert'>
          Post Insert Successfully
        </div>";

        ?>
        <script>
            setTimeout(function(){
                window.location.href = "posts_list.php";
            },2000);
        </script>
   <?php } else{
        echo "<div class='alert alert-danger' role='alert'>
          Post Insert Fail!
        </div>";
   }
     
 }

}

 ?>





<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="bi bi-ui-checks"></i> Posts</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
          <li class="breadcrumb-item">Home</li>
          <li class="breadcrumb-item"><a href="#">Add Post</a></li>
        </ul>
      </div>
      <div class="row">
      
        <div class="col-md-8 offset-2">
          <div class="tile">
            <h3 class="tile-title">Add Post</h3>

       

              <form class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="mb-3 row">
                  <label class="form-label col-md-3">Title</label>
                  <div class="col-md-9">
                    <input class="form-control col-md-9" type="text" name="title" placeholder="Enter post title" required>
                  </div>
                </div>

             
                <div class="mb-3 row">
                  <label class="form-label col-md-3">Category</label>
                  <div class="col-md-9">
                  <select name="category" id="category" class="form-control col-md-9">
                  <option value=""> Select Category</option>
                   <?php 
                    while ($category = $categories->fetch_assoc()) { ?>
                        <option value="<?php echo $category['id'] ?>"> <?php echo $category['name'] ?></option>
                    <?php }
                    ?>
             
                </select>
                </div>
                </div>

                        <div class="mb-3 row">
                          <label class="col-md-3 form-label" for="status">Status</label>
                          <div class="col-md-9">
                            <select name="status" id="status" class="form-control col-md-9">
                                <option value="1"> Active</option>
                                <option value="0"> InActive</option>
                            </select>
                          </div>
                        </div>
                <div class="mb-3 row">
                  <label class="form-label col-md-3">Tags</label>
                  <div class="col-md-9">

                  <input type="text" id="tag-input1" class="form-control col-md-9" name="tags" value="" placeholder="Enter post tags"required data-role="tagsinput">

                  </div>
                </div>
              
                <div class="mb-3 row">
                  <label class="form-label col-md-3">Post Details</label>
                  <div class="col-md-9">
                  <textarea name="details" id="details" class="form-control col-md-9 ckeditor" cols="30" placeholder="Enter Post Details " rows="10"></textarea>

                  </div>
                </div>
           
                <div class="mb-3 row">
                  <label class="form-label col-md-3">image </label>
                  <div class="col-md-9">
                    <input class="form-control" name="image" type="file" required>
                  </div>
                </div>
             
              <div class="row">
                <div class="col-md-6 offset-3">
                  <button class="btn btn-primary" name="add_post" type="submit"><i class="bi bi-check-circle-fill me-2"></i>Add Post</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="#"><i class="bi bi-x-circle-fill me-2"></i>Cancel</a>
                </div>
              </div>

            </form>

          </div>
        </div>
      
      </div>
    </main>






<?php
    include_once('./includes/footer.php');
  
  ?>
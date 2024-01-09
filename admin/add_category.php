<?php
  include_once('./includes/header.php');

?>
<?php
  include_once('./includes/nav.php');

?>



<?php


 if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (!Session::get('admin_login')) {

        echo "<script>window.open('login.php')</script>";
      } else {
     

    $name = $_POST['name'];
    $status = $_POST['status'];

    $query = "INSERT INTO categories(`name`,`status`) VALUES ('$name','$status')";
    $insert = $db->insert($query);

    if ($insert) {
        echo "<div class='alert alert-success' role='alert'>
          Category Insert Successfully
        </div>";

        ?>
        <script>
            setTimeout(function(){
                window.location.href = "categories_list.php";
            },2000);
        </script>
   <?php } else{
        echo "<div class='alert alert-danger' role='alert'>
          Category Insert Fail!
        </div>";
   }
     
 }

 

}

 ?>





<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="bi bi-ui-checks"></i> Categories</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
          <li class="breadcrumb-item">Home</li>
          <li class="breadcrumb-item"><a href="#">Add Category</a></li>
        </ul>
      </div>
      <div class="row">
      
        <div class="col-md-8 offset-2">
          <div class="tile">
            <h3 class="tile-title">Add Category</h3>

       

              <form class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="mb-3 row">
                  <label class="form-label col-md-3">Name</label>
                  <div class="col-md-9">
                    <input class="form-control col-md-9" type="text" name="name" placeholder="Enter category name" required>
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
               
              
               
           
                
             
              <div class="row">
                <div class="col-md-6 offset-3">
                  <button class="btn btn-primary" name="add_category" type="submit"><i class="bi bi-check-circle-fill me-2"></i>Add Category</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="#"><i class="bi bi-x-circle-fill me-2"></i>Cancel</a>
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
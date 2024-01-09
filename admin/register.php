<?php
  include_once('./includes/header.php');

?>
<?php
  include_once('./includes/nav.php');

?>




<?php

if (isset($_POST['register'])) {

  $name = $_POST['name'];
  $email = $_POST['email'];
  $pass = $_POST['password'];
  $contact = $_POST['contact'];
  $address = $_POST['address'];
  $info = $_POST['info'];
  $image = $_FILES['image']['name'];
  $image_tmp = $_FILES['image']['tmp_name'];
  move_uploaded_file($image_tmp, "admin_images/$image");
  $insert_customer = "insert into admins (admin_name,admin_email,admin_pass,admin_contact,admin_address,photo,admin_info) values ('$name','$email','$pass','$contact','$address','$image','$info')";
  $insert=$db->insert($insert_customer);
  if ($insert) {
    echo "<div class='alert alert-success' role='alert'>
      Admin Insert Successfully
    </div>";
    
    Session::set('admin_login',true);
	  Session::set('name',$data['admin_name']);
	  Session::set('email',$data['admin_email']);
	  Session::set('admin_id',$data['id']);
    Session::set('photo',$data['photo']);
    Session::set('info',$data['info']);


    ?>
    <script>
        setTimeout(function(){
            window.location.href = "index.php";
        },2000);
    </script>
<?php } else{
    echo "<div class='alert alert-danger' role='alert'>
    Admin Insert Fail!
    </div>";
}


   

 
}

?>




<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="bi bi-ui-checks"></i> Form Samples</h1>
          <p>Sample forms</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
          <li class="breadcrumb-item">Forms</li>
          <li class="breadcrumb-item"><a href="#">Sample Forms</a></li>
        </ul>
      </div>
      <div class="row">
      
        <div class="col-md-6 offset-3">
          <div class="tile">
            <h3 class="tile-title">Register</h3>
              <form class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="mb-3 row">
                  <label class="form-label col-md-3">Name</label>
                  <div class="col-md-8">
                    <input class="form-control" type="text" name="name" placeholder="Enter full name" required>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="form-label col-md-3">Email</label>
                  <div class="col-md-8">
                    <input class="form-control col-md-8" type="email" name="email" placeholder="Enter email address" required>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="form-label col-md-3">Password</label>
                  <div class="col-md-8">
                  <input class="form-control col-md-8" type="password" name="password" placeholder="Enter Your password"required>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="form-label col-md-3">Address</label>
                  <div class="col-md-8">
                  <input class="form-control col-md-8" type="text" name="address" placeholder="Enter Your address"required>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="form-label col-md-3">Contact</label>
                  <div class="col-md-8">
                  <input class="form-control col-md-8" type="text" name="contact" placeholder="Enter Your contact"required>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label class="form-label col-md-3">Info</label>
                  <div class="col-md-8">
                  <input class="form-control col-md-8" type="text" name="info" placeholder="Enter Your Info" required>
                  </div>
                </div>
           
                <div class="mb-3 row">
                  <label class="form-label col-md-3">Photo </label>
                  <div class="col-md-8">
                    <input class="form-control" name="image" type="file" required>
                  </div>
                </div>
             
              <div class="row">
                <div class="col-md-8 col-md-offset-3">
                  <button class="btn btn-primary" name="register" type="submit"><i class="bi bi-check-circle-fill me-2"></i>Register</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="#"><i class="bi bi-x-circle-fill me-2"></i>Cancel</a>
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
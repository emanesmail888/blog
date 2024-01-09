<?php
if (Session::get('login')) {
    $email=Session::get('email');
    $user_id = Session::get('userId');
    $query = "SELECT * FROM users WHERE id= '$user_id'";
    $run_query = $db->select($query);
} ?>
<?php
$nameErr = $emailErr   = $genderErr = $imageErr ='';

// if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['submit'])) {

if (!Session::get('login')) {

    echo "<script>window.open('login.php')</script>";
  } else {


    function test_input($data) {
        $data =trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
 
// Validate name
if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }



  if (empty($_POST["gender"])) {
    $genderErr = "Gender is required";
  } else {
    $gender = test_input($_POST["gender"]);
  }


  if (empty($_FILES['image']['name'])) {
    $imageErr = "Gender is required";


    
  }else{
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($image_tmp, "./admin/admin_images/$image");

  }


if (empty($nameErr) && empty($emailErr) && empty($genderErr) && empty($imageErr)) {

$query = "UPDATE users SET name = '$name',email='$email',gender='$gender',
image='$image' WHERE id = '$user_id'";
$update = $db->update($query);


if ($update) {
    echo "<div class='alert alert-success' role='alert'>
      User Updated Successfully
    </div>";

    ?>
    <script>
        setTimeout(function(){
            window.location.href = "my_account.php";
        },2000);
    </script>
<?php } else{
    echo "<div class='alert alert-danger' role='alert'>
      User Updated Fail!
    </div>";
}
 
}

}
}

?>






	    <h2 class="title text-center">Edit Your Account </h2>
<div class="row">
    <div class="container">

    <?php 
                            if ($run_query) {
                                while($result = $run_query->fetch_assoc() ){ 
                                        
                                    ?>
<form method="post"  enctype="multipart/form-data">  
<div class="form-group col-md-10">
 <input type="text" name="name" class="form-control" value="<?php echo $result['name'] ?>" >
  <span class="error">* <?php echo $nameErr;?></span>
</div>

  <br><br>
  <div class="form-group col-md-10">
  <input type="text" name="email" class="form-control" value="<?php echo $result['email'] ?>" >
  <span class="error">* <?php echo $emailErr;?></span>
  </div>

  <br><br>
  <div class="form-group col-md-10">

   <input type="file" class="form-control" name="image" placeholder="Upload Your Image" >
  </div>
 <div style="display:inline-flex; font-size:20px;" >
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">Female
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">Male
  <span class="error">* <?php echo $genderErr;?></span>
  </div>
  <br><br>
  <input type="submit" class="btn btn-submit" name="submit" value="Submit">  
</form>
<?php } } ?>

</div>
</div>

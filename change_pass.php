
<h1 class="text-center">Change Password </h1>

<form action="" method="post"><!-- form Starts -->

<div class="form-group"><!-- form-group Starts -->

<label>Enter Your Current Password</label>

<input type="text" name="old_pass" class="form-control" required>

</div><!-- form-group Ends -->


<div class="form-group"><!-- form-group Starts -->

<label>Enter Your New Password</label>

<input type="text" name="new_pass" class="form-control" required>

</div><!-- form-group Ends -->


<div class="form-group"><!-- form-group Starts -->

<label>Enter Your New Password Again</label>

<input type="text" name="new_pass_again" class="form-control" required>

</div><!-- form-group Ends -->

<div class="text-center"><!-- text-center Starts -->

<button type="submit" name="submit" class="btn btn-primary">

<i class="fa fa-user-md"> </i> Change Password

</button>

</div><!-- text-center Ends -->

</form><!-- form Ends -->
<?php

if (Session::get('login')) {
    $email=Session::get('email');
    $user_id = Session::get('userId');
   
} 
if(isset($_POST['submit'])){


$old_pass = md5($_POST['old_pass']);

$new_pass = md5($_POST['new_pass']);

$new_pass_again = md5($_POST['new_pass_again']);

$query = "SELECT * FROM users WHERE id = '$user_id' AND password = '$old_pass'";
$run_query = $db->select($query);

$check_old_pass = mysqli_num_rows($run_query);

if($check_old_pass==0){

echo "<div class='alert alert-danger' role='alert'>
Your Current Password is not valid try again</div>";
exit();

}

if($new_pass!=$new_pass_again){
    echo "<div class='alert alert-danger' role='alert'>
    Your New Password dose not match</div>";

exit();

}

$update_pass = "update users set password='$new_pass' where id='$user_id'";
$update = $db->update($update_pass);


if ($update) {
    echo "<div class='alert alert-success' role='alert'>
      Password Updated Successfully
    </div>";

    ?>
    <script>
        setTimeout(function(){
            window.location.href = "my_account.php";
        },2000);
    </script>
<?php } else{
    echo "<div class='alert alert-danger' role='alert'>
      Password Updated Fail!
    </div>";
}
 
}






?>








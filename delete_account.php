

<h1>Do You Reaaly Want To Delete Your Account!</h1>

<form action="" method="post" class="d-flex">

<input class="btn btn-danger" type="submit" name="yes" value="Yes, I want to delete">

<input class="btn btn-success " type="submit" name="no" value="No, I Don,t want to delete">

</form>


<?php

if (Session::get('login')) {
    $email=Session::get('email');
    $user_id = Session::get('userId');
}

if (isset($_POST['yes'])) {
   
      $d_query = $db->delete($user_id, 'users');

     if ($d_query) {
      echo "<div class='alert alert-success' role='alert'>
        User Delete Successfully
      </div>";
      session_destroy();


      ?>
      <script>
          setTimeout(function(){
              window.location.href = "index.php";
          },2000);
      </script>
 <?php } 
      }

      
  

if(isset($_POST['no'])){

echo "<script>window.open('my_account.php','_self')</script>";

}



?>
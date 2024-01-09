<?php
  include_once('./includes/header.php');

?>
<?php
  include_once('./includes/nav.php');

?>
<?php


if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $query = "SELECT * FROM admins WHERE `admin_email` = '$email' AND `admin_pass` = '$password'";
  $result = $db->select($query);
  if ($result) {
  $data = $result->fetch_assoc();
    Session::set('admin_login',true);
	  Session::set('name',$data['admin_name']);
	  Session::set('email',$data['admin_email']);
	  Session::set('admin_id',$data['id']);
	  Session::set('photo',$data['photo']);
	  Session::set('info',$data['admin_info']);
      ?>
      <script>
      setTimeout(function(){
          window.location.href = "index.php";
      },2000);
  </script> 
  <?php   
  }else{
  	echo "<span style='color:red'> UserName Or Email doesn't match</span>";
  }
  
}


 ?>

<section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>Login</h1>
      </div>
      <div class="login-box">
        <form class="login-form" action="" method="post">
          <h3 class="login-head"><i class="bi bi-person me-2"></i>SIGN IN</h3>
          <div class="mb-3">
            <label class="form-label">USERNAME</label>
            <input class="form-control" type="text" name="email" placeholder="Email" autofocus required>
          </div>
          <div class="mb-3">
            <label class="form-label">PASSWORD</label>
            <input class="form-control" type="password" name="password" placeholder="Password" required>
          </div>
          <div class="mb-3">
            <div class="utility">
            
              <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Forgot Password ?</a></p>
            </div>
          </div>
          <div class="mb-3 btn-container d-grid">
            <button class="btn btn-primary btn-block" name="login"><i class="bi bi-box-arrow-in-right me-2 fs-5"></i>SIGN IN</button>
          </div>
        </form>
       
      </div>
    </section>

      <?php
  include_once('./includes/footer.php');

?>
    
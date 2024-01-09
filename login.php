<?php 
include_once("./classes/config.php");
include_once('./classes/session.php');
include_once('./classes/database.php');
include_once('./classes/check.php');
Session::checkLogin();
$db = new Database();


function test_input($data) {
    $data =trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$query = "SELECT *FROM categories
           ORDER BY id DESC LIMIT 6";
$categories = $db->select($query); 



// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = md5($_POST['password']);
  $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
  $result = $db->select($query);
  $check_result = mysqli_num_rows($result);

if($check_result==0){

	// echo "<div class='alert alert-success' role='alert'>
	// Email Or Password doesn't match  </div>";
	?>
	<script>
	alert('Email Or Password Not match' );
	setTimeout(function(){
		window.location.href = "login.php";
	},1000);
</script>
<?php
exit();


}
//   if ($result) {
  $data = $result->fetch_assoc();
	Session::set('login',true);
	Session::set('name',$data['name']);
	Session::set('email',$data['email']);
	Session::set('userId',$data['id']);

	if (isset($_SESSION['previous_page'])) {
		$previousPage = $_SESSION['previous_page'];
		unset($_SESSION['previous_page']);
		header("Location: $previousPage");
		exit();
    } else {
        header("Location: index.php");
        exit();
    }

	 

    
//    }else{

//   	echo "<span style='color:red'> UserName Or Email doesn't match</span>";
//    }
 
  
 }


$name = $email = $password = $cpassword  = $gender = $image = '';
$nameErr = $emailErr = $passwordErr = $cpasswordErr  = $genderErr = $imageErr ='';
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (isset($_POST['submit'])) {

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
	

  

    //Validate password
    if (empty($_POST['password'])) {
        $passwordErr = 'Password is required';
    } else {
        $password = md5($_POST['password']);
        if (!ctype_alnum($password)||strlen($password) < 8) {
            $passwordErr = 'Password must be at least 8 characters long';
        }
       
    }

    // // Validate confirm password
    if (empty($_POST['cpassword'])) {
        $cpasswordErr = 'Please confirm password';
    } else {
        $cpassword = md5($_POST['cpassword']);
        if ($password !== $cpassword) {
            $cpasswordErr = 'Passwords do not match';
        }
    }
  
    // // Validate gender
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
    
		if (empty($nameErr) && empty($emailErr) && empty($passwordErr) && empty($cpasswordErr) && empty($genderErr) && empty($imageErr)) {

		$insert_client = "insert into users(name,email,password,gender,image) values ('$name','$email','$password','$gender','$image')";
		$insert=$db->insert($insert_client);
		if ($insert) {
		  echo "<div class='alert alert-success' role='alert'>
			Admin Insert Successfully
		  </div>";
		
		    Session::set('login',true);
			Session::set('name',$name);
			Session::set('email',$email);
			Session::set('image',$image);
			Session::set('password',$password);
			$query_signup = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
            $result = $db->select($query_signup);
            $check_result_signup = mysqli_num_rows($result);
			if($check_result_signup!=0){
				$data = $result->fetch_assoc();
				Session::set('userId',$data['id']);

			}
			header("Location: index.php");


	

       
    }


    
}
}
 


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Blog | E-Shopper</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
        
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
<style>
.error {color: #FF0000;}
</style>
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> +2 01003457623</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> emanelgmal@domain.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="index.html"><img src="images/blog/blogg.jpg" alt="" style="width:100px; height:90px;" /></a>
						</div>
						
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
							<?php 
							if(Session::get('login'))
                            {
								?>
								<li><a href="#"><i class="fa fa-user"></i><span class="text-danger">Hello</span> <?php echo Session::get('email'); ?> </a></li>
								<li><a href="#"><i class="fa fa-user"></i> Account</a></li>
								<li><a href="?action=logout"><i class="fa fa-lock"></i> Logout</a></li>

							 <?php }else{	?>
								<li><a href="login.php"><i class="fa fa-lock"></i> Login</a></li>
                            <?php } ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="index.php" class="active">الرئيسية</a></li>
								
								<!-- <li class="dropdown"><a href="#">Blog<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="blog.html">Blog List</a></li>
										<li><a href="blog-single.html">Blog Single</a></li>
                                    </ul>
                                </li>  -->
								<?php
								    foreach ($categories as  $value) { ?>
										<li><a href="category-post.php?cid=<?php echo base64_encode($value['id']) ?>&page=1"> <?php echo $value['name'] ?></a></li>
									 <?php }
								   ?>

								
								<li><a href="sendemail.php">اتصل بنا</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3">
					<form action="search.php" method="post" accept-charset="UTF-8">

						<div class="search_box pull-right">
							<input type="text" name="txtSearch" placeholder="Search">
							<button class="btn btn-search py-1"  type="submit" name="search">
							<span class="glyphicon glyphicon-search text-secondary p-1"></span>
							</button>
						</div>
						</form>
				
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->



<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Login to your account</h2>
						<form action="#" method="POST">
							<input type="email" name="email" placeholder="Email Address" >
							<input type="password" name="password" placeholder="Email Address" >
							
							<button type="submit" name="login" class="btn btn-default">Login</button>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>



				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>New User Signup!</h2>
						<p><span class="error">* required field</span></p>
						<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">  
						<input type="text" name="name" value="<?php echo $name;?>" placeholder="Name" >
						<span class="error">* <?php echo $nameErr;?></span>
						<br><br>
						<input type="text" name="email" value="<?php echo $email;?>" placeholder="Email" >
						<span class="error">* <?php echo $emailErr;?></span>
						<br><br>
						<input type="password" name="password" value="<?php echo $password;?>" placeholder="Password" >
						<span class="error"><?php echo $passwordErr;?></span>
						<br><br>
						<input type="password" name="cpassword" value="<?php echo $cpassword;?>" placeholder="Confirm Pasword" >
						<span class="error"><?php echo $cpasswordErr;?></span>  <br><br>
						<input type="file" name="image" placeholder="Upload Your Image" >
						<!-- <span class="error"><?php echo $cpasswordErr;?></span>  <br><br> -->
						<div style="display:inline-flex; font-size:20px;" >
						<input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">Female
						<input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">Male
						<span class="error">* <?php echo $genderErr;?></span>
						</div>
						<br><br>
						<input type="submit" class="btn btn-submit" name="submit" value="Submit">  
						</form>
					</div><!--/sign up form-->
				</div>


				
			</div>
		</div>
	</section><!--/form-->
	
	
	<?php 
include_once("includes/footer.php");
?>
  
 
<?php 
include_once("classes/config.php");
include_once('classes/session.php');
include_once('classes/database.php');
include_once('classes/check.php');
Session::checkSession();
$db = new Database();
$hp = new Check();

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
	Session::destroy();
  }

$query = "SELECT *FROM categories
           ORDER BY id DESC LIMIT 6";
$categories = $db->select($query); 

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
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
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
								<li class="dropdown"><a href="#">Posts<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu d-block">
									<li><a href="user_posts.php?user=<?php echo Session::get('userId')?>&&name=<?php echo Session::get('name')?>">My Posts</a></li>
									<li><a href="add_post.php">Add Post</a></li>
									</ul>
                                </li> 

											
										
                                        <?php }?>
									
								
							<?php 
							if(Session::get('login'))
                            {
								?>
								<li><a href="#"><i class="fa fa-user"></i><span class="text-danger">Hello</span> <?php echo Session::get('email'); ?> </a></li>
								<li><a href="my_account.php"><i class="fa fa-user"></i> Account</a></li>
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



	
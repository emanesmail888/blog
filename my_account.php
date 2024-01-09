<?php
  include_once('includes/header.php');

?>


<div id="content" ><!-- content Starts -->
<div class="container" ><!-- container Starts -->

<div class="col-md-12" ><!--- col-md-12 Starts -->

<ul class="breadcrumb" ><!-- breadcrumb Starts -->

<li>
<a href="index.php">Home</a>
</li>

<li>My Account</li>

</ul><!-- breadcrumb Ends -->



</div><!--- col-md-12 Ends -->
<div class="row">

<div class="col-md-3">

<?php include("./sidebar.php"); ?>

</div><!-- col-md-3 Ends -->

<div class="col-md-9" >

<div class="box" >

<?php

if(isset($_GET['my_orders'])){

include("my_orders.php");

}

if(isset($_GET['pay_offline'])) {

include("pay_offline.php");

}

if(isset($_GET['edit_account'])) {

include("edit_account.php");

}

if(isset($_GET['change_pass'])){

include("change_pass.php");

}

if(isset($_GET['delete_account'])){

include("delete_account.php");

}
if(isset($_GET['my_wishlist'])){

  include("my_wishlist.php");
  
  }
  
if(isset($_GET['delete_wishlist'])){

include("delete_wishlist.php");

}


?>

</div><!-- box Ends -->


</div><!--- col-md-9 Ends -->
</div><!-- row -->

</div><!-- container Ends -->
</div><!-- content Ends -->

<?php 
include_once("includes/footer.php");
?>
  



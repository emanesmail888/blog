
<div class="panel panel-default sidebar-menu bg-white"><!-- panel panel-default sidebar-menu Starts -->

<div class="panel-heading "><!-- panel-heading Starts -->


<?php

if (Session::get('login')) {
    $email=Session::get('email');
    $user_id = Session::get('userId');
    $query = "SELECT * FROM users WHERE email = '$email' AND id = '$user_id'";
    $run_query = $db->select($query);
    if ($run_query) {
        while($result= mysqli_fetch_assoc($run_query)): ?>
         <div class="blog-thumb">
            <img src="./admin/admin_images/<?php echo $result['image']; ?>" style="width: 220px; height:200px;" alt="ffff">

         </div>
         <h5>Name:<?php echo $result['name'] ?></h5></h5>
         <?php  endwhile; 
        }
       }

           ?>




</div><!-- panel-heading Ends -->

<div class="panel-body bg-white"><!-- panel-body Starts -->

<ul class="  "><!-- nav nav-pills nav-stacked Starts -->





<li class="<?php if(isset($_GET['edit_account'])){ echo "active"; } ?>">

<a href="my_account.php?edit_account"> <i class="fa fa-pencil"></i> Edit Account </a>

</li>

<li class="<?php if(isset($_GET['change_pass'])){ echo "active"; } ?>">

<a href="my_account.php?change_pass"> <i class="fa fa-user"></i> Change Password </a>

</li>
<!-- <li class="<?php if(isset($_GET['my_wishlist'])){ echo "active"; } ?>">

<a href="my_account.php?my_wishlist"> <i class="fa fa-heart"></i> My WishList </a>

</li> -->

<li class="<?php if(isset($_GET['delete_account'])){ echo "active"; } ?>">

<a href="my_account.php?delete_account"> <i class="fa fa-trash-o"></i> Delete Account </a>

</li>


<li><a href="?action=logout"><i class="fa fa-lock"></i> Logout</a></li>




</ul><!-- nav nav-pills nav-stacked Ends -->

</div><!-- panel-body Ends -->

</div><!-- panel panel-default sidebar-menu Ends -->
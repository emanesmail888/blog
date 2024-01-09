<?php
  include_once('includes/header.php');

?>
<?PHP 
$post_per_page = 4;
if (isset($_GET["page"])) {
  $page = $_GET["page"];
} else {
  $page = 1;
}
$start_form = ($page - 1) * $post_per_page;

if(isset($_GET['user'])){
  $user =$_GET['user'];
  $query_search = "SELECT posts.*, posts.id as pid, categories.id as cid FROM posts
  INNER JOIN categories ON posts.category_id = categories.id  where posts.user_id = '$user' ORDER BY posts.id DESC  limit $start_form, $post_per_page  ";
  $posts = $db->select($query_search);

  $query_pagination = "SELECT *, posts.id as pid, categories.id as cid FROM posts
  INNER JOIN categories ON posts.category_id = categories.id  where posts.user_id = '$user' ";
  $pagination = $db->select($query_pagination);
  $total_rows = mysqli_num_rows($pagination);

  if ($total_rows > 0) {
    $total_pages = ceil($total_rows / $post_per_page);
  }

}
?>
<?php
if (isset($_GET['delId'])) {
      if (!Session::get('login')) {

        echo "<script>window.open('login.php')</script>";
      } else {
      }
        $user_name=Session::get('name');
        $user_id=Session::get('userId');
        $id = $_GET['delId'];
        $d_query = $db->delete($id, 'posts');

       if ($d_query) {
        echo "<div class='alert alert-success' role='alert'>
          Post Delete Successfully
        </div>";

        ?>
<script>
setTimeout(function() {
    window.location.href = "user_posts.php?user=<?php echo $user_id ?>&&name=<?php echo $user_name ?>";
}, 500);
</script>
<?php } else{
        echo "<div class='alert alert-danger' role='alert'>
          Post Delete Fail!
        </div>";
   }

        
    }

 ?>

<section class="blog-posts ">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">

                <div class="blog-post-area">
                    <h2 class="title text-center">All Posts Of User (<span
                            style="color:orange;"><?php echo $_GET['name']; ?></span>)</h2>

                    <?php
           
            if ($posts) {
                while($result= mysqli_fetch_assoc($posts)): ?>
                    <div class="single-blog-post">
                        <h3><?php echo $result['title']; ?></h3>
                        <div class="post-meta">
                            <ul>
                                <?php
									if($result['added_by']=== "USR" ){
									$user_id= $result['user_id']; 
									$query2= "SELECT * FROM users WHERE id = '$user_id' ";
  
									$run_query=$db->select($query2);
                  $check_result1 = mysqli_num_rows($run_query);

                  if($check_result1!==0){
                      $data = $run_query->fetch_assoc();
                      $user_name = $data['name'];
                      $image=$data['image'];

                  }
                  else{
                      $user_name = 'undefined user';
                      $image='dummy.jpeg';


                  }
									
										

								}else{
									$user_id= $result['user_id']; 

								$query_admin= "SELECT * FROM admins WHERE id = '$user_id' ";

								$run_query_admin=$db->select($query_admin);
                $check_result = mysqli_num_rows($run_query_admin);

                if($check_result!==0){
                // if ($run_query_admin) {
                    $data_admin = $run_query_admin->fetch_assoc();
                    $user_name = $data_admin['admin_name'];
                    $image=$data_admin['photo'];

                }
                else{
                    $user_name = 'undefined user';
                    $image='dummy.jpeg';

                }
									
								}
							?>
                                <li><i
                                        class="fa fa-user"></i><?php echo isset($user_name) ? $user_name : 'undefined user'; ?>
                                </li>
                                <li><i class="fa fa-calendar"></i>create: <?php echo $result['created_at']; ?></li>
                                <li><i class="fa fa-calendar"></i>update: <?php echo $result['updated_at']; ?></li>
                            </ul>


                            <?php
								 $post_id= $result['pid'];
								$review = "SELECT rating FROM reviews where post_id='$post_id'";
                                $run_review = $db->select($review);
								if($run_review){

									$totalReviews = mysqli_num_rows($run_review);
                                    $sumRatings = 0;

									if($totalReviews){
										while ($show_review  = mysqli_fetch_assoc($run_review)) {
											$sumRatings += $show_review['rating'];
										}
										
										$averageRating = $sumRatings / $totalReviews;
										
									}
										else{
											
										$averageRating = 0;
										
										}
								
									$fullStars = floor($averageRating);
                                    $halfStar = ($averageRating - $fullStars) >= 0.5;
                                    $emptyStars = 5 - $fullStars - $halfStar;
                                    ?>
                            <span>
                                <?php
                                    echo "Average Rating: ";

                                    // Full stars
                                    for ($i = 0; $i < $fullStars; $i++) {
                                        echo "<i class='fa fa-star' style='color:#FE980F;'></i>";
                                    }

                                    // Half star
                                    if ($halfStar) {
                                        echo "<i class='fa fa-star-half-o' style='color:#FE980F;'></i>";
                                    }

                                    // Empty stars
                                    for ($i = 0; $i < $emptyStars; $i++) {
                                        echo "<i class='fa fa-star-o' style='color:#8C8C88;'></i>";
                                    }
                                    }							
                                                                    
                                    ?>




                        </div>
                        <a href="">
                            <img src="./admin/uploads/<?php echo $result['image']; ?>"
                                style=" height:300px; width:600px;" alt="">
                        </a>

                        <p><?php echo $result['details']; ?> </p>
                        <a class="btn btn-primary" href="blog-single.php?slug=<?php echo $result['slug'] ?>">Read
                            More</a>
                        <?php
              if (Session::get('login')) {
                $user_id=Session::get('userId');
                if($user_id===$result['user_id'])
                {?>
                        <a class="btn btn-danger " href="?delId=<?php echo $result['id'] ?>">Delete</a>
                        <a class="btn btn-warning"
                            href="edit_post.php?id=<?php echo base64_encode($result['pid']) ?>">Edit</a>


                        <?php } } ?>







                    </div>
                    <?php  endwhile; 
                         } else {
                            ?>

                    <h2 class="text-danger text-center">Not Any Posts Found !!</h2>

                    <?php  }

                            ?>


                    <div class="col-lg-12 text-center">
                        <?php
              if ($total_rows == 0) {
                echo "No Posts";
              } else {


              ?>
                        <ul class="pagination">
                            <li><a
                                    href="user_posts.php?user=<?php echo $_GET['user'] ?>&&name=<?php echo $_GET['name'] ?>&page=1"><i
                                        class="fa fa-angle-double-left"></i></a></li>
                            <?php
                  $c = "active";
                  for ($i = 1; $i <= $total_pages; $i++) {
                    if (@$_GET['page'] == $i) {
                      echo "<li class='active' ><a href='user_posts.php?user=" . $_GET['user'] . "&&name=" . $_GET['name'] . " &page=" . $i . " ' >" . $i . "</a></li>";
                    } else {

                      echo "<li ><a href='user_posts.php?user=". $_GET['user'] . "&&name=" . $_GET['name'] . "&page=" . $i . " ' >" . $i . "</a></li>";
                    }
                  }

                  ?>
                            <li><a
                                    href="user_posts.php?user=<?php echo $_GET['user'] ?>&&name=<?php echo $_GET['name'] ?>&page=<?php echo $total_pages ?>"><i
                                        class="fa fa-angle-double-right"></i></a></li>
                        </ul>
                        <?php  } ?>
                    </div>
                </div>


            </div>

            <div class="col-sm-4">
                <div class="left-sidebar">

                    <?php include_once('includes/sidebar.php'); ?>
                </div>
            </div>

        </div>
    </div>
</section>


<?php
include_once('includes/footer.php');
?>
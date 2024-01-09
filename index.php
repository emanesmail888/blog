<?php
  include_once('includes/header.php');

?>

<?php

$post_per_page = 3;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$start_from = ($current_page - 1) * $post_per_page;


$query = "SELECT posts.*,categories.name, posts.id as pid, categories.id as cid FROM posts
          INNER JOIN categories ON posts.category_id = categories.id ORDER BY posts.id DESC LIMIT $start_from ,$post_per_page ";
		   
$posts = $db->select($query);



// Query to count total number of rows
$countQuery = "SELECT COUNT(*) as total_rows FROM posts";

$countStmt =  $db->select($countQuery);
if($countStmt){
while($row=mysqli_fetch_array($countStmt))
{
    $total_rows = $row['total_rows'];


}
$total_pages = ceil($total_rows / $post_per_page);
}
else{
	?><h2 class="text-danger text-center">This Category Hasen't Any Posts</h2>
<?php

}
// for Body section 
$query1 = "SELECT *, posts.id as pid, categories.id as cid FROM posts
          INNER JOIN categories ON posts.category_id = categories.id WHERE posts.status = 1 ORDER BY posts.id DESC LIMIT 4";
$posts1 = $db->select($query1);





?>



<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <div class="left-sidebar">

                    <?php  include_once('includes/sidebar.php'); ?>


                </div>
            </div>
            <div class="col-sm-7">
                <div class="blog-post-area">
                    <h2 class="title text-warning text-center">احدث الاخبار</h2>
                    <?php 
                      if ($posts) {
                
                while($result =mysqli_fetch_array($posts) ){  ?>
                    <div class="single-blog-post">
                        <a href="category-post.php?cid=<?php echo base64_encode($result['cid']) ?>"
                            class=" btn btn-primary d-block ">
                            <?php echo $result['name']; ?>
                        </a>

                        <a href="blog-single.php?slug=<?php echo $result['slug'] ?>">
                            <h4><?php echo $result['title']; ?></h4>
                        </a>



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

                                <li><i class="fa fa-user"></i>
                                    <?php echo isset($user_name) ? $user_name : 'undefined user'; ?></li>
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
                    </div>
                    <?php  }    ?>

                    <?php  }else{ ?>

                    <h2 class="text-danger text-center">This Category Hasen't Any Posts</h2>

                    <?php  }  ?>




                    <div class="col-lg-12 text-center">
                        <?php
                  if ($total_rows == 0) {
                    echo "No Posts";
  
                  }
                  else{

                 
                  ?>
                        <ul class="pagination">

                            <li><a href="index.php?page=1"><i class="fa fa-angle-double-left"></i></a></li>
                            <?php 

   
	for ($i=1; $i<=$total_pages; $i++) { 

		if(@$_GET['page'] == $i)

		{
			echo "<li class='active'><a href='index.php?page=". $i . "'>".$i. "</a></li>";
	   
		  }
		  else{
	   
			echo "<li ><a href='index.php?page=". $i . "'>".$i. "</a></li>";
		}
	   

	  

	 
	
	  
	}

   ?>
                            <li><a href="index.php?page=<?php echo $total_pages ?>"><i
                                        class="fa fa-angle-double-right"></i></a></li>
                        </ul>
                        <?php } ?>
                    </div>






                </div>
            </div>
        </div>
    </div>
</section>



<?php
  include_once('includes/footer.php');
?>
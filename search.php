<?php
  include_once('includes/header.php');

?>
<?PHP 
if(isset($_POST['search'])){

    //  $search =isset($_POST['txtSearch']);
     $search =$_POST['txtSearch'];
     echo"<h2 class='text-warning text-center'>  نتائح البحث:( ". $_POST['txtSearch'] .")</h2>";
    //   $query_search = "select * from posts where title like '%$search%' or tags like '%$search%'";
  $query_search = "SELECT *, posts.id as pid, categories.id as cid FROM posts
  INNER JOIN categories ON posts.category_id = categories.id  where posts.title like '%$search%' or posts.tags like '%$search%'";


	 $posts = $db->select($query_search);

}
?>	

<section class="blog-posts ">
  <div class="container">
    <div class="row">
      <div class="col-sm-8">
        <div class="all-blog-posts">
          <div class="row">

            <?php
            if ($posts) {

                while($result= mysqli_fetch_assoc($posts)): ?>
                <div class="col-sm-6 ">
                  <div class="blog-post">
                    <div class="blog-thumb">
                      <img src="./admin/uploads/<?php echo $result['image']; ?>" style="width: 320px; height:280px;" alt="ffff">
                    </div>
                    <div class="down-content " style="height:220px;">
                      <a  class="btn-primary" href="category-post.php?cid=<?php echo base64_encode($result['cid']) ?>">
                        <span><?php echo $result['name']; ?></span>
                      </a>
                      <a href="blog-single.php?slug=<?php echo $result['slug'] ?>">
                        <h4 ><?php echo $result['title']; ?></h4>
                      </a>
                      <ul class="post-info d-flex ">
                        
                        <a href="#">
                          <span class="text-warning pull-left">
                          <?php
                          $date = date_create($result['created_at']);
                          echo date_format($date, "d M,Y");
                          ?>
                          </span>

                        </a></li>
                        <?php 
                        $p_id=$result['pid'];
                         $count_comments = "SELECT COUNT(*) as total_comments FROM comments WHERE post_id='$p_id'  ";
                         $countStmt =  $db->select($count_comments);
                         if ($countStmt) {
                             while ($row_comment = mysqli_fetch_array($countStmt)) {
                                 $total_comments = $row_comment['total_comments'];
                             }
                            }
                             ?>
                        <a href="blog-single.php?slug=<?php echo $result['slug'] ?>"> &nbsp; &nbsp; &nbsp; &nbsp; <span class="text-danger "> <?php echo $total_comments;?> Comments </span></a>
                      </ul>
                      <h5><?php echo substr($result['details'], 0, 500) ?></h5>

                    </div>
                  </div>
                </div>



              <?php  endwhile; 
            } else {
              ?>

              <h2 class="text-danger text-center">Not Any Posts Found !!</h2>

            <?php  }

            ?>

          







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

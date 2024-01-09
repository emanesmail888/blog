<?php
include_once('includes/header.php');

?>

<?php

$post_per_page = 4;
if (isset($_GET["page"])) {
  $page = $_GET["page"];
} else {
  $page = 1;
}
$start_form = ($page - 1) * $post_per_page;
if ($_GET['cid']) {

  $id = base64_decode($_GET['cid']);
  //pagination

  $query = "SELECT *, posts.id as pid, categories.id as cid FROM posts
            INNER JOIN categories ON posts.category_id = categories.id where posts.category_id = '$id' limit $start_form, $post_per_page";
  $posts = $db->select($query);

  //allPosts
  $query1 = "SELECT *, posts.id as pid, categories.id as cid FROM posts
            INNER JOIN categories ON posts.category_id = categories.id where posts.category_id = '$id'";
  $posts1 = $db->select($query1);
  $total_rows = mysqli_num_rows($posts1);


  if ($total_rows > 0) {
    $total_pages = ceil($total_rows / $post_per_page);
  }
  $query = "SELECT * FROM categories WHERE id = $id";
  $categorie = $db->select($query);
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

              foreach ($posts as $result) { ?>

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



              <?php  }
            } else {
              ?>

              <h2 class="text-danger text-center">This Category Hasen't Any Posts</h2>

            <?php  }

            ?>

            <div class="col-lg-12 text-center">
              <?php
              if ($total_rows == 0) {
                echo "No Posts";
              } else {


              ?>
                <ul class="pagination">


                  <li><a href="category-post.php?cid=<?php echo $_GET['cid'] ?>&page=1"><i class="fa fa-angle-double-left"></i></a></li>
                  <?php
                  $c = "active";

                  // $current_url = $_SERVER['REQUEST_URI'];
                  // echo $current_url;

                  for ($i = 1; $i <= $total_pages; $i++) {
                    if (@$_GET['page'] == $i) {
                      echo "<li class='active' ><a href='category-post.php?cid=" . $_GET['cid'] . "&page=" . $i . " ' >" . $i . "</a></li>";
                    } else {

                      echo "<li ><a href='category-post.php?cid=" . $_GET['cid'] . "&page=" . $i . " ' >" . $i . "</a></li>";
                    }
                  }

                  ?>
                  <li><a href="category-post.php?cid=<?php echo $_GET['cid'] ?>&page=<?php echo $total_pages ?>"><i class="fa fa-angle-double-right"></i></a></li>
                </ul>
              <?php  } ?>
            </div>








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

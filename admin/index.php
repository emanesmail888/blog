<?php
  include_once('includes/header.php');

?>
<?php
  include_once('includes/nav.php');

?>
<?php
   if (!Session::get('admin_login')) {

    echo "<script>window.open('login.php')</script>";
  } else {
$cat_query = "SELECT COUNT(*) as total_rows FROM categories";

$cat_Stmt =  $db->select($cat_query);
if($cat_Stmt){
while($row=mysqli_fetch_array($cat_Stmt))
{
    $cat_total_rows = $row['total_rows'];


}
}

$post_query = "SELECT COUNT(*) as total_rows FROM posts";

$post_Stmt =  $db->select($post_query);
if($post_Stmt){
while($row=mysqli_fetch_array($post_Stmt))
{
    $post_total_rows = $row['total_rows'];


}
}

$user_query = "SELECT COUNT(*) as total_rows FROM users";

$user_Stmt =  $db->select($user_query);
if($user_Stmt){
while($row=mysqli_fetch_array($user_Stmt))
{
    $user_total_rows = $row['total_rows'];


}
}

$review_query = "SELECT COUNT(*) as total_rows FROM reviews";

$review_Stmt =  $db->select($review_query);
if($review_Stmt){
while($row=mysqli_fetch_array($review_Stmt))
{
    $review_total_rows = $row['total_rows'];


}
}

?>
  
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="bi bi-speedometer"></i> Dashboard</h1>
          <p>A free and open source Bootstrap 5 admin template</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-3">
          <div class="widget-small primary coloured-icon"><i class="icon bi bi-people fs-1"></i>
            <div class="info">
              <h4>Users</h4>
              <p><b><?php echo $user_total_rows; ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small info coloured-icon"><i class="icon bi bi-heart fs-1"></i>
            <div class="info">
              <h4>Posts</h4>
              <p><b><?php echo $post_total_rows; ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">

        <div class="widget-small danger coloured-icon"><i class="icon bi bi-star fs-1"></i>
            <div class="info">
              <h4>Stars</h4>
              <p><b><?php echo $review_total_rows; ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small warning coloured-icon"><i class="icon bi bi-folder2 fs-1"></i>

            <div class="info">
              <h4>Categories</h4>
              <p><b><?php echo $cat_total_rows; ?></b></p>
            </div>
          </div>
        </div>
      </div>
     
    </main>
    <?php } ?>
  

    <?php
  include_once('includes/footer.php');

?>
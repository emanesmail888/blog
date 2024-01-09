<?php 
include_once("./classes/config.php");
include_once('./classes/session.php');
include_once('./classes/database.php');
include_once('./classes/check.php');
Session::checkLogin();
$db = new Database();
// Retrieve form data
if(Session::get('login'))
{
$post_id = $_POST['post_id'];
$user_id =Session::get('userId');

$rating = $_POST['rating'];



// Insert the review into the database
$query = "INSERT INTO reviews (post_id, user_id, rating, created_at)
        VALUES ('$post_id', '$user_id', $rating, NOW())";


$insert = $db->insert($query);

if ($insert) {
    echo "<div class='alert alert-success' role='alert'>
      Review submitted Successfully
    </div>";

    ?>
  
<?php } else{
    echo "<div class='alert alert-danger' role='alert'>
    Review submitted Fail!
    </div>";
}
}
else{
  header("Location: login.php");

}

?>
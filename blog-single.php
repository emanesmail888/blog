<?php
require_once("includes/header.php");

$slug = @$_GET['slug'];
$query = "SELECT *, posts.id as pid, categories.id as cid FROM posts
			INNER JOIN categories ON posts.category_id = categories.id where posts.slug = '$slug' ";
$posts = $db->select($query);


?>




<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <div class="left-sidebar">
                    <?php include_once('includes/sidebar.php'); ?>
                </div>

            </div>
            <div class="col-sm-7">
                <div class="blog-post-area">
                    <h2 class="title text-center text-warning">Post Details</h2>

                    <?php
                    if ($posts) {
                        while ($result = mysqli_fetch_array($posts)) {

                    ?>

                    <div class="single-blog-post">
                        <h3><?php echo $result['title']; ?></h3>
                        <div class="post-meta">
                            <ul>
                                <?php
                                        if ($result['added_by'] === "USR") {
                                            $user_id = $result['user_id'];
                                            $query2 = "SELECT * FROM users WHERE id = '$user_id' ";
                                            $run_query = $db->select($query2);
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
                                        } else {
                                            $user_id = $result['user_id'];

                                            $query_admin = "SELECT * FROM admins WHERE id = '$user_id' ";

                                            $run_query_admin = $db->select($query_admin);
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
                                <li><i class="fa fa-user"></i><?php echo  $user_name ; ?></li>
                                <li><i class="fa fa-calendar"></i>create: <?php echo $result['created_at']; ?></li>
                                <li><i class="fa fa-calendar"></i>update: <?php echo $result['updated_at']; ?></li>
                            </ul>
                            <?php
                                    $post_id = $result['pid'];
                                    $review = "SELECT rating FROM reviews where post_id='$post_id'";
                                    $run_review = $db->select($review);
                                    if ($run_review) {

                                        $totalReviews = mysqli_num_rows($run_review);
                                        $sumRatings = 0;

                                        if ($totalReviews) {
                                            while ($show_review  = mysqli_fetch_assoc($run_review)) {
                                                $sumRatings += $show_review['rating'];
                                            }

                                            $averageRating = $sumRatings / $totalReviews;
                                        } else {

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

                            </span>




                        </div>
                        <a href="">
                            <img src="./admin/uploads/<?php echo $result['image']; ?>" alt="">
                        </a>
                        <p>
                            <?php echo $result['details']; ?>
                        </p>



                    </div>
                </div>
                <!--/blog-post-area-->

                <!--rating-area-->
                <div class="rating-area rating-stars ">
                    <ul class="ratings " id="ratings">
                        <li class="rate-this">Rate this item:</li>
                        <li class='star' data-value='1'>
                            <i class='fa fa-star '></i>
                        </li>
                        <li class='star' data-value='2'>
                            <i class='fa fa-star '></i>
                        </li>
                        <li class='star' data-value='3'>
                            <i class='fa fa-star '></i>
                        </li>
                        <li class='star' data-value='4'>
                            <i class='fa fa-star '></i>
                        </li>
                        <li class='star' data-value='5'>
                            <i class='fa fa-star '></i>
                        </li>
                        <div class='success-box'>
                            <div class='text-message'></div>
                            <input type="hidden" name="rating" id="rating-input" value="" required>

                            <input type="hidden" name="post_id" id="post_id" value="<?php echo  $result['pid']; ?>"
                                required>

                        </div>
                        <li class="color">(<?php echo $totalReviews . " votes "; ?>)</li>
                    </ul>
                    <ul class="tag d-flex">
                        <li>TAG:</li>
                        <li><a class="color" href=""><?php echo (trim($result['tags'], " ")); ?></a></li>

                    </ul>
                </div>
                <!--/rating-area-->


              <!--Comments section-->
                            <?php
                            if (isset($_POST['post_comment'])) {
                                if (Session::get('admin_login')) {
                                    $name = $_POST['name'];
                                    // $p_id=$result['pid'];
                                    $email = $_POST['email'];
                                    $comment = $_POST['comment'];
                                    $u_id = Session::get('admin_id');
                                    $run_comment = "INSERT INTO comments(`user_id`,`post_id`,`name`,`email`,`comment`,`added_by`) VALUES ('$u_id','$p_id','$name','$email','$comment','ADM')";
                                    $insert = $db->insert($run_comment);
                                    if ($insert) {
                                        echo "<div class='alert alert-success' role='alert'>m
                                      Comment Added Successfully
                                    </div>";
                                   }
                                   else {
                                        echo "<div class='alert alert-danger' role='alert'>
                                      Comment Insert Fail!
                                    </div>";
                                    }
                               
                                }
                                elseif (Session::get('login')) {

                                    $name = $_POST['name'];
                                    // $p_id=$result['pid'];
                                    $email = $_POST['email'];
                                    $comment = $_POST['comment'];
                                    $u_id = Session::get('userId');
                                    $run_comment = "INSERT INTO comments(`user_id`,`post_id`,`name`,`email`,`comment`,`added_by`) VALUES ('$u_id','$p_id','$name','$email','$comment','USR')";
                                    $insert = $db->insert($run_comment);

                                    if ($insert) {
                                        echo "<div class='alert alert-success' role='alert'>
                                          Comment Added Successfully
                                        </div>";
                                    } else {
                                        echo "<div class='alert alert-danger' role='alert'>
                                          Comment Insert Fail!
                                        </div>";
                                    }
                                }
                                else {
                                    $_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];

                                    echo "<script>window.open('login.php')</script>";
                                }
                            }
                            ?>

                <div class="media commnets">
                    <a class="pull-left" href="#">
                        <?php echo isset($image) ? '<img class="media-object" style="width:100px;height:100px;" src="./admin/admin_images/' . $image . '" alt="">'
                             : '<img class="media-object" style="width:100px;height:100px;" src="./admin/admin_images/' . $image . '" alt="">'; ?>
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo isset($user_name) ? $user_name : 'undefined user'; ?></h4>
                        <p>The Owner Of Tis Post Is <?php echo isset($user_name) ? $user_name : 'undefined user'; ?>,
                            This Post Published At <?php echo $result['created_at']; ?>,
                            This Post Updated At <?php echo $result['updated_at']; ?>, You Can Get In Touch With The
                            Owner At His Links Down..,You Can Leave Comments On This Post
                            , you Can See More Other Posts Of This User.</p>
                        <div class="blog-socials">
                            <ul>
                                <li><a href=""><i class="fa fa-facebook"></i></a></li>
                                <li><a href=""><i class="fa fa-twitter"></i></a></li>
                                <li><a href=""><i class="fa fa-dribbble"></i></a></li>
                                <li><a href=""><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                            <a class="btn btn-primary"
                                href="user_posts.php?user=<?php echo $user_id ?>&&name=<?php echo $user_name ?>">Other
                                Posts
                            </a>
                        </div>
                    </div>
                </div>
                <?php

                        }
                    }
                    ?>


       <!--/Comments section-->
                <?php
                if ($_GET['slug']) {

                    $slug = $_GET['slug'];

                    $query = "SELECT *, posts.id as pid, categories.id as cid FROM posts
                    INNER JOIN categories ON posts.category_id = categories.id where posts.slug = '$slug' ";
                    $posts = $db->select($query);
                    if ($posts) {
                        while ($result = mysqli_fetch_array($posts)) {
                            $p_id = $result['pid'];
                        }
                    }
                }
                $post_per_page = 4;
                $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                $start_from = ($current_page - 1) * $post_per_page;
                $comments_query = "SELECT * FROM comments WHERE post_id='$p_id' limit $start_from, $post_per_page  ";
                $comments = $db->select($comments_query);
                $count_comments = "SELECT COUNT(*) as total_rows FROM comments WHERE post_id='$p_id'  ";
                $countStmt =  $db->select($count_comments);
                if ($countStmt) {
                    while ($row = mysqli_fetch_array($countStmt)) {
                        $total_rows = $row['total_rows'];
                    }
                    $total_pages = ceil($total_rows / $post_per_page);
                }
               ?>
                <!--Responses-->
                <div class="response-area">
                    <h2><?php echo $total_rows; ?> RESPONSES</h2>
                    <ul class="media-list">
                        <?php

                      if ($comments) {
                       while ($show_comment = mysqli_fetch_assoc($comments)) {
                        $comment_user = $show_comment['name'];
                        $comment_date = $show_comment['created_at'];
                        $comment_body = $show_comment['comment'];
                        $comment_added_by = $show_comment['added_by'];

                        if ($show_comment['added_by'] === "USR") {
                            $c_user = $show_comment['user_id'];
                            $query_c_user = "SELECT * FROM users WHERE id = '$c_user' ";

                            $run_query_c_user = $db->select($query_c_user);
                            if ($run_query_c_user) {
                                $c_data = $run_query_c_user->fetch_assoc();
                                $c_user_name = $c_data['name'];
                                $c_user_image = $c_data['image'];
                            }
                        } else {
                            $c_admin = $show_comment['user_id'];

                            $c_query_admin = "SELECT * FROM admins WHERE id = '$c_admin' ";

                            $run_query_c_admin = $db->select($query_admin);
                            if ($run_query_c_admin) {
                                $data_c_admin = $run_query_c_admin->fetch_assoc();
                                $c_user_name = $data_c_admin['admin_name'];
                                $c_user_image = $data_c_admin['photo'];
                            }
                        }

                        ?>
                        <li class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="./admin/admin_images/<?php echo $c_user_image; ?>"
                                    alt="">
                            </a>
                            <div class="media-body">
                                <ul class="sinlge-post-meta">
                                    <li><i class="fa fa-user"></i><?php echo $c_user_name; ?></li>
                                    <li><i class="fa fa-user"></i><?php echo $comment_added_by; ?></li>
                                    <li><i class="fa fa-clock-o"></i><i class="fa fa-calendar"></i>
                                        <?php echo $comment_date; ?></li>
                                </ul>
                                <p><?php echo $comment_body; ?>.</p>
                                <a class="btn btn-primary" href="#replay"><i class="fa fa-reply"></i>Replay</a>
                            </div>
                        </li>
                        <?php
                        }
                        $total_pages = ceil($total_rows / $post_per_page);

                        ?>
                    </ul>
                </div>


                <!--Responses Pagination-->

                <div class="col-lg-12 text-center">
                    <?php
                        if ($total_rows == 0) {
                            echo "<h4 class='text-warning'> No Comments Yet !!! </h4>";
                        } else { ?>
                    <ul class="pagination">
                        <li><a href="blog-single.php?slug=<?php echo $_GET['slug'] ?>&page=1"><i
                                    class="fa fa-angle-double-left"></i></a></li>
                            <?php
                            for ($i = 1; $i <= $total_pages; $i++) {
                                if (@$_GET['page'] == $i) {
                                    echo "<li class='active' ><a href='blog-single.php?slug=" . $_GET['slug'] . "&page=" . $i . " ' >" . $i . "</a></li>";
                                } else {

                                    echo "<li ><a href='blog-single.php?slug=" . $_GET['slug'] . "&page=" . $i . " ' >" . $i . "</a></li>";
                                }
                            }

                            ?>
                        <li><a href="blog-single.php?slug=<?php echo $_GET['slug'] ?>&page=<?php echo $total_pages ?>"><i
                                    class="fa fa-angle-double-right"></i></a></li>
                    </ul>
                    <?php  } ?>
                </div>

                <?php }
                   ?>

                <?php
                $u_id = Session::get('userId');
                $u_email = Session::get('email');
                $u_name = Session::get('name');
                ?>
                <!--/Response-area-->
                <div class="replay-box" id="replay">
                    <div class="row">
                        <form method="post">
                            <h2>Leave a replay</h2>
                            <div class="blank-arrow">
                                <label>Your Name</label>
                            </div>
                            <span>*</span>
                            <input type="text" name="name" value="<?php echo $u_name; ?>">

                            <div class="blank-arrow">
                                <label>Email</label>
                            </div>
                            <span>*</span>
                            <input type="email" name="email" value="<?php echo $u_email; ?>">


                            <div class="blank-arrow">
                                <label>comment</label>
                            </div>
                            <span>*</span>
                            <textarea name="comment" rows="6" cols="95" class="d-block "></textarea>

                            <button class="btn btn-primary d-block " name="post_comment" href="">post comment</button>

                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
</section>

<?php
require_once("includes/footer.php");
?>


<script>
$(document).ready(function() {

    /* 1. Visualizing things on Hover - See next part for action on click */
    $('#ratings li').on('mouseover', function() {

        var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

        // Now highlight all the stars that's not after the current hovered star
        $(this).parent().children('li.star').each(function(e) {
            if (e < onStar) {
                $(this).addClass('hover');
            } else {
                $(this).removeClass('hover');
            }
        });

    }).on('mouseout', function() {
        $(this).parent().children('li.star').each(function(e) {
            $(this).removeClass('hover');
        });
    });


    /* 2. Action to perform on click */
    $('#ratings li').on('click', function() {
        if (!isUserAuthenticated()) {
            // Redirect to the login page
            window.location.href = "login.php";

        }

        var onStar = parseInt($(this).data('value'), 10); // The star currently selected
        var stars = $(this).parent().children('li.star');

        for (i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass('selected');
        }

        for (i = 0; i < onStar; i++) {
            $(stars[i]).addClass('selected');
        }

        // JUST RESPONSE (Not needed)
        var ratingValue = parseInt($('#ratings li.selected').last().data('value'), 10);
        var msg = "";
        if (ratingValue) {
            msg = ratingValue;
        }

        responseMessage(msg);

    });


    function isUserAuthenticated() {
        <?php $_SESSION['previous_page'] = $_SERVER['REQUEST_URI']; ?>

        return <?php echo Session::get('login') ? 'true' : 'false';



                    ?>;

    }


});


function responseMessage(msg) {
    $('.success-box').fadeIn(200);
    var inputText = $('.success-box #rating-input').val();
    var newText = inputText + msg;
    $('.success-box  #rating-input').val(newText);
    submitReview();



    function submitReview() {

        var post_id = $('.success-box #post_id').val();
        // var user_id = $('.success-box #user_id').val();
        // var reviewText = $('#review_text').val();
        var rating = $('.success-box #rating-input').val();

        $.ajax({
            url: 'submit_review.php',
            type: 'POST',
            data: {
                post_id: post_id,
                rating: rating
            },
            success: function(response) {
                console.log(response);
                var newText = "";
                $('.success-box  #rating-input').val(newText);
                // Handle success message or redirect
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                // Handle error message
            }
        });
    }

    //   $('.success-box div.text-message').html("<span>" + msg + "</span>");
}
</script>
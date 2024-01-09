<?php 


// for Body section 
$query2 = "SELECT *, posts.id as pid, categories.id as cid FROM posts
          INNER JOIN categories ON posts.category_id = categories.id WHERE posts.status = 1 ORDER BY posts.id DESC LIMIT 3";
$recent_posts = $db->select($query2);
$query_tags= "SELECT * FROM posts ";
$query_posts = $db->select($query_tags);


// <!-- get category --> 

$query = "SELECT *FROM categories
           ORDER BY id DESC LIMIT 6";
$categories = $db->select($query); 

 ?>


<div class="sidebar">
              <div class="row">
                <div class="col-lg-12">
                 
                </div>
                <div class="col-lg-12">
                  <div class="sidebar-item recent-posts">
                    <div class="sidebar-heading">
                    <h2 >احدث الاخبار</h2>
                    </div>
                    <div class="content">
                      <ul>
                         <?php 
                          if ($recent_posts) {
                
                          while($result2 = $recent_posts->fetch_assoc() ){  ?>



                        <li><a href="blog-single.php?slug=<?php echo $result2['slug'] ?>"><h4><?php echo $result2['title']; ?></h4>
                          <span>

                            <?php
                              $date=date_create($result2['created_at']);
                             echo date_format($date,"d M,Y");
                            ?>
                          </span>
                        </a></li>

                        <?php  } 
                           }
                         ?>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="sidebar-item categories">
                    <div class="sidebar-heading">
                      <h2>التصنيفات</h2>
                    </div>
                    <div class="content">
                      
                      <div class="row">
                        <?php
                      foreach ($categories as  $value) { ?>
                      <ul>
                        <div class="col-md-6">
                        <li><a href="category-post.php?cid=<?php echo base64_encode($value['id']) ?>&page=1">- <?php echo $value['name'] ?></a></li>
                        </div>
                        </ul>
                        <?php }
                         ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="sidebar-item tags">
                    <div class="sidebar-heading">
                      <h2>الكلمات الرئيسية</h2>
                    </div>
                    <div class="content">
                      <div class="row">
                      <?php 
                          if ($query_posts) {
                
                          while($result3 = $query_posts->fetch_assoc() ){  ?>


<?php 
                          $t=explode(",",$result3['tags']);
                          foreach ($t as $key ) {
                                                
                          ?>
                        <div class="col-md-4">
                        
                        <a href="search_tags.php?tag=<?php echo $key?>"class=" text-danger" style="background-color: #fff7;">
                        <?php echo "<span class='text-warning'  style='background-color: #fff7; '>" . $key."</span>" ; ?> </a>
                        </div>

                        <?php  }} 
                           }
                         ?>
                       
                      </div>

                       
                     
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
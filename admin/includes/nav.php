  <!-- Sidebar menu-->
  <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
  
<aside class="app-sidebar">
 

                                
      <div class="app-sidebar__user">
      <?php
      if (Session::get('admin_login')) { ?>
      <img class="app-sidebar__user-avatar" src="../admin/admin_images/<?php echo Session::get('photo'); ?>" alt="User Image">
        <div>
          <p class="app-sidebar__user-name"><?php echo Session::get('name'); ?></p>
          <p class="app-sidebar__user-designation"><?php echo Session::get('info'); ?></p>
        </div>
        <?php
      }else{
        ?>
        <img class="app-sidebar__user-avatar" src="../admin/admin_images/dummy.jpeg" alt="User Image">
        <div>
          <p class="app-sidebar__user-name">Admin Name</p>
          <p class="app-sidebar__user-designation">Admin Info</p>
        </div>
     <?php
      }
      ?>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item active" href="index.php"><i class="app-menu__icon bi bi-speedometer"></i><span class="app-menu__label">Dashboard</span></a></li>
       
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon bi bi-ui-checks"></i><span class="app-menu__label">Categories</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="add_category.php"><i class="icon bi bi-circle-fill"></i> Add Category</a></li>
            <li><a class="treeview-item" href="categories_list.php"><i class="icon bi bi-circle-fill"></i> All Categories</a></li>
          </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon bi bi-table"></i><span class="app-menu__label">Posts</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="add_post.php"><i class="icon bi bi-circle-fill"></i> Add Post</a></li>
            <li><a class="treeview-item" href="posts_list.php"><i class="icon bi bi-circle-fill"></i> All Posts</a></li>
          </ul>
        </li>
      
      </ul>
    </aside>
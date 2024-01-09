<?php
  include_once('./includes/header.php');

  include_once('./includes/nav.php');


$query = "SELECT * FROM categories ORDER BY id DESC";
$categories = $db->select($query);


// for delete category 
    if (isset($_GET['delId'])) {
        if (!Session::get('admin_login')) {

            echo "<script>window.open('login.php')</script>";
          } else {

        $id = $_GET['delId'];
        $d_query = $db->delete($id, 'categories');

       if ($d_query) {
        echo "<div class='alert alert-success' role='alert'>
          Category Delete Successfully
        </div>";

        ?>
        <script>
            setTimeout(function(){
                window.location.href = "categories_list.php";
            },2000);
        </script>
   <?php } else{
        echo "<div class='alert alert-danger' role='alert'>
          Category Delete Fail!
        </div>";
   }

        
    }
}

 ?>




          

    <div class="container-xxl flex-grow-1 container-p-y">
     <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> Posts</h4>


        <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="bi bi-table"></i> All Categories</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
          <li class="breadcrumb-item">Home</li>
          <li class="breadcrumb-item active"><a href="#">Categories</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="sampleTable">
                <thead>
                      <tr class="text-nowrap">
                      <th>#</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Create Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

                        <?php 
                            if ($categories) {
                                $i = 0;
                                while($result = $categories->fetch_assoc() ){ 
                                        $i++;
                                    ?>
                                    
                                    <tr>
                                        <th scope="row"><?php echo $i ?></th>
                                        <td><?php echo $result['name']; ?></td>
                                        <td>

                                            <?php 
                                                $status = $result['status'];
                                                if ($status == 1) { ?>
                                                    <span  class="badge bg-success">Active</span>
                                               <?php }else{ ?>
                                                    <span class="badge bg-danger">InActive</span>
                                               <?php }
                                             ?>
                                                
                                            </td>
                                        <td><?php echo $result['created_at']; ?></td>
                                        <td>
                                            <span  class="badge bg-info"><a href="edit_category.php?id=<?php echo $result['id'] ?>">Edit</a></span> ||

                                            <span  class="badge bg-danger"><a onClick=" return confirm('Are your sure you want to delete?')" href="?delId=<?php echo $result['id'] ?>">Delete</a></span>

                                        </td>
                                    </tr>

                             <?php   }
                                
                            }
                         ?>

                      
                      
                    </tbody>
                    
        
   
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
<?php include_once('./includes/footer.php') ?>
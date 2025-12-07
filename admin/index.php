<?php
session_start();
require "../config/config.php";
require "../config/common.php";



if(empty($_SESSION['user_id'])|| empty($_SESSION['logged_in'])){
  header("Location: login.php");



  
    if(!empty($_POST['search'])){
        setcookie('search', $_POST['search'], time() + (86400 * 30), "/"); // 86400 = 1 day
    }else{
     if(empty($_GET['pageno'])){
        unset($_COOKIE['search']);
        setcookie('search', null, -1, "/");
     }
    }
};
?>

<?php include "header.php"?>
    
    <!-- /.content-header -->

 <div class="content">

  <div class="container-fluid">
    <div class="row-md-12">
      <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"> Listing </h3>
              </div>
              <!-- /.card-header -->

              <div class="card-body">
                <div>
                <a href="add.php" type="button" class="btn btn-success">+</a>


              </div>
                <br>
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>                  
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>

                    
                  </tbody>
                  </table>
                </div>
                <br>

 


 

              <!-- /.card-body -->
             
            </div>
            <!-- /.card -->

            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    </div>
  </div>
 </div>

<?php  include("footer.html")?>
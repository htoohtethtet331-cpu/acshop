<?php
session_start();
require "../config/config.php";
require "../config/common.php";



if(empty($_SESSION['user_id'])|| empty($_SESSION['logged_in'])){
  header("Location: login.php");
}

if($_SESSION['role'] != 1 ){
   header("Location: login.php");
}

  
    if(!empty($_POST['search'])){
        setcookie('search', $_POST['search'], time() + (86400 * 30), "/"); // 86400 = 1 day
    }else{
     if(empty($_GET['pageno'])){
        unset($_COOKIE['search']);
        setcookie('search', null,-1,"/");
     }
    }

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
                <h3 class="card-title">Categories Listing </h3>
              </div>
              <!-- /.card-header -->
<?php 
              if(!empty($_GET['pageno'])){
                $pageno = $_GET['pageno'];
              }else{
                $pageno = 1;
              }
              $numberOfrec = 5;
              $offset = ($pageno - 1) * $numberOfrec;
              

if(empty($_POST['search']) && empty($_COOKIE['search'])){
  
               $stmt = $pdo->prepare("SELECT * FROM categories Order by id DESC");
               $stmt -> execute();
               $Rawresult = $stmt->fetchAll();
              $totalpages = ceil(count($Rawresult)/$numberOfrec);

              $stmt = $pdo->prepare("SELECT * From categories Order by id desc LIMIT $offset,$numberOfrec");
              $stmt->execute();
              $result = $stmt->fetchAll();
             
}else{
             $searchKey = isset($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];

               $stmt = $pdo->prepare("SELECT * FROM categories Where name like '%$searchKey%' Order by id DESC");
             
               $stmt -> execute();
               $Rawresult = $stmt->fetchAll();
              $totalpages = ceil(count($Rawresult)/$numberOfrec);

              $stmt = $pdo->prepare("SELECT * From categories WHERE name LIKE '%$searchKey%'  Order by id desc LIMIT $offset,$numberOfrec");
              $stmt->execute();
              $result = $stmt->fetchAll();
             
}
               ?>
              <div class="card-body">
                <div>
                <a href="cat_add.php" type="button" class="btn btn-success">add new categories</a>


              </div>
                <br>
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>                  
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>name</th>
                        <th>description</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>             <?php 
             $i=1;
             if($result){
              foreach ($result as $value) {
                ?>

                         <tr>
                        <td data-label="#"><?php echo $i;?></td>
                        <td data-label="Title"><?php echo escape ($value['name']) ?></td>
                        <td data-label="Content"><?php echo  escape(substr($value['description'],0,50)) ?></td>
                        <td data-label="Actions">
                          <div class="container">   
                            <div class="btn-group">          
                              <div class="container"> <a href="cat_edit.php?id=<?php echo $value['id'] ?>" type="button" class="btn btn-warning">Edit</a></div>
                              <div class="container" onclick = "return confirm(`Are you Sure to delete this description`)"> <a href="cat_delete.php?id=<?php echo $value['id'] ?>" type="button" class="btn btn-danger">Delete</a></div>
                            </div>
                          </div>     
                        </td>
                      </tr>
            <?php
            $i++;
             }
             }
             ?>

                    
                  </tbody>
                  </table>
                </div>
                <br>
                <nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="<?php echo '?pageno=1' ?>">First</a></li>

    <li class="page-item<?php if($pageno<=0){echo 'error';} ?>"><a class="page-link
    
    
    " href="<?php if($pageno > 1){echo'?pageno='.$pageno-1 ;}else{echo '#';}?>">previous</a></li>

    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno ?></a></li>

    <li class="page-item<?php if($pageno >= $totalpages){echo 'disabled';}?>"><a class="page-link" href="<?php if($pageno <  $totalpages  ){echo'?pageno='.$pageno+1 ;}else{echo '#';}?>">Next</a></li>

    <li class="page-item"><a class="page-link" href="?pageno=<?php echo $totalpages?>">Last</a></li>
  </ul>
</nav>

 


 

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
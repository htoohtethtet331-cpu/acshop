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
                <h3 class="card-title">Order Listings </h3>
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
              

  
               $stmt = $pdo->prepare("SELECT * FROM sale_orders Order by id DESC");
               $stmt -> execute();
               $Rawresult = $stmt->fetchAll();
              $totalpages = ceil(count($Rawresult)/$numberOfrec);

              $stmt = $pdo->prepare("SELECT * From sale_orders Order by id desc LIMIT $offset,$numberOfrec");
              $stmt->execute();
              $result = $stmt->fetchAll();
      
               ?>
              <div class="card-body">
                <div>
                <a href="cat_add.php" type="button" class="btn btn-success">add new Order</a>


              </div>
                <br>
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>                  
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>User</th>
                        <th>Total Price</th>
                        <th>Created At</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>             <?php 
             $i=1;
             if($result){
              foreach ($result as $value) {
                ?>
<?php
 $userstmt = $pdo->prepare("SELECT * From users WHERE id=".$value['user_id']);
              $userstmt->execute();
              $userResult = $userstmt->fetchAll();
?>
                         <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo escape ($userResult[0]['name']) ?></td>
                        <td><?php echo  escape ($value['total_price'])?></td>
                        <td><?php echo  escape(date('Y-m-d',strtotime($value['order_date']))) ?></td>
                        <td>
                          <div class="container">   
                            <div class="btn-group">          
                              <div class="container"> <a href="order_detail.php?id=<?php echo $value['id'] ?>" type="button" class="btn btn-warning">Detail</a></div>
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
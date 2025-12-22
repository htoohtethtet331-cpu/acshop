<?php 
session_start();
require "../config/config.php";
require "../config/common.php";

if(empty($_SESSION['user_id']) || empty($_SESSION['logged_in']) ){
    header("location: login.php");
}

if($_SESSION['role'] != 1 ){
   header("Location: login.php");
}
  
if($_POST){
    if(empty($_POST['name']) || empty($_POST['description'] )){
        if(empty($_POST['name'])){
    $nameError = "Categories name is require";
       };
   if(empty($_POST['description'])){
    $descError = "Description is required";
   };
}else{
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $stmt =$pdo->prepare("INSERT INTO categories (name,description) Values (:name,:description)");
    $result = $stmt->execute(
        [
            ':name'=>$_POST['name'],
            ':description' => $_POST['description']
          
        ]
        );
   if($result){
     echo "<script>alert('Successfully categories added');window.location.href='categories.php'</script>";
   }
}

}
?>
<?php include("header.php") ?>

 <div class="content">
  <div class="container-fluid">
    <div class="row-md-12">
      <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
           <form action="cat_add.php" method="post" enctype="multipart/form-data">
             
             <input type="hidden" name="_token" value="<?php  echo $_SESSION['_token']; ?>">
<div class="form-group">
    <label for="">Name</label><p style="color : red ;"><?php  echo empty($nameError) ? '' : $nameError ; ?></p>
    <input type="text" class='form-control' name="name" value ="">
</div>
<div class="form-group">
    <label for="">description</label><br><p style="color : red"><?php  echo empty($descError)  ? '' : $descError ; ?></p>
    <textarea cols='80' name='description' rows='8' ></textarea>
</div>
  
 <div class="form-group">
  <input type="submit"  value = "ADD" class='btn btn-success'>
  <a href="categories.php" class='btn btn-warning'>Back</a>
 </div>
           </form>
             </div>
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
<?php 
require "../config/config.php";
require "../config/common.php";

if(empty($_SESSION['user_id']) || empty($_SESSION['logged_in']) ){
    header("location: index.php");
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
    $id   =$_POST['id'];
    $stmt =$pdo->prepare("UPDATE  categories SET name=:name,description=:description WHERE id=:id");
    $result = $stmt->execute(
        [
            ':name'=>$name,
            ':description' => $desc,
            ':id'   => $id
          
        ]
        );
   if($result){
     echo "<script>alert('Successfully categories added');window.location.href='categories.php'</script>";
   }
}

}
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id=".$_GET['id']);
$stmt->execute();
$result = $stmt->fetchAll();

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
           <form action="" method="post" enctype="multipart/form-data">
             <input type="hidden" name="id" value="<?php echo $result[0]['id'] ?>">
             <input type="hidden" name="_token" value="<?php  echo escape($_SESSION['_token']); ?>">
<div class="form-group">
    <label for="">Name</label><p style="color : red ;"><?php  echo empty($nameError) ? '' : $nameError ; ?></p>
    <input type="text" class='form-control' name="name" value ="<?php echo $result[0]['name'] ?>">
</div>
<div class="form-group">
    <label for="">description</label><br><p style="color : red"><?php  echo empty($descError)  ? '' : $descError ; ?></p>
    <textarea cols='80' name='description' rows='8' ><?php echo escape($result[0]['description']) ?></textarea>
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
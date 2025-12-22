<?php 
session_start();
require "../config/config.php";
require "../config/common.php";

if(empty($_SESSION['user_id']) || empty($_SESSION['logged_in']) ){
    header("location: login.php");
}
  
if($_POST){
    if(empty($_POST['name']) || empty($_POST['description'] ) || empty($_POST['quantity'] )|| empty($_POST['price'] ) || empty($_FILES['image']) || empty($_POST['category'] )){
    if(empty($_POST['name'])){
    $nameError = "Product name is require";
       };
   if(empty($_POST['description'])){
    $descError = "Description is required";
   };
   if(empty($_POST['quantity'])){
    $quanErr = "quantity is required";
   }elseif((is_numeric($_POST['quantity'])) != 1){
    $quanErr = "Quantity should be integer";};
   if(empty($_POST['categoty'])){
    $catError = "categoty is required";
   };
   if(empty($_POST['price'])){
    $priceError = "Price is required";
   }elseif((is_numeric($_POST['price'])) != 1){
    $priceError = "Price should be integer";
     };
   if(empty($_FILES['image'])){
    $imageErr = "* image is required";
   };
   
}
else{
  if(is_numeric($_POST['price']) != 1){
    $priceError = "Price should be integer";
  };
  if(is_numeric($_POST['quantity']) != 1){
    $priceError = "Quantity should be integer";
  };
  if($quanErr == '' && $priceError == ''){

  if($_FILES['image']['name'] != null ){
      //valitations is success
       $file = 'image/'.($_FILES['image']['name']);
     $imageType = pathinfo($file, PATHINFO_EXTENSION);
    
  if($imageType != 'png' && $imageType != 'jpg'  && $imageType != 'jpeg'){
    echo "<script>alert('Image should png or jpg or jpeg ')</script>";

  }else{
 //image valitation success
 $name = $_POST['name'];
 $description = $_POST['description'];
 $category = $_POST['category'];
 $quantity = $_POST['quantity'];
 $price = $_POST['price'];
 $image = $_FILES['image']['name'];
 $id = $_POST['id'];

 move_uploaded_file($_FILES['image']['tmp_name'],$file);

  $stmt = $pdo->prepare("UPDATE products set name=:name,description=:description,category_id=:category,
  price=:price,quantity=:quantity,image=:image Where id=:id");
  $result = $stmt->execute(
    [
        ':name' => $name,
        ':description' => $description,
        ':category' => $category,
        ':quantity' => $quantity,
        ':price' => $price,
        ':image' => $image,
        ':id' => $id
    ]
    );
    if($result){
            echo "<script>alert('Product  is added');window.location.href='index.php'</script>";

    }
};
  }
else{
     $name = $_POST['name'];
 $description = $_POST['description'];
 $category = $_POST['category'];
 $quantity = $_POST['quantity'];
 $price = $_POST['price'];
 $id = $_POST['id'];

  $stmt = $pdo->prepare("UPDATE products set name=:name,description=:description,category_id=:category,
  price=:price,quantity=:quantity where id=:id");
  $result = $stmt->execute(
    [
        ':name' => $name,
        ':description' => $description,
        ':category' => $category,
        ':quantity' => $quantity,
        ':price' => $price,
        ':id' => $id
         
    ]
    );
    if($result){
            echo "<script>alert('Product  is added');window.location.href='index.php'</script>";

    }
}}}}
$stmt=$pdo->prepare("SELECT * FROM products WHERE id=".$_GET['id']);
$stmt->execute();
$get = $stmt->fetchAll();
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
             
             <input type="hidden" name="_token" value="<?php  echo $_SESSION['_token']; ?>">
             <input type="hidden" name="id" value="<?php echo $get[0]['id'] ?>">
<div class="form-group">
    <label for="">Name</label><p style="color : red ;"><?php  echo empty($nameError) ? '' : $nameError ; ?></p>
    <input type="text" class='form-control' name="name" value ="<?php echo escape($get[0]['name'] )?>">
</div>
<div class="form-group">
    <label for="">description</label><br><p style="color : red"><?php  echo empty($descError)  ? '' : $descError ; ?></p>
    <textarea cols='30' name='description' rows='8' ><?php echo escape($get[0]['description'] )?></textarea>
</div>
  
<?php
$catstmt =$pdo->prepare("SELECT * FROM categories");
$catstmt ->execute();
$catResult = $catstmt->fetchAll(); 
?>
<div class="form-group">
    <label for="">Category</label><br><p style="color : red"><?php  echo empty($catError)  ? '' : $catError ; ?></p>
    <select class="form-control" name="category" id="">
                <option value="">Select One</option>

        <?php
        if($catResult){
            foreach ($catResult as $value) {
         ?> 
        <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
       
        <?php 
            }
        }
        ?>
    </select>
</div>
<div class="form-group">
    <label for="">Quantity</label><p style="color : red ;"><?php  echo empty($quanErr) ? '' : $quanErr ; ?></p>
    <input type="text" class='form-control' name="quantity" value ="<?php echo escape($get[0]['quantity'] )?>">
</div>
  
<div class="form-group">
    <label for="">Price</label><p style="color : red ;"><?php  echo empty($priceError) ? '' : $priceError ; ?></p>
    <input type="text" class='form-control' name="price" value ="<?php echo escape($get[0]['price'] )?>">
</div>
<div class="form-group">
    <label for="">Image</label><p style="color : red ;">
        <input type="file" name="image" value="<?php echo escape($get[0]['image'] )?>">
    <p style="color : red ;"><?php  echo empty($imageErr) ? '' : $imageErr ; ?></p>
    <img src="image/<?php echo escape($get[0]['image']) ?>" width="150" height="150" alt="product image">

</div>

 <div class="form-group">
  <input type="submit"  value = "Edit" class='btn btn-success'>
  <a href="index.php" class='btn btn-warning'>Back</a>
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
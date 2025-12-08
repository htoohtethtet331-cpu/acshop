<?php 
session_start();
require "../config/config.php";
require "../config/common.php";


if(empty($_SESSION['user_id']) ||  empty($_SESSION['logged_in'])){
  header("Location: login.php");
  exit();
};

if($_POST){
      if(empty($_POST['title']) || empty($_POST['content']) || empty($_FILES['image'])){
      if(empty($_POST['title'])){
     $titleError = "title cannot be null";
}
if(empty($_POST['content'])){
  $contentError = "content cannot be null";
}
if(empty($_FILES['image'])){
  $imageError = "image cannot be null";
}
  }else{   
            $file = 'image/'.($_FILES['image']['name']);
        $imagetype = pathinfo($file, PATHINFO_EXTENSION);

        // ဓာတ်ပုံ type စစ်ဆေးခြင်း
        if($imagetype != 'png' && $imagetype != 'jpg' && $imagetype != 'jpeg'){
            echo "<script>alert('ဓာတ်ပုံသည် png, jpeg (သို့) jpg ဖြစ်ရပါမည်')</script>";
        } else {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $image = $_FILES['image']['name'];

            // ဓာတ်ပုံကို folder ထဲသို့ ကူးယူခြင်း
            move_uploaded_file($_FILES['image']['tmp_name'], $file);

            $stmt = $pdo->prepare("INSERT INTO posts(title,content,image,author_id) VALUES (:title,:content,:image,:author_id)");
            $result = $stmt->execute(
                array(':title'=>$title, ':content'=>$content, ':image'=>$image, ':author_id'=>$_SESSION['user_id'])
            );
            if($result){
                  echo "<script>alert('အောင်မြင်စွာထည့်သွင်းပြီးပါပြီ'); window.location.href='index.php';</script>";
              
            } else {
                echo "<script>alert('မအောင်မြင်ပါ')</script>";
            }
        }
    }
    
    
  
}

// Form ပို့မှ submit ဖြစ်မယ်
    
    // ဓာတ်ပုံရွေးထားမှသာ ဆက်လုပ်မယ်

  
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
           <form action="add.php" method="post" enctype="multipart/form-data">
             <input type="hidden" name="_token" value="<?php  echo $_SESSION['_token']; ?>">
<div class="form-group">
    <label for="">Title</label><p style="color : red ;"><?php  echo empty($titleError) ? '' : $titleError ; ?></p>
    <input type="text" class='form-control' name="title" value ="">
</div>
<div class="form-group">
    <label for="">Content</label><br><p style="color : red"><?php  echo empty($contentError)  ? '' : $contentError ; ?></p>
    <textarea cols='80' name='content' rows='8' ></textarea>
</div>
<div class="form-group">
    <label for="">Image</label><p style="color : red"><?php  echo empty($imageError) ? '' : $imageError ; ?></p>
    <input type="file" name='image' value=''>
</div>      
 <div class="form-group">
  <input type="submit" name='' value = "ADD" class='btn btn-success'>
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
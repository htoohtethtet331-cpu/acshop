<?php
session_start();
require '../config/config.php';
require '../config/common.php';
if(empty($_SESSION['user_id']) || empty($_SESSION['logged_in'])){
  header("Location: login.php");
  exit();
}
if($_SESSION['role'] != 1) {
  header("Location: login.php");
  exit();
};
if($_POST){
    if (empty($_POST['name']) || empty($_POST['email'])){
    if (empty($_POST['name'])) {
      $nameError = 'name cannot be null';
    }
    if (empty($_POST['email'])) {
      $emailError = 'email cannot be null';
    }
    }elseif(!empty($_POST['password']) && strlen($_POST['password']) < 4){
                       $passwordError = 'Password was be more than 4 character';

    }
  else{
    $name = $_POST['name'];
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $role = $_POST['role'];
    $id = $_POST['id'];
    
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email AND id!=:id");
    $stmt->execute(array(':email'=>$email,':id'=>$id));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
   if($user){
    echo "<script>alert('This email is already used by another user');</script>";
   }else{
    if($password != null){
        
        $stmt=$pdo->prepare("UPDATE  users SET name='$name',email='$email',password='$password',role='$role' WHERE id='$id'");
    }else{

        $stmt=$pdo->prepare("UPDATE  users SET name='$name',email='$email',role='$role' WHERE id='$id'");
    }
    $result = $stmt->execute();
    if($result){
    echo "<script>alert('user is successfully add');window.location.href='user_list.php';</script>";
    }
}}}

  $stmt = $pdo->prepare("SELECT * FROM users WHERE id=".$_GET['id']);
    $stmt->execute();
    $result = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fb;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            font-size: 1.8rem;
            color: #343a40;
        }
        
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background-color: #4a6fa5;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #3a5a8a;
        }
        
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        
        .btn-warning {
            background-color: #ffc28cff;
            color: #343a40;
        }
        
        .btn-sm {
            padding: 5px 10px;
            font-size: 0.8rem;
        }
        
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            overflow: hidden;
        }
        
        .card-header {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #343a40;
        }
        
        .card-body {
            padding: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #343a40;
        }
        
        tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }
        
        .status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status-active {
            background-color: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }
        
        .status-inactive {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
        
        .actions {
            display: flex;
            gap: 8px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #4a6fa5;
            box-shadow: 0 0 0 2px rgba(74, 111, 165, 0.2);
        }
        
        .search-box {
            width: 250px;
        }
        
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .header-actions {
                margin-top: 10px;
                width: 100%;
            }
            
            .search-box {
                width: 100%;
            }
            
            .table-container {
                overflow-x: auto;
            }
        }
    </style>
<body>
     <div class="card">
            <div class="card-header">
                <h2 class="card-title">Add New User</h2>
            </div>
            <div class="card-body">
                <form action="" method="post">
              <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">

                <input type="hidden" value='<?php echo $result[0]['id'] ?>' name='id'>

                <div class="form-group">
                        <label for="username">Username</label><p style="color : red"><?php echo empty($nameError) ? '' :'*'.$nameError; ?></p>
                        <input type="text" value="<?php echo $result[0]['name'] ?>" name="name" id="username" class="form-control"  placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label><p style="color : red"><?php echo empty($emailError) ? '' :'*'.$emailError; ?></p>
                        <input name="email" type="email" id="email" value="<?php echo $result[0]['email'] ?>"  class="form-control"  placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label><p style="color : red"><?php echo empty($passwordError) ? '' :'*'.$passwordError; ?></p>
                        <input name="password" type="password" id="password"  class="form-control"  placeholder="this user have already password">
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select id="role" name="role" class="form-control">
                            <option value="0">Users</option>
                            <option value="1">Administrator</option>
                        </select>
                    </div>
                  

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Save User</button>
                        <a type="button" class='btn btn-warning' href="user_list.php">BACK</a>
                    </div>
                </form>
            </div>
        </div>

</body>
</html>
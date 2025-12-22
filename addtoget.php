<?php

session_start();
require "config/config.php";
if($_POST){
    $id = $_POST['id'];
    $qty = $_POST['qty'];

    	$stmt=$pdo->prepare("SELECT * FROM products where id=".$id);
	$stmt->execute();
	$detail = $stmt->fetch(PDO::FETCH_ASSOC);
	
    if($qty > $detail['quantity']){
        echo "<script>alert('Not enought Stock');window.location.href='product_detail.php?id=$id';</script>";
        
    }else{

if(isset($_SESSION['cart']['id'.$id])){
    $_SESSION['cart']['id'.$id] +=$qty ;
}else{
    $_SESSION['cart']['id'.$id] = $qty; 
}
header("Location: cart.php?id=");
}}

?>
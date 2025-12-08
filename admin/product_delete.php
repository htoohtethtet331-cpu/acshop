<?php
require "../config/config.php";

$stmt=$pdo->prepare("DELETE FROM products where id=".$_GET['id']);

$stmt->execute();
header('location: categories.php');
?>
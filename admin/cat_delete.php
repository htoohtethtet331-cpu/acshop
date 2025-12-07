<?php
require "../config/config.php";

$stmt=$pdo->prepare("DELETE FROM categories where id=".$_GET['id']);

$stmt->execute();
header('location: categories.php');
?>
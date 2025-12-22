<?php
session_start();
require "config/config.php";
require "config/common.php";


if(empty($_SESSION['user_id']) || empty($_SESSION['logged_in'])){
	
	header("location: login.php");
	exit();
}
?>

<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon-->
	<link rel="shortcut icon" href="img/fav.png">
	<!-- Author Meta -->
	<meta name="author" content="CodePixar">
	<!-- Meta Description -->
	<meta name="description" content="">
	<!-- Meta Keyword -->
	<meta name="keywords" content="">
	<!-- meta character set -->
	<meta charset="UTF-8">
	<!-- Site Title -->
	<title>A Coder Shop</title>

	<!--
            CSS
            ============================================= -->
	<link rel="stylesheet" href="css/linearicons.css">
	<link rel="stylesheet" href="css/owl.carousel.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/themify-icons.css">
	<link rel="stylesheet" href="css/nice-select.css">
	<link rel="stylesheet" href="css/nouislider.min.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/main.css">
</head>

<body id="category">

	<!-- Start Header Area -->
	<header class="header_area sticky-header">
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light main_box">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<a class="navbar-brand logo_h" href="index.php"><h4><img src="admin/image/image.png" style="padding : 10px" Weight="100" height="90"><h4></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
						<ul class="nav navbar-nav navbar-right">
							<?php 
							$cart = 0 ;
							if(isset($_SESSION['cart']))
								{
									foreach ($_SESSION['cart'] as $key => $qty) {
										$cart += $qty;
									}}?>

							<li class="nav-item"><a href="cart.php" class="cart"><span class="ti-bag"></span><?php echo $cart ?></a></li>
							
							
							<li class="nav-item">
								<button class="search"><span class="lnr lnr-magnifier" id="search"></span></button>
							</li>
							<style>
								.sign{
									margin-top : 25px
									
								}
							</style>
							<li class="nav-item">
								<div class="sign"><a href="logout.php" class="sign-out"><i class="fa fa-sign-out" aria-hidden="true"></i></a></div>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
		<div class="search_input" id="search_input_box">
			<div class="container">
				<form action="index.php" method="post" class="d-flex justify-content-between">
					<input type="text" name="search" class="form-control" id="search_input" placeholder="Search Here">
					<input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
					<button type="submit" class="btn"></button>
					<span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
				</form>
			</div>
		</div>
	</header>
	<!-- End Header Area -->

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Welcome <?php 
						echo escape($_SESSION['user_name'])
				?> </h1>

				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

			

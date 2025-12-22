<?php 
session_start();
require "config/config.php";
require "config/common.php";
if($_POST){
		if(empty($_POST['email']) || empty($_POST['password']) || empty($_POST['name'])
			 || empty($_POST['address']) || empty($_POST['phone']) || strlen($_POST['password']) < 4 ){
			if(empty($_POST['name'])){
				$nameErr = "Name is required";
			}
			if(empty($_POST['email'])){
				$emailErr = "Email is required";
			}
			if(empty($_POST['password'])){
				$passwordErr = "Password is required";
			}
			if(empty($_POST['address'])){
				$addressErr = "Address is required";
			}
			if(empty($_POST['phone'])){
				$phoneErr = "Phone is required";
			}
			if(strlen($_POST['password']) < 4 ){
			$passwordErr = "Password will be more than 4 ";}
		}elseif(
		(is_numeric($_POST['phone'])) != 1 ){
			$phoneErr = "Phone number will be number";
		  }
		
			
		

		else{
			
 	$name = $_POST['name'];
	$email = $_POST['email'];
	$password =$_POST['password'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];

	$stmt=$pdo->prepare("SELECT * FROM users WHERE email=:email");
	$stmt->execute(
		[
			':email' => $email
		]
		);
   $user =	$stmt->fetch(PDO::FETCH_ASSOC);
   if($user){
	echo "<script>alert('this email of user is already have')</script>";	
}else{
	
	$stmt=$pdo->prepare("INSERT INTO users (email,password,name,address,phone) Values (:email,:password,:name,:address,:phone) ");
	$result=$stmt->execute(
		[
			':email' => $email,
			':password'=> password_hash($password,PASSWORD_DEFAULT),
			':name'=> $name,
			':address' => $address,
			':phone' => $phone,
			]
		);
		if($result){
			echo "<script>alert('Successfully registed ');window.location.href='login.php'</script>";
			
		}else{
			echo "<script>alert('Registation is fail');</script>";
		}
	}
	   
	
   }
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
	<title>A Coder Shop | register</title>

	<!--
		CSS
		============================================= -->
	<link rel="stylesheet" href="css/linearicons.css">
	<link rel="stylesheet" href="css/owl.carousel.css">
	<link rel="stylesheet" href="css/themify-icons.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/nice-select.css">
	<link rel="stylesheet" href="css/nouislider.min.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/main.css">
</head>
<style>
    .login_box_img{
        animation: animate 2s ease ;
        z-index: 11;

    }
    @keyframes animate {
        	0%{
			transform :translateX(500px)
		}
		100%{
			transform :translateX(0)

		}
        
    }
</style>

<body>

	<!-- Start Header Area -->
	<header class="header_area sticky-header">
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light main_box">
					<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<a class="navbar-brand logo_h" href="index.html"><h4>AP Shopping<h4></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
						
					</div>
				</div>
			</nav>
		</div>
		<div class="search_input" id="search_input_box">
			<div class="container">
				<form class="d-flex justify-content-between">
					<input type="text" class="form-control" id="search_input" placeholder="Search Here">
					<button type="submit" class="btn"></button>
					<span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
				</form>
			</div>
		</div>
	</header>
	<!-- End Header Area -->

	<!-- Start Banner Area -->
	
	<!-- End Banner Area -->

	<!--================Login Box Area =================-->
	<section class="login_box_area section_gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="login_box_img">
						<img class="img-fluid" src="img/login.jpg" alt="">
						<div class="hover">
							<h4>New to our website?</h4>
							<p>There are advances being made in science and technology everyday, and a good example of this is the</p>
							<a class="primary-btn" href="login.php">Aready Had an Account?</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="login_form_inner">
						<h3>Register to use  Our Shopping </h3>
						<form class="row login_form" action="register.php" method="post" id="contactForm" novalidate="novalidate">
							<input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?>"  >
						<div class="col-md-12 form-group">
								<input  style="<?php echo empty($nameErr) ? '' : 'border: 1px solid red ;' ?>"type="text" class="form-control" id="name" name="name" placeholder="<?php echo empty($nameErr) ? 'Name' : $nameErr ?>" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'">
							</div> 
							<div class="col-md-12 form-group">
								<input style="<?php echo empty($emailErr) ? '' : 'border: 1px solid red ;' ?>"type="email" class="form-control" id="name" name="email" placeholder="<?php echo empty($emailErr) ? 'Email' : $emailErr ?>" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'">
							</div>
							<div class="col-md-12 form-group">
								<input style="<?php echo empty($phoneErr) ? '' : 'border: 1px solid red ;' ?>" type="number" class="form-control" id="name" name="phone" placeholder="<?php echo empty($phoneErr) ? 'Phone' : $phoneErr ?>" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Phone'">
							</div>
							<div class="col-md-12 form-group">
								<input style="<?php echo empty($addressErr) ? '' : 'border: 1px solid red ;' ?>" type="text" class="form-control" id="name" name="address" placeholder="<?php echo empty($addressErr) ? 'Address' : $addressErr ?>" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Address'">
							</div>
							<div class="col-md-12 form-group">
								<input type="password" class="form-control" style="<?php echo empty($passwordErr) ? '' : 'border: 1px solid red ;' ?>" id="name" name="password" placeholder="<?php echo empty($passwordErr) ? 'Password' : $passwordErr ?>" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
							</div>
							
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" class="primary-btn">Register</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End Login Box Area =================-->

	<!-- start footer Area -->
	<footer class="footer-area section_gap">
	  <!-- Control Sidebar -->
 <div class="container">
	<div class="footer-bottom d-flex justify-content-center align-items-center flex-wrap">
		<p class="footer-text m-0">
			Copyright &copy; <script>
				document.write(new Date().getFullYear());
			</script>
			All right reserved with Kelvin Ban
		</p>
</div>
 </div>
	</footer>
	<!-- End footer Area -->


	<script src="js/vendor/jquery-2.2.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
	 crossorigin="anonymous"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="js/jquery.ajaxchimp.min.js"></script>
	<script src="js/jquery.nice-select.min.js"></script>
	<script src="js/jquery.sticky.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<!--gmaps Js-->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
	<script src="js/gmaps.min.js"></script>
	<script src="js/main.js"></script>
</body>

</html>
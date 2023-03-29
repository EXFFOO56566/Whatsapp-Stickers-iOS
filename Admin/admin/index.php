<?php

	/* Include Data Controller file content */
	require_once('controller/dataController.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>WA Sticker</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="img/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/css/extra.css">
<!--===============================================================================================-->

</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('assets/img/bg-01.jpg');">
			
			<div id="form-loader" class="loader-div">
				<img class="login-loader-image" src="assets/img/processing.gif">
			</div>		
			
			<div class="wrap-login100">
			
				<div class="login100-form validate-form">
					
					<!--============ Warning Alert Box ============-->
					<div class="alert alert-danger" id="faild" style='display:none;'>
						<span class="entypo-attention"></span>
						<strong>!</strong>&nbsp;&nbsp;Invalid Credential .
					</div>
					<div class="alert alert-danger" id="warning"  style='display:none;'>
						<span class="entypo-attention"></span>
						<strong>!</strong>&nbsp;&nbsp;Please fill all the field.
					</div>
					
					<span class="login100-form-logo">
						<i class="zmdi zmdi-landscape"></i>
					</span>

					<span class="login100-form-title p-b-34 p-t-27">
						Log in
					</span>
					</br>
					<div class="wrap-input100 validate-input" data-validate = "Enter email">
						<input class="input100" type="text" id="admin_email" name="admin_email" placeholder="Email">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" id="admin_password" name="admin_password" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" onClick="adminLogin();">
							Login
						</button>
					</div>
					</br>
					<div class="text-center p-t-90">
						<a class="txt1" href="#">
							Forgot Password?
						</a>
					</div>
										
				</div>
			</div>
		</div>
	</div>
	
<!--===============================================================================================-->
	<script src="assets/js/jquery.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/js/custom.js"></script>

</body>
</html>
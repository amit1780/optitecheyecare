<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Welcome to optitecheyecare</title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">

	<!-- css -->
	
    <link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/css/login.css" rel="stylesheet">
	
	
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>

<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->
	
		<?php if (validation_errors()) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?php echo validation_errors(); ?>
				</div>
			</div>
		<?php endif; ?>
		<?php if (isset($error)) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?php echo $error; ?>
				</div>
			</div>
		<?php endif; ?>
	

    <!-- Icon -->
    <div class="fadeIn first">
      <!-- <img src="https://www.b-cube.in/wp-content/uploads/2014/05/aditya-300x177.jpg" id="icon" alt="User Icon" /> -->
      <h1>Login</h1>
    </div>

    <!-- Login Form -->
   <form role="form" method="post" action="<?php echo site_url('login');?>">
      <input type="text" id="username" class="fadeIn second" name="username" placeholder="username">
      <input type="password" id="password" class="fadeIn third" name="password" placeholder="password">
      <input type="submit" class="fadeIn fourth" value="Log In">
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
     <!-- <a class="underlineHover" href="#">Copyright © optitecheyecare &nbsp;| &nbsp; d <a href="http://www.softvisionindia.com/">SoftvisionIndia </a></a> -->
    </div>

  </div>
</div>

</body>
</html>
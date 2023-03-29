<?php
	
	//inculde dataController file content
	require_once('controller/dataController.php');
	
	$current_file_name = basename($_SERVER['PHP_SELF']);

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>WA Sticker</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Bootstrap Table core CSS    -->
    <link href="assets/css/bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />
   
    <!--  CSS for addional effect     -->
	<link href="assets/css/extra.css" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="assets/img/sidebar-5.jpg">

    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="http://www.loopinfosol.com" class="simple-text">
                    WA Sticker
                </a>
            </div>

            <ul class="nav">
                <li class="<?php if($current_file_name == 'dashboard.php') echo 'active';?>">
                    <a href="dashboard.php">
                        <i class="pe-7s-graph"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
				<hr>
                <li class="<?php if($current_file_name == 'addSlider.php') echo 'active';?>">
                    <a href="addSlider.php">
                        <i class="pe-7s-science"></i>
                        <p>Add Slider</p>
                    </a>
                </li>
                <li class="<?php if($current_file_name == 'listSlider.php') echo 'active';?>">
                    <a href="listSlider.php">
                        <i class="pe-7s-note2"></i>
                        <p>List Slider</p>
                    </a>
                </li>
				<hr>
                <li class="<?php if($current_file_name == 'addCategory.php') echo 'active';?>">
                    <a href="addCategory.php">
                        <i class="pe-7s-science"></i>
                        <p>Add Category</p>
                    </a>
                </li>
                <li class="<?php if($current_file_name == 'listCategory.php') echo 'active';?>">
                    <a href="listCategory.php">
                        <i class="pe-7s-note2"></i>
                        <p>List Category</p>
                    </a>
                </li>
				<hr>
                <li class="<?php if($current_file_name == 'addSubCategory.php') echo 'active';?>">
                    <a href="addSubCategory.php">
                        <i class="pe-7s-science"></i>
                        <p>Add SubCategory</p>
                    </a>
                </li>
				<li class="<?php if($current_file_name == 'listSubCategory.php') echo 'active';?>">
                    <a href="listSubCategory.php">
                        <i class="pe-7s-note2"></i>
                        <p>List SubCategory</p>
                    </a>
                </li>
				<hr>
				<!--<li>
                    <a href="addPngSticker.php">
                        <i class="pe-7s-science"></i>
                        <p>Add PNG Sticker</p>
                    </a>
                </li>
				<li>
                    <a href="listPngSticker.php">
                        <i class="pe-7s-note2"></i>
                        <p>List PNG Sticker</p>
                    </a>
                </li>
				<hr>-->
				<li class="<?php if($current_file_name == 'addWebpSticker.php') echo 'active';?>">
                    <a href="addWebpSticker.php">
                        <i class="pe-7s-science"></i>
                        <p>Add Webp Sticker</p>
                    </a>
                </li>
				<li class="<?php if($current_file_name == 'listWebpSticker.php') echo 'active';?>">
                    <a href="listWebpSticker.php">
                        <i class="pe-7s-note2"></i>
                        <p>List Webp Sticker</p>
                    </a>
                </li>
				<li class="<?php if($current_file_name == 'addAnimatedSticker.php') echo 'active';?>">
                    <a href="addAnimatedSticker.php">
                        <i class="pe-7s-science"></i>
                        <p>Add Animated Sticker</p>
                    </a>
                </li>
				<li class="<?php if($current_file_name == 'listAnimatedSticker.php') echo 'active';?>">
                    <a href="listAnimatedSticker.php">
                        <i class="pe-7s-note2"></i>
                        <p>List Animated Sticker</p>
                    </a>
                </li>
            </ul>
    	</div>
	</div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
					
					<!-- Here is the URL Link for Dashboard page redirect -->
                    <a class="navbar-brand" href="dashboard.php">Dashboard</a>
                </div>
                <div class="collapse navbar-collapse">
                   
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <p>
										Account
										<b class="caret"></b>
									</p>

                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="changePassword.php">Change Password</a></li>
                              </ul>
                        </li>
                        <li>
                            <a href="logout.php" class="logout-btn">
                                <p>Log out</p>
                            </a>
                        </li>
						<li class="separator hidden-lg"></li>
                    </ul>
                </div>
            </div>
        </nav>


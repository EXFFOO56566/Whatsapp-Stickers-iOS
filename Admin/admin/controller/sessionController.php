<?php

session_start();

if(basename($_SERVER['PHP_SELF']) != "index.php" && basename($_SERVER['PHP_SELF']) != "loginController.php")
	{
		if(empty($_SESSION['cs_sticker_admin_email']))
		{
			header('Location:index.php');
		}
	}
else
	{
		if(!empty($_SESSION['cs_sticker_admin_email']))
		{
			header('Location:dashboard.php');
		}
	}

?>
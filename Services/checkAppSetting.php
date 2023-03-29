<?php

include ('commonClass/responseClass.php');
include ('commonClass/commonVariable.php');

$app_version = empty($_POST["app_version"])?"":$_POST["app_version"];

if($version_check == 'YES' && $app_version != $current_version)
{
	// return response in json formate
	return ResponseClass::ResponseMessage("4","You are using old version of an app. Please update the app now!","False");
}
else
{
	// return response in json formate
	return ResponseClass::ResponseMessage("1","You are using updated version of an app","True");
}

?>
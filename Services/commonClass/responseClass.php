<?php
error_reporting(E_ALL ^ E_DEPRECATED);
//Create Connection Class
class ResponseClass
{	
	public static function successResponseInArray($keyName, $array, $res ,$responseMessage,$result)
	{	
		echo json_encode(array("$keyName"=>$array,"ResponseCode"=>"$res","ResponseMsg"=> "$responseMessage","Result"=>"$result","ServerTimeZone"=>date('T')));
	}	
	public static function successResponseInArraytwo($keyName, $array,$keyName1, $array1, $res ,$responseMessage,$result)
	{		
		echo json_encode(array("$keyName"=>$array,"$keyName1"=>$array1,"ResponseCode"=>"$res","ResponseMsg"=> "$responseMessage","Result"=>"$result","ServerTimeZone"=>date('T')));
	}
	public static function successResponseInArraythree($keyName, $array,$keyName1, $array1,$keyName2, $array2, $res ,$responseMessage,$result)
	{		
		echo json_encode(array("$keyName"=>$array,"$keyName1"=>$array1,"$keyName2"=>$array2,"ResponseCode"=>"$res","ResponseMsg"=> "$responseMessage","Result"=>"$result","ServerTimeZone"=>date('T')));
	}
	public static function ResponseMessage($res,$responseMessage,$result)
	{
		echo json_encode(array("ResponseCode"=>"$res","ResponseMsg"=> "$responseMessage","Result"=>"$result","ServerTimeZone"=>date('T')));
	}
}

	
<?php

	include('controller/dataController.php'); 
	
	@$user_id = empty($_REQUEST["user_id"])?"":$_REQUEST["user_id"];
	
	if(!empty($user_id))
	{
		$tray_list = array();
		
		$get_tray_result = $data_obj->get_active_sub_category();
		$get_tray_count = mysqli_num_rows($get_tray_result);
		if($get_tray_count > 0)
		{
			while($tray_row = mysqli_fetch_assoc($get_tray_result))
			{
				$tray['sub_cate_id'] = $tray_row['id'];
				$tray['sub_cate_tray_image'] = $link_subcategory_tray_path.$tray_row['sub_cate_tray_image'];
				
				$tray_list[] = $tray;
			}
			
			return ResponseClass::successResponseInArray("data",$tray_list,"1","data retrive successfully.","True");
		}
		else
		{
			return ResponseClass::ResponseMessage("2","Did not found any record!.","False");
		}
	}
	else
	{
		return ResponseClass::ResponseMessage("2","Missing detail!.","False");
	}		

?>

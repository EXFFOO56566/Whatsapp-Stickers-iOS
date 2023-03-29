<?php

	include('controller/dataController.php'); 

	@$category_id = empty($_REQUEST["category_id"])?"":$_REQUEST["category_id"];
	@$device_type = empty($_REQUEST["device_type"])?"":$_REQUEST["device_type"];
	
	if(!empty($category_id))
	{
		$get_sub_cate_result = $data_obj->get_active_sub_cate_by_id($category_id);
		$get_sub_cate_count = mysqli_num_rows($get_sub_cate_result);
		if($get_sub_cate_count > 0)
		{
			$sub_cate_list = array();
		
			while($sub_cate_row = mysqli_fetch_assoc($get_sub_cate_result))
			{
				$sub_cate_id = $sub_cate_row['id'];
				$sub_cate['sub_cate_id'] = $sub_cate_row['id'];
				$sub_cate['sub_cate_name'] = $sub_cate_row['sub_cate_name'];
				$sub_cate['is_animated'] = $sub_cate_row['is_animated'];
				$sub_cate['sub_cate_image'] = $link_subcategory_path.$sub_cate_row['sub_cate_image'];
				$sub_cate['sub_cate_tray_image'] = $link_subcategory_tray_path.$sub_cate_row['sub_cate_tray_image'];
				
				$is_animated = $sub_cate_row['is_animated'];
				
				if($is_animated == 'YES')
				{
					$get_sticker_result = $data_obj->get_animated_sticker_by_sub_cate_id($sub_cate_id);
				}
				else
				{
					$get_sticker_result = $data_obj->get_webp_sticker_by_sub_cate_id($sub_cate_id);
				}
				
				$sub_cate['sticker_count'] = mysqli_num_rows($get_sticker_result);
				
				$sub_cate_list[] = $sub_cate;
			}
			
			$data['sub_cate_list'] = $sub_cate_list;
			
			return ResponseClass::successResponseInArray("data",$data,"1","data retrive successfully.","True");
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

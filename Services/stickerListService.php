<?php

	include('controller/dataController.php'); 

	$sub_cate_id = empty($_POST["sub_cate_id"])?"":$_POST["sub_cate_id"];
	$is_animated = empty($_POST["is_animated"])?"":$_POST["is_animated"];
	
	if(!empty($sub_cate_id))
	{		
		if($is_animated == 'YES')
		{
			$get_sticker_result = $data_obj->get_animated_sticker_by_sub_cate_id($sub_cate_id);	
			$link_sticker_path = $link_sticker_animated_path;
		}
		else
		{
			$get_sticker_result = $data_obj->get_webp_sticker_by_sub_cate_id($sub_cate_id);
			$link_sticker_path = $link_sticker_webp_path;
		}	
		
		$data = array();
		
		$get_sticker_count = mysqli_num_rows($get_sticker_result);
		if($get_sticker_count > 0)
		{
			$sticker_list = array();
		
			while($sticker_row = mysqli_fetch_assoc($get_sticker_result))
			{
				$sticker['sub_cate_id'] = $sticker_row['sub_cate_id'];
				$sticker['sticker_id'] = $sticker_row['id'];
				$sticker['sticker_image'] = $link_sticker_path.$sticker_row['sticker_image'];
				
				$sticker_list[] = $sticker;
			}
			
			$data['sticker_list'] = $sticker_list;
			
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

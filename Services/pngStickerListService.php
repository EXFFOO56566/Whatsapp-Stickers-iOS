<?php

	include('controller/dataController.php'); 

	//$print_r($_REQUEST);die;
	
	@$sub_cate_id = empty($_REQUEST["sub_cate_id"])?"":$_REQUEST["sub_cate_id"];
	
	//return ResponseClass::ResponseMessage("1",$_REQUEST,"True");
	
	if(!empty($sub_cate_id))
	{
		$sticker_list = array();
		
		$get_sticker_result = $data_obj->get_png_sticker_by_sub_cate_id($sub_cate_id);
		$get_sticker_count = mysqli_num_rows($get_sticker_result);
		if($get_sticker_count > 0)
		{
			while($sticker_row = mysqli_fetch_assoc($get_sticker_result))
			{
				$sticker['sub_cate_id'] = $sticker_row['sub_cate_id'];
				$sticker['sticker_id'] = $sticker_row['id'];
				$sticker['sticker_image'] = $link_sticker_png_path.$sticker_row['sticker_image'];
				
				$sticker_list[] = $sticker;
			}
			
			return ResponseClass::successResponseInArray("data",$sticker_list,"1","data retrive successfully.","True");
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

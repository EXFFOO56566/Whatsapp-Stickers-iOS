<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	include('controller/dataController.php'); 

	$slider_data = array();
	$get_slider_result = $data_obj->get_active_slider();
	$get_slider_count = mysqli_num_rows($get_slider_result);
	if($get_slider_count > 0)
	{
		while($slider_row = mysqli_fetch_assoc($get_slider_result))
		{
			$slider['category_id'] = $slider_row['category_id'];
			$slider['slider_id'] = $slider_row['id'];
			$slider['slider_name'] = $slider_row['slider_name'];
			$slider['slider_image'] = $link_slider_path.$slider_row['slider_image'];
			
			$slider_data[] = $slider;
		}
	}
	$category = array();
	$category_list = array();
	$get_arrived_result = $data_obj->get_active_just_arrived_sub_category();
	$get_arrived_count = mysqli_num_rows($get_arrived_result);
	if($get_arrived_count > 0)
	{
		$category['view_all'] = 'NO';
		$category['category_id'] = '';
		$category['category_image'] = '';
		$category['category_name'] = 'Just Arrived';
		
		$sub_cate_data = array();
		while($arrived_row = mysqli_fetch_assoc($get_arrived_result))
		{			
			$arrived['category_id'] = $arrived_row['category_id'];
			$arrived['sub_cate_id'] = $arrived_row['id'];
			$arrived['sub_cate_name'] = $arrived_row['sub_cate_name'];
			$arrived['is_animated'] = $arrived_row['is_animated'];
			$arrived['sub_cate_image'] = $link_subcategory_path.$arrived_row['sub_cate_image'];
			$arrived['sub_cate_tray_image'] = $link_subcategory_tray_path.$arrived_row['sub_cate_tray_image'];
			$sub_cate_data[] = $arrived;
		}
		
		$category['sub_category'] = $sub_cate_data;	
	}
	
	$category_list[] = $category;
	
	$get_result = $data_obj->get_active_category();
	$get_count = mysqli_num_rows($get_result);
	if($get_count > 0)
	{
		
		while($row = mysqli_fetch_assoc($get_result))
		{
			$category['view_all'] = 'YES';
			$category_id = $row['id'];
			$category['category_id'] = $row['id'];
			$category['category_image'] = $link_category_path.$row['category_image'];
			$category['category_name'] = $row['category_name'];
			
			$get_sub_cate_result = $data_obj->get_active_sub_category_by_id($category_id);
			$get_sub_cate_count = mysqli_num_rows($get_sub_cate_result);
			if($get_sub_cate_count > 0)
			{
				$sub_cate_data = array();
			
				while($sub_cate_row = mysqli_fetch_assoc($get_sub_cate_result))
				{
					$sub_category['category_id'] = $sub_cate_row['category_id'];
					$sub_category['sub_cate_id'] = $sub_cate_row['id'];
					$sub_category['sub_cate_name'] = $sub_cate_row['sub_cate_name'];
                    $sub_category['is_animated'] = $sub_cate_row['is_animated'];
					$sub_category['sub_cate_image'] = $link_subcategory_path.$sub_cate_row['sub_cate_image'];
					$sub_category['sub_cate_tray_image'] = $link_subcategory_tray_path.$sub_cate_row['sub_cate_tray_image'];
					
					$sub_cate_data[] = $sub_category;
				}
				
				$category['sub_category'] = $sub_cate_data;	
				
				$category_list[] = $category;
			}	
		}
		
		$data['slider'] = $slider_data;
		$data['category_list'] = $category_list;
		
		return ResponseClass::successResponseInArray("data",$data,"1","data retrive successfully.","True");
	}
	else
	{
		return ResponseClass::ResponseMessage("2","Did not found any record!.","False");
	}			

?>

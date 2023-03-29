<?php 

include('dataController.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	@$category_id = comman_class::clear_input_value($_POST['category_id']);
	@$sub_cate_id = comman_class::clear_input_value($_POST['sub_cate_id']);
	@$sub_cate_name = comman_class::clear_input_value($_POST['sub_cate_name']);
	@$sub_cate_image = comman_class::clear_input_value($_POST['sub_cate_image']);
	@$sub_cate_tray_image = comman_class::clear_input_value($_POST['sub_cate_tray_image']);
	@$is_animated = comman_class::clear_input_value($_POST['is_animated']);
	@$is_active = comman_class::clear_input_value($_POST['is_active']);
	@$created_date = comman_class::clear_input_value($_POST['created_date']);
	
	if(!empty($category_id) && !empty($sub_cate_name) && !empty($sub_cate_id))
	{
		$result = $data_obj->get_sub_cate_by_catid_subid_name($category_id,$sub_cate_id,$sub_cate_name);
		$count = mysqli_num_rows($result);
		
		if($count == 0)
		{
			$sub_cate_img = comman_class::single_image_upload($upload_subcategory_path);
			
			if(!empty($sub_cate_img))
			{
				$sub_cate_image = $sub_cate_img;
			}
			
			$sub_cate_tray_img = comman_class::tray_image_upload($upload_subcategory_tray_path);
			
			if(!empty($sub_cate_tray_img))
			{
				$sub_cate_tray_image = $sub_cate_tray_img;
			}
			
			$result1 = $data_obj->update_sub_cate($sub_cate_id,$category_id,$sub_cate_name,$sub_cate_image,$sub_cate_tray_image,$is_animated);
			if($result1 == true)
			{
				$get_cat_result = $data_obj->get_category_by_id($category_id);
				$cat_row = mysqli_fetch_assoc($get_cat_result);
				$category_name = $cat_row['category_name'];

				$sub_id = "'".$sub_cate_id."'";
				
				echo '<td>
							<img class="category-image" src="'.$link_subcategory_path.$sub_cate_image.'"/>
						</td>
						<td>'.$sub_cate_name.'</td>
						<td>'.$category_name.'</td>
						<td>'.$is_animated.'</td>
						<td>'.$is_active.'</td>
						<td>'.$created_date.'</td>
						<td>
							<i class="pe-7s-edit" data-toggle="modal" data-target="#subcategory-Edit-Modal" onClick="get_update_subcategory('.$sub_id.');"></i>
							<i class="pe-7s-less"></i>
						</td>';
			}	
			else
			{
				echo '1';
			}							
		}
		else
		{
			echo '2';
		}
	}
	else
	{
		echo '3';
	}	
} 
else
{
	echo '4';
}
?>
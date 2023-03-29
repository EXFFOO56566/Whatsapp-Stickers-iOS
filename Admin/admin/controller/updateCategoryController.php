<?php 

include('dataController.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	@$category_id = comman_class::clear_input_value($_POST['category_id']);
	@$category_image = comman_class::clear_input_value($_POST['category_image']);
	@$is_active = comman_class::clear_input_value($_POST['is_active']);
	@$created_date = comman_class::clear_input_value($_POST['created_date']);
	@$category_name = comman_class::clear_input_value($_POST['category_name']);
	
	if(!empty($category_id) && !empty($category_image) && !empty($category_name))
	{
		$get_result = $data_obj->get_category_by_name_not_id($category_id,$category_name);
		$count = mysqli_num_rows($get_result);
		
		if($count == 0)
		{			
			$category_img = comman_class::single_image_upload($upload_category_path);
			if(!empty($category_img))
			{
				$category_image = $category_img;
			}
			
			$add_result = $data_obj->update_category($category_id,$category_name,$category_image);
			if($add_result == true)
			{
				$cate_id = "'".$category_id."'";
										
				echo '<td>
							<img class="category-image" src="'.$link_category_path.$category_image.'"/>
						</td>
						<td>'.$category_name.'</td>
						<td>'.$is_active.'</td>
						<td>'.$created_date.'</td>
						<td>
							<i class="pe-7s-edit" data-toggle="modal" data-target="#category-Edit-Modal" onClick="get_update_category('.$cate_id.');"></i>
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
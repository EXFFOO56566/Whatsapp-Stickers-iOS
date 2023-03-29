<?php 
include('dataController.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	@$category_id = comman_class::clear_input_value($_POST['category_id']);
	@$is_animated = comman_class::clear_input_value($_POST['is_animated']);
	
	if(!empty($category_id) && !empty($is_animated))
	{
		$result = $data_obj->get_active_sub_cate_by_cate_id($category_id,$is_animated);
		$count = mysqli_num_rows($result);
		
		if($count > 0)
		{	
			while($row = mysqli_fetch_assoc($result))
			{
				$category_id = $row['category_id'];
										
				$sub_cate_id = $row['id'];
				$sub_id = "'".$sub_cate_id."'";
				
				$sub_cate_name = $row['sub_cate_name'];
				$sub_cate_image = $link_subcategory_path.$row['sub_cate_image'];
				$sub_cate_tray_image = $link_subcategory_tray_path.$row['sub_cate_tray_image'];
				$is_animated = $row['is_animated'];
				$is_active = $row['is_active'];
				$created_date = date('Y-m-d',strtotime($row['created_date']));
				
				$get_cat_result = $data_obj->get_category_by_id($category_id);
				$cat_row = mysqli_fetch_assoc($get_cat_result);
				$category_name = $cat_row['category_name'];

				echo'<tr id="sub_cate_'.$sub_cate_id.'">
						<td>
							<img class="category-image" src="'.$sub_cate_image.'"/>
						</td>
						<td>'.$sub_cate_name.'</td>
						<td>'.$category_name.'</td>
						<td>'.$is_animated.'</td>
						<td>'.$is_active.'</td>
						<td>'.$created_date.'</td>
						<td>
							<i class="pe-7s-edit" data-toggle="modal" data-target="#subcategory-Edit-Modal" onClick="get_update_subcategory('.$sub_id.');"></i>
							<i class="pe-7s-less" onClick="deleteSubCategory('.$sub_id.');"></i>
							<i class="pe-7s-date" onClick="updateSubCategoryDate('.$sub_id.');"></i>
						</td>
					</tr>';
			}		
		}
		else
		{
			echo '<div class="col-md-12"><h4 clas="sticker-h4">No Record Found..</h4></div>';
		}
	}
	else
	{
		echo '<div class="col-md-12"><h4 clas="sticker-h4">Missing detail..</h4></div>';
	}	
} 
else
{
	echo '<div class="col-md-12"><h4 clas="sticker-h4">Do not try to access this page..</h4></div>';
}
?>
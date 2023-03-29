<?php 

include('dataController.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	@$sub_cat_id = comman_class::clear_input_value($_POST['sub_cat_id']);
	
	if(!empty($sub_cat_id))
	{
		$result = $data_obj->get_sub_cate_by_id($sub_cat_id);
		$row = mysqli_fetch_assoc($result);
		
		$cat['category_id'] = $row['category_id'];
		$cat['sub_cate_id'] = $row['id'];
		$cat['sub_cate_name'] = $row['sub_cate_name'];
		$cat['sub_cate_image'] = $row['sub_cate_image'];
		$cat['sub_cate_tray_image'] = $row['sub_cate_tray_image'];
		$cat['is_animated'] = $row['is_animated'];
		$cat['is_active'] = $row['is_active'];
		$cat['created_date'] = date('Y-m-d',strtotime($row['created_date']));
		
		echo json_encode($cat);				
	}
} 
 
?>
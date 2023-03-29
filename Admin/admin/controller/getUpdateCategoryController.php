<?php 

include('dataController.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	@$category_id = comman_class::clear_input_value($_POST['cat_id']);
	
	if(!empty($category_id))
	{
		$result = $data_obj->get_category_by_id($category_id);
		$row = mysqli_fetch_assoc($result);
		
		$cat['category_id'] = $row['id'];
		$cat['category_name'] = $row['category_name'];
		$cat['category_image'] = $row['category_image'];
		$cat['is_active'] = $row['is_active'];
		$cat['created_date'] = date('Y-m-d',strtotime($row['created_date']));
		
		echo json_encode($cat);				
	}
} 
 
?>
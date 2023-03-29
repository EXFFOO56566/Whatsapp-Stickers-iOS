<?php 
include('dataController.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$category_id = comman_class::clear_input_value($_POST['category_id']);
	$is_animated = comman_class::clear_input_value($_POST['is_animated']);
	
	if(!empty($category_id) && !empty($is_animated))
	{
		$result = $data_obj->get_sub_cate_by_catid_animate($category_id, $is_animated);
		$count = mysqli_num_rows($result);
		// echo 'is_animated : '.$is_animated;
		if($count > 0)
		{	
			while($row = mysqli_fetch_assoc($result))
			{
				$sub_cate_id = $row['id'];	
				$sub_cate_name = $row['sub_cate_name'];	

				echo'<option value="'.$sub_cate_id.'">'.$sub_cate_name.'</option>';
			}		
		}
		else
		{
			echo '<option value="">Not Found..</option>';
		}
	}
	else
	{
		echo '<option value="">Not Found..</option>';
	}	
} 
else
{
	echo '<option value="">Not Found..</option>';
}
?>
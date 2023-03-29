<?php 

include('dataController.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	@$category_name = comman_class::clear_input_value($_POST['category_name']);
	
	if(!empty($category_name))
	{
		$get_result = $data_obj->get_category_by_name($category_name);
		$count = mysqli_num_rows($get_result);
		
		if($count == 0)
		{	
			$category_image = comman_class::single_image_upload($upload_category_path);
			
			$add_result = $data_obj->add_category($category_name,$category_image,$created_date);
			if($add_result == true)
			{
				echo '0';
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
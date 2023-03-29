<?php 

include('dataController.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	@$category_id = comman_class::clear_input_value($_POST['category_id']);
	@$slider_name = comman_class::clear_input_value($_POST['slider_name']);
	
	if(!empty($category_id) && !empty($slider_name))
	{
		$result = $data_obj->get_slider_by_id_name($category_id,$slider_name);
		$count = mysqli_num_rows($result);
		
		if($count == 0)
		{	
			$slider_image = comman_class::single_image_upload($upload_slider_path);
			
			$result1 = $data_obj->add_slider($category_id,$slider_name,$slider_image,$created_date);
			if($result1 == true)
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
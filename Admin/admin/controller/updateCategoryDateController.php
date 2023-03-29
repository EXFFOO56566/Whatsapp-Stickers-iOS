<?php 

include('dataController.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	@$category_id = comman_class::clear_input_value($_POST['category_id']);
	
	if(!empty($category_id))
	{
		$result = $data_obj->update_category_date($category_id,$created_date);
		if($result == true)
		{
			echo 1;
		}	
		else
		{
			echo 2;
		}
	}
	else
	{
		echo 3;
	}
} 
else
{
	echo 4;
}

?>
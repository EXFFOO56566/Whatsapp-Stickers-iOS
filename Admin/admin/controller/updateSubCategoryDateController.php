<?php 

include('dataController.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	@$sub_cate_id = comman_class::clear_input_value($_POST['sub_cate_id']);
	
	if(!empty($sub_cate_id))
	{
		$result = $data_obj->update_sub_cate_date($sub_cate_id,$created_date);
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
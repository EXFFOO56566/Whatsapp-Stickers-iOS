<?php 
include('dataController.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	@$sub_cate_id = comman_class::clear_input_value($_POST['sub_cate_id']);
	
	if(!empty($sub_cate_id))
	{		
		$result = $data_obj->remove_sub_cate_by_id($sub_cate_id);
		if($result == true)
		{
			echo "0";
		}
		else
		{
			echo "1";
		}		
	}
	else
	{
		echo "1";
	}
} 
else
{
	echo "1";
}
?>
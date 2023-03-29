<?php 
include('dataController.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	@$slider_id = comman_class::clear_input_value($_POST['slider_id']);
	
	if(!empty($slider_id))
	{		
		$result = $data_obj->remove_slider_by_id($slider_id);
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
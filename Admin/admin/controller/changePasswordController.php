<?php 

include('dataController.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	@$old_password = comman_class::clear_input_value($_POST['old_password']);
	@$new_password = comman_class::clear_input_value($_POST['new_password']);
	
	@$admin_id = $_SESSION['cs_sticker_admin_id'];
	
	if(!empty($admin_id) && !empty($old_password) && !empty($new_password))
	{
		$old_password = md5($old_password);	
		
		$get_result = $data_obj->get_admin_by_id_password($admin_id,$old_password);
		$count = mysqli_num_rows($get_result);

		if($count > 0)
		{	
			$new_password = md5($new_password);	
			
			$update_result = $data_obj->update_admin_password($admin_id,$new_password);
			if($update_result == true)
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
	echo '1';
}
?>
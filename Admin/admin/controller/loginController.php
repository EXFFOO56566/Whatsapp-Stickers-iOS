<?php 

include('dataController.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	@$admin_email 	 = comman_class::clear_input_value($_POST['admin_email']);
	@$admin_password = comman_class::clear_input_value($_POST['admin_password']);

	if(!empty($admin_email) && !empty($admin_password))
	{
		$admin_password = md5($admin_password);	
		
		$result = $data_obj->adminLogin($admin_email,$admin_password);
		$count = mysqli_num_rows($result);		
		if($count > 0)
		{
			$row = mysqli_fetch_assoc($result);
			
			$_SESSION['cs_sticker_admin_id'] =  $row['id'];
			$_SESSION['cs_sticker_admin_name'] =  $row['admin_name'];
			$_SESSION['cs_sticker_admin_email'] =  $row['admin_email'];
			
			echo 1;	
		}
		else
		{
			echo 2;
		}		
	}
	else
	{
		echo 2;
	}
} 
else
{
	echo 2;
}

?>
<?php 
include('dataController.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	@$sticker_id = comman_class::clear_input_value($_POST['sticker_id']);
	
	if(!empty($sticker_id))
	{		
		$get_result = $data_obj->get_animated_sticker_by_id($sticker_id);
		$get_count = mysqli_num_rows($get_result);
		if($get_count == 1)
		{
			$get_row = mysqli_fetch_assoc($get_result);
			$sticker_image = $get_row['sticker_image'];
			
			if(unlink($upload_sticker_animated_path.$sticker_image))
			{
				$d_result = $data_obj->remove_animated_sticker_by_id($sticker_id);
				if($d_result == true)
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
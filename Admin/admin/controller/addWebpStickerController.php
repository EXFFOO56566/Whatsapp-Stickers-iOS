<?php 
include('dataController.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	@$category_id = comman_class::clear_input_value(addslashes($_POST['category_id']));
	@$sub_cate_id = comman_class::clear_input_value(addslashes($_POST['sub_cate_id']));
		
	@$sticker_images = comman_class::multiple_webp_image_upload($upload_sticker_webp_path);
	
	if(!empty($sticker_images[0]))
	{
		for($i=0;$i<count($sticker_images);$i++)
		{
			$sticker_image = $sticker_images[$i];
			
			if(!empty($sticker_image))
			{
				$result = $data_obj->add_webp_sticker($category_id,$sub_cate_id,$sticker_image,$created_date);
			}	
		}
		
		if($result == true)
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
?>
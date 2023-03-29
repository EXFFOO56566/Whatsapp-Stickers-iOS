<?php 
include('dataController.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	@$category_id = comman_class::clear_input_value($_POST['category_id']);
	@$sub_cate_id = comman_class::clear_input_value($_POST['sub_cate_id']);
	
	if(!empty($category_id) && !empty($sub_cate_id))
	{
		$result = $data_obj->get_animated_sticker_by_sub_cate_id($sub_cate_id);
		$count = mysqli_num_rows($result);
		
		if($count > 0)
		{	
			while($row = mysqli_fetch_assoc($result))
			{
				$sticker_id = $row['id'];
				$stckr_id = "'".$sticker_id."'";					
				$sticker_image = $link_sticker_animated_path.$row['sticker_image'];	

				echo'<div id="sticker_'.$sticker_id.'" class="col-md-2 sticker-div-top">
						<div class="sticker-div">
							<img class="sticker-image" src="'.$sticker_image.'">
							<p class="sticker-p">
								<i class="pe-7s-less sticker-i-delete" onClick="deleteAnimatedSticker('.$stckr_id.');"></i>
							</p>
						</div>	
					</div>';
			}		
		}
		else
		{
			echo '<div class="col-md-12"><h4 clas="sticker-h4">No Record Found..</h4></div>';
		}
	}
	else
	{
		echo '<div class="col-md-12"><h4 clas="sticker-h4">Missing detail..</h4></div>';
	}	
} 
else
{
	echo '<div class="col-md-12"><h4 clas="sticker-h4">Do not try to access this page..</h4></div>';
}
?>
<?php

	/* Include the content of header */
	require_once('header.php');

?>

        <div class="content">
            <div class="container-fluid">
                <div class="row">  
					<div class="col-md-12">
                        <div class="card">
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th>Image</th>
                                    	<th>Name</th>
                                    	<th>Category</th>
                                    	<th>Is Active</th>
                                    	<th>Date</th>
                                    	<th>Action</th>
                                    </thead>
                                    <tbody>
<?php                                
									$get_result = $data_obj->get_active_slider();
									while($row = mysqli_fetch_assoc($get_result))
									{
										$category_id = $row['category_id'];
										
										$slider_id = $row['id'];
										$slid_id = "'".$slider_id."'";
										
										$slider_name = $row['slider_name'];
										$slider_image = $link_slider_path.$row['slider_image'];
										$is_active = $row['is_active'];
										$created_date = date('Y-m-d',strtotime($row['created_date']));
										
										$get_cat_result = $data_obj->get_category_by_id($category_id);
										$cat_row = mysqli_fetch_assoc($get_cat_result);
										$category_name = $cat_row['category_name'];
											
										echo'<tr id="slider_'.$slider_id.'">
												<td>
													<img class="category-image" src="'.$slider_image.'"/>
												</td>
												<td>'.$slider_name.'</td>
												<td>'.$category_name.'</td>
												<td>'.$is_active.'</td>
												<td>'.$created_date.'</td>
												<td>
													<i class="pe-7s-less" onClick="deleteSlider('.$slid_id.');"></i>
												</td>
											</tr>';
									}	
?>                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php

	/* Include the content of footer */
	require_once('footer.php');

?>

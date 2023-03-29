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
                                    	<th>Is Active</th>
                                    	<th>Date</th>
                                    	<th>Action</th>
                                    </thead>
                                    <tbody>
<?php                                
									$get_result = $data_obj->get_active_category();
									while($row = mysqli_fetch_assoc($get_result))
									{
										$category_id = $row['id'];
										$cate_id = "'".$category_id."'";
										
										$category_name = $row['category_name'];
										$category_image = $link_category_path.$row['category_image'];
										$is_active = $row['is_active'];
										$created_date = date('Y-m-d',strtotime($row['created_date']));
										
										echo'<tr id="cate_'.$category_id.'">
												<td>
													<img class="category-image" src="'.$category_image.'"/>
												</td>
												<td>'.$category_name.'</td>
												<td>'.$is_active.'</td>
												<td>'.$created_date.'</td>
												<td>
													<i class="pe-7s-edit" data-toggle="modal" data-target="#category-Edit-Modal" onClick="get_update_category('.$cate_id.');"></i>
													<i class="pe-7s-less" onClick="deleteCategory('.$cate_id.');"></i>
													<i class="pe-7s-date" onClick="updateCategoryDate('.$cate_id.');"></i>
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

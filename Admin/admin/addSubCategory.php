<?php
	
	// inculde header file content
	require_once('header.php');

?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2">
					</div>
                    <div class="col-md-8">
						<div id="form-loader" class="loader-div">
							<img class="loader-image" src="assets/img/processing.gif">
						</div>		
						
                        <div class="card">
                            <div class="header">
                                <h4 class="title form-title">Add SubCategory</h4>
                            </div>
                            <div class="content">
                                <form id='submit-sub-category-form' enctype="multipart/form-data">
									<div class="row">
										<div class="col-md-2">
										</div>
										<div class="col-md-8">
											
											<div class="form-group">
												<label>Category</label>
												<select id="category_id" name="category_id" class="form-control" required>
													<option value="">Select Category</option>
<?php
													$get_result = $data_obj->get_active_category();
													while($row = mysqli_fetch_assoc($get_result))
													{
														$category_id = $row['id'];
														$category_name = $row['category_name'];
														
														echo'<option value="'.$category_id.'">'.$category_name.'</option>';
													}
?>													
												</select>
											</div>
											<div class="form-group">
												<label>Sub Category Name</label>
												<input type="text" id="sub_cate_name" name="sub_cate_name" class="form-control" placeholder="SubCategory Name" required> 
											</div>
											<div class="form-group">
												<label>Is Animated</label>
												<select id="is_animated" name="is_animated" class="form-control" required>
													<option value="NO">NO</option>
													<option value="YES">YES</option>
												</select>
											</div>
											<div class="form-group">
												<label>Sub Category Tray Image</label>
												<input type="file" id="tray_image_file" name="tray_image_file" class="form-control" placeholder="SubCategory Tray Image" required>
											</div>
											<div class="form-group">
												<label>Sub Category Image</label>
												<input type="file" id="image_file" name="image_file" class="form-control" placeholder="SubCategory Image" required>
											</div>
											
										</div>
									</div>

									<div class="row btn-center">
										<button type="submit" class="btn btn-info btn-fill">ADD</button>
									</div>
								</form>
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
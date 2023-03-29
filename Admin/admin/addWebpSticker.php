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
                                <h4 class="title form-title">Add Webp Sticker</h4>
                            </div>
                            <div class="content">
                                <form id='submit-webp-sticker-form' enctype="multipart/form-data">
									<div class="row">
										<div class="col-md-2">
										</div>
										<div class="col-md-8">
											<input type="text" id="is_animated" name="is_animated" value="NO" required hidden>
											<div class="form-group">
												<label>Category</label>
												<select id="category_id" name="category_id" class="form-control" onChange="getOptionSubCategory();" required>
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
												<label>SubCategory</label>
												<select id="sub_cate_id" name="sub_cate_id" class="form-control" required>
													<option value="">Select SubCategory</option>
												</select>
											</div>
											<div class="form-group">
												<label>Sub Category Image</label>
												<input type="file" id="image_files" name="image_files[]" class="form-control" placeholder="SubCategory Image" required multiple>
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
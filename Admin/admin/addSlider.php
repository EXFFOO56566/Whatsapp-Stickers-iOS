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
                                <h4 class="title form-title">Add Slider</h4>
                            </div>
                            <div class="content">
                                <form id='submit-slider-form' enctype="multipart/form-data">
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
												<label>Slider Name</label>
												<input type="text" id="slider_name" name="slider_name" class="form-control" placeholder="Slider Name" required> 
											</div>
											<div class="form-group">
												<label>Slider Image</label>
												<input type="file" id="image_file" name="image_file" class="form-control" placeholder="Slider Image" required>
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
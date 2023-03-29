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
                                <h4 class="title form-title">Add Category</h4>
                            </div>
                            <div class="content">
                                <form id='submit-category-form' enctype="multipart/form-data">
									<div class="row">
										<div class="col-md-2">
										</div>
										<div class="col-md-8">
											
											<div class="form-group">
												<label>Category Name</label>
												<input type="text" id="category_name" name="category_name" class="form-control" placeholder="Category Name" required> 
											</div>
											<div class="form-group">
												<label>Category Image</label>
												<input type="file" id="image_file" name="image_file" class="form-control" placeholder="Category Image" required>
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
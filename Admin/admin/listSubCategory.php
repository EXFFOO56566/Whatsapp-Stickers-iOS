<?php

	/* Include the content of header */
	require_once('header.php');

?>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<select id="category_id" name="category_id" class="form-control">
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
					</div>	
					<div class="col-md-2">
						<div class="form-group">
							<select id="is_animated" name="is_animated" class="form-control" required>
								<option value="NO">ANIMAITION : NO</option>
								<option value="YES">ANIMAITION : YES</option>
							</select>
						</div>
					</div>
					<div class="col-md-1">
						<div class="form-group">
							<div class="row btn-center">
								<button class="btn btn-info btn-fill" onClick="getSubCategory();" >FILTER</button>
							</div>
						</div>
					</div>
											
				</div>
				<div class="row card"> 
					<div id="list-loader" class="list-loader-div">
						<img class="list-loader-image" src="assets/img/processing.gif">
					</div>
					<div class="card">
						<div class="content table-responsive table-full-width">
							<table class="table table-hover table-striped">
								<thead>
									<th>Image</th>
									<th>Name</th>
									<th>Category</th>
									<th>Is Animated</th>
									<th>Is Active</th>
									<th>Date</th>
									<th>Action</th>
								</thead>
								<tbody id="sub-cate-div">	
								</tbody>
                            </table>
						</div>
					</div>
                </div>
            </div>
        </div>

<?php

	/* Include the content of footer */
	require_once('footer.php');

?>

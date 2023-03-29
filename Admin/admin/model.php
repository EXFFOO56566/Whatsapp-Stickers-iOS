			
<!-- Category Edit Modal -->
<div class="modal fade" id="category-Edit-Modal" role="dialog">
	<div class="modal-dialog">
	
	  <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button id="category-Edit-Modal-Close" type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit Category</h4>
			</div>
			<div class="modal-body">
				<div id="form-loader" class="loader-div">
					<img class="loader-image" src="assets/img/processing.gif">
				</div>		
				
				<div class="content">
					<form id='update-category-form' enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-2">
							</div>
							<div class="col-md-8">
								
								<input type="text" id="category_id" name="category_id" hidden> 
								<input type="text" id="category_image" name="category_image" hidden> 
								<input type="text" id="is_active" name="is_active" hidden> 
								<input type="text" id="created_date" name="created_date" hidden> 
								
								<div class="form-group">
									<label>Category Name</label>
									<input type="text" id="category_name" name="category_name" class="form-control" placeholder="Category Name" required> 
								</div>
								<div class="form-group">
									<label>Category Image</label>
									<input type="file" id="image_file" name="image_file" class="form-control" placeholder="Category Image">
								</div>
								
							</div>
						</div>

						<div class="row btn-center">
							<button type="submit" class="btn btn-info btn-fill">UPDATE</button>
						</div>
					</form>
				</div>
				</br>
				<div class="modal-footer">
					<button class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>	  
		</div>
	</div>
</div>

<!-- Sub Category Edit Modal -->
<div class="modal fade" id="subcategory-Edit-Modal" role="dialog">
	<div class="modal-dialog">
	
	  <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button id="subcategory-Edit-Modal-Close" type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit SubCategory</h4>
			</div>
			<div class="modal-body">
				<div id="form-loader" class="loader-div">
					<img class="loader-image" src="assets/img/processing.gif">
				</div>		
				
				<div class="content">
					<form id='update-subcategory-form' enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-2">
							</div>
							<div class="col-md-8">
								
								<input type="text" id="sub_cate_id" name="sub_cate_id" hidden> 
								<input type="text" id="sub_cate_image" name="sub_cate_image" hidden> 
								<input type="text" id="sub_cate_tray_image" name="sub_cate_tray_image" hidden>
								<input type="text" id="sub_is_active" name="is_active" hidden> 
								<input type="text" id="sub_created_date" name="created_date" hidden> 
								
								<div class="form-group">
									<label>Category</label>
									<select id="sub_category_id" name="category_id" class="form-control" required>
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
									<input type="text" id="sub_cate_name" name="sub_cate_name" class="form-control" placeholder="SubCategory Name"> 
								</div>
								<div class="form-group">
									<label>Is Animated</label>
									<select id="sub_is_animated" name="is_animated" class="form-control" required>
										<option value="NO">NO</option>
										<option value="YES">YES</option>
									</select>
								</div>
								<div class="form-group">
									<label>Sub Category Tray Image</label>
									<input type="file" id="tray_image_file" name="tray_image_file" class="form-control" placeholder="SubCategory Tray Image">
								</div>
								<div class="form-group">
									<label>Sub Category Image</label>
									<input type="file" id="image_file" name="image_file" class="form-control" placeholder="SubCategory Image">
								</div>
								
							</div>
						</div>

						<div class="row btn-center">
							<button type="submit" class="btn btn-info btn-fill">UPDATE</button>
						</div>
					</form>
				</div>
				</br>
				<div class="modal-footer">
					<button class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>
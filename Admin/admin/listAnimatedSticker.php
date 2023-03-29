<?php
	
	// inculde header file content
	require_once('header.php');

?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
					<div class="col-md-3">
					
						<input type="text" id="is_animated" name="is_animated" value="YES" required hidden>
						
						<div class="form-group">
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
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<select id="sub_cate_id" name="sub_cate_id" class="form-control" required>
								<option value="">Select SubCategory</option>
													
							</select>
						</div>
					</div>
					<div class="col-md-1">
						<div class="form-group">
							<div class="row btn-center">
								<button class="btn btn-info btn-fill" onClick="getAnimatedSticker();" >FILTER</button>
							</div>
						</div>
					</div>	
				</div>
				<div class="row card"> 
					<div id="list-loader" class="list-loader-div">
						<img class="list-loader-image" src="assets/img/processing.gif">
					</div>
					
					<div id="sticker-div">
							
					</div>
                </div>
            </div>
        </div>

<?php

	/* Include the content of footer */
	require_once('footer.php');

?>
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
                                <h4 class="title form-title">Change Password</h4>
                            </div>
                            <div class="content">
                                <form id='submit-password-form'>
									<div class="row">
										<div class="col-md-2">
										</div>
										<div class="col-md-8">
											
											<div class="form-group">
												<label>OLD Password</label>
												<input type="text" id="old_password" name="old_password" class="form-control" placeholder="old password" required> 
											</div>
											<div class="form-group">
												<label>NEW Password</label>
												<input type="text" id="new_password" name="new_password" class="form-control" placeholder="new password" required> 
											</div>
											<div class="form-group">
												<label>Confirm Password</label>
												<input type="text" id="confirm_password" name="confirm_password" class="form-control" placeholder="confirm password" required> 
											</div>
										</div>
									</div>
									<div class="row btn-center">
										<button type="submit" class="btn btn-info btn-fill">UPDATE</button>
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
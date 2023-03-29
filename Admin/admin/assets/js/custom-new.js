/******************* Response alert message **************/

// Response Success alert message
function responseSuccessMsg(msg){

	$.notify({
		message: "<b>Success ! </b>"+msg

	},{
		type: 'success',
		timer: 4000
	});

}

// Response Error alert message
function responseErrorMsg(msg){

	$.notify({
		message: "<b>Error ! </b>"+msg

	},{
		type: 'danger',
		timer: 4000
	});

}

// Response Warning alert message
function warningMsg(msg){

	$.notify({
		message: "<b>Warning ! </b>."+msg

	},{
		type: 'warning',
		timer: 4000
	});

}

// For admin login to validate the existing user
function adminLogin() {
	
	var admin_email = $("#admin_email").val();	
	var admin_password = $("#admin_password").val();	
	
	if(admin_email == "" || admin_password == "" )
	{
		$('#faild').hide();	
		$('#warning').fadeIn();	
		setTimeout(function wait()
		{
			$('#warning').fadeOut();
		}, 5000);		
	}
	else
	{
		$("#form-loader").show();
		
		$.ajax({
		type: "POST",
		data:{admin_email:admin_email, admin_password:admin_password},
		url: "controller/loginController.php",
		success: function(result){
				//alert(result);
				if(result == 1)
				{
					window.location.href = 'dashboard.php';				
				}
				else
				{
					$('#warning').hide();	
					$('#faild').fadeIn();
					setTimeout(function wait()
					{
						$('#faild').fadeOut();		
					}, 3000);
					
					$("#form-loader").fadeOut();	
				}					
			}
		});
	}

}

// Call this method on page load
$(document).ready(function (e) {

	// For adding category
	
	$("#submit-category-form").on('submit',(function(e) {
		
		e.preventDefault();
		
		var category_name = $("#category_name").val();	
		var category_image = $("#image_file").val();	
		
		if(category_name == "" || category_image == "")
		{
			warningMsg("Please fill required fields.");	
		}
		else
		{
			$("#form-loader").show();
			
			$.ajax({
			url: "controller/addCategoryController.php",
			type: "POST", 
			data: new FormData(this),
			contentType: false,      
			cache: false,            
			processData:false,       
			success: function(result)
				{
					if(result == 0)
					{
						// reset form fields
						$('#submit-category-form')[0].reset();
						
						responseSuccessMsg(" category added succesessfully.");						
					}
					else if(result == 1)
					{
						responseErrorMsg(" in add category.");				
					}
					else if(result == 2)
					{
						responseErrorMsg(" category already exist.");				
					}
					else if(result == 3)
					{
						warningMsg(" missing detail.");				
					}
					else if(result == 4)
					{
						warningMsg(" Do not try to access this web.");				
					}
					else
					{
						responseErrorMsg(result);
					}

					$("#form-loader").fadeOut();					
				}
			}); 
		}
	}));

	// For Update category
	
	$("#update-category-form").on('submit',(function(e) {
		
		e.preventDefault();
		
		var category_id = $("#category_id").val();	
		var category_image = $("#category_image").val();	
		var category_name = $("#category_name").val();	
		
		if(category_id == "" || category_name == "" || category_image == "")
		{
			warningMsg("Please fill required fields.");	
		}
		else
		{
			$("#form-loader").show();
			
			$.ajax({
			url: "controller/updateCategoryController.php",
			type: "POST", 
			data: new FormData(this),
			contentType: false,      
			cache: false,            
			processData:false,       
			success: function(result)
				{
					if(result == 1)
					{
						responseErrorMsg(" in update category.");				
					}
					else if(result == 2)
					{
						responseErrorMsg(" category already exist.");				
					}
					else if(result == 3)
					{
						warningMsg(" missing detail.");				
					}
					else if(result == 4)
					{
						warningMsg(" Do not try to access this web.");				
					}
					else
					{
						// reset form fields
						$('#update-category-form')[0].reset();
						$('#category-Edit-Modal-Close').trigger( "click" );
						$('#cate_'+category_id).html(result);
						
						responseSuccessMsg(" category updated succesessfully.");	
					}

					$("#form-loader").fadeOut();					
				}
			}); 
		}
	}));

	
	// For adding Sub category
	
	$("#submit-sub-category-form").on('submit',(function(e) {
		
		e.preventDefault();
		
		var category_id = $("#category_id").val();	
		var sub_cate_name = $("#sub_cate_name").val();	
		var sub_cate_image = $("#image_file").val();	
		var tray_image_file = $("#tray_image_file").val();	
		
		if(category_id == "" || sub_cate_name == "" || sub_cate_image == "" || tray_image_file == "")
		{
			warningMsg("Please fill required fields.");	
		}
		else
		{
			$("#form-loader").show();
			
			$.ajax({
			url: "controller/addSubCategoryController.php",
			type: "POST", 
			data: new FormData(this),
			contentType: false,      
			cache: false,            
			processData:false,       
			success: function(result)
				{
					if(result == 0)
					{
						// reset form fields
						$('#submit-sub-category-form')[0].reset();
						
						responseSuccessMsg(" Sub category added succesessfully.");						
					}
					else if(result == 1)
					{
						responseErrorMsg(" in add subcategory.");				
					}
					else if(result == 2)
					{
						responseErrorMsg(" Sub category already exist.");				
					}
					else if(result == 3)
					{
						warningMsg(" missing detail.");				
					}
					else if(result == 4)
					{
						warningMsg(" Do not try to access this web.");				
					}
					else
					{
						responseErrorMsg(result);
					}

					$("#form-loader").fadeOut();					
				}
			}); 
		}
	}));
	
	// For Update Sub category
	
	$("#update-subcategory-form").on('submit',(function(e) {
		
		e.preventDefault();
		
		var category_id = $("#sub_category_id").val();	
		var sub_cate_id = $("#sub_cate_id").val();		
		var sub_cate_name = $("#sub_cate_name").val();	
		
		if(category_id == "" || sub_cate_name == "" || sub_cate_id == "")
		{
			warningMsg("Please fill required fields.");	
		}
		else
		{
			$("#form-loader").show();
			
			$.ajax({
			url: "controller/updateSubCategoryController.php",
			type: "POST", 
			data: new FormData(this),
			contentType: false,      
			cache: false,            
			processData:false,       
			success: function(result)
				{
					if(result == 1)
					{
						responseErrorMsg(" in update subcategory.");				
					}
					else if(result == 2)
					{
						responseErrorMsg(" subcategory already exist.");				
					}
					else if(result == 3)
					{
						warningMsg(" missing detail.");				
					}
					else if(result == 4)
					{
						warningMsg(" Do not try to access this web.");				
					}
					else
					{
						// reset form fields
						$('#update-subcategory-form')[0].reset();
						$('#subcategory-Edit-Modal-Close').trigger( "click" );
						$('#sub_cate_'+sub_cate_id).html(result);
						
						responseSuccessMsg(" subcategory updated succesessfully.");	
					}

					$("#form-loader").fadeOut();					
				}
			}); 
		}
	}));

	
	// For adding animated Sticker
	$("#submit-animated-sticker-form").on('submit',(function(e) {
		
		e.preventDefault();
		
		var category_id = $("#category_id").val();	
		var sub_cate_id = $("#sub_cate_id").val();	
		var sticker_image = $("#image_files").val();	
		
		if(category_id == "" || sub_cate_id == "" || sticker_image == "")
		{
			warningMsg("Please fill required fields.");	
		}
		else
		{
			$("#form-loader").show();
			
			$.ajax({
			url: "controller/addAnimatedStickerController.php",
			type: "POST", 
			data: new FormData(this),
			contentType: false,      
			cache: false,            
			processData:false,       
			success: function(result)
				{
					//alert(result);
					if(result == 0)
					{
						// reset form fields
						$('#submit-animated-sticker-form')[0].reset();
						
						responseSuccessMsg(" Sticker added succesessfully.");						
					}
					else if(result == 1)
					{
						responseErrorMsg(" in add Sticker.");				
					}
					else if(result == 2)
					{
						responseErrorMsg(" Sticker already exist.");				
					}
					else if(result == 3)
					{
						warningMsg(" missing detail.");				
					}
					else if(result == 4)
					{
						warningMsg(" Do not try to access this web.");				
					}
					else
					{
						responseErrorMsg(result);
					}
					
					$("#form-loader").fadeOut();
				}
			}); 
		}
	}));
	
	
	// For adding Webp Sticker
	
	$("#submit-webp-sticker-form").on('submit',(function(e) {
		
		e.preventDefault();
		
		var category_id = $("#category_id").val();	
		var sub_cate_id = $("#sub_cate_id").val();	
		var sticker_image = $("#image_files").val();	
		
		if(category_id == "" || sub_cate_id == "" || sticker_image == "")
		{
			warningMsg("Please fill required fields.");	
		}
		else
		{
			$("#form-loader").show();
			
			$.ajax({
			url: "controller/addWebpStickerController.php",
			type: "POST", 
			data: new FormData(this),
			contentType: false,      
			cache: false,            
			processData:false,       
			success: function(result)
				{
					//alert(result);
					if(result == 0)
					{
						// reset form fields
						$('#submit-webp-sticker-form')[0].reset();
						
						responseSuccessMsg(" Sticker added succesessfully.");						
					}
					else if(result == 1)
					{
						responseErrorMsg(" in add Sticker.");				
					}
					else if(result == 2)
					{
						responseErrorMsg(" Sticker already exist.");				
					}
					else if(result == 3)
					{
						warningMsg(" missing detail.");				
					}
					else if(result == 4)
					{
						warningMsg(" Do not try to access this web.");				
					}
					else
					{
						responseErrorMsg(result);
					}
					
					$("#form-loader").fadeOut();
				}
			}); 
		}
	}));
	
	// For adding Slider
	
	$("#submit-slider-form").on('submit',(function(e) {
		
		e.preventDefault();
		
		var category_id = $("#category_id").val();	
		var slider_name = $("#slider_name").val();	
		var slider_image = $("#image_file").val();	
		
		if(category_id == "" || slider_name == "" || slider_image == "")
		{
			warningMsg("Please fill required fields.");	
		}
		else
		{
			$("#form-loader").show();
			
			$.ajax({
			url: "controller/addSliderController.php",
			type: "POST", 
			data: new FormData(this),
			contentType: false,      
			cache: false,            
			processData:false,       
			success: function(result)
				{
					if(result == 0)
					{
						// reset form fields
						$('#submit-slider-form')[0].reset();
						
						responseSuccessMsg(" Slider added succesessfully.");						
					}
					else if(result == 1)
					{
						responseErrorMsg(" in add slider.");				
					}
					else if(result == 2)
					{
						responseErrorMsg(" Slider already exist.");				
					}
					else if(result == 3)
					{
						warningMsg(" missing detail.");				
					}
					else if(result == 4)
					{
						warningMsg(" Do not try to access this web.");				
					}
					else
					{
						responseErrorMsg(result);
					}

					$("#form-loader").fadeOut();					
				}
			}); 
		}
	}));
	
	// For Change Password
	
	$("#submit-password-form").on('submit',(function(e) {
		
		e.preventDefault();
		
		var old_password = $("#old_password").val();	
		var new_password = $("#new_password").val();	
		var confirm_password = $("#confirm_password").val();	
		
		if(old_password == "" || new_password == "" || confirm_password == "")
		{
			warningMsg("Please fill required fields.");	
		}
		else if(new_password != confirm_password)
		{
			warningMsg("Confirm Password not matched.");	
		}
		else
		{
			$("#form-loader").show();
			
			$.ajax({
			url: "controller/changePasswordController.php",
			type: "POST", 
			data: new FormData(this),
			contentType: false,      
			cache: false,            
			processData:false,       
			success: function(result)
				{
					if(result == 0)
					{
						// reset form fields
						$('#submit-password-form')[0].reset();
						
						responseSuccessMsg(" password change succesessfully.");						
					}
					else if(result == 1)
					{
						responseErrorMsg(" in change password.");				
					}
					else if(result == 2)
					{
						warningMsg(" Old password did not match.");				
					}
					else if(result == 3)
					{
						warningMsg(" missing detail.");				
					}
					else
					{
						responseErrorMsg(result);
					}

					$("#form-loader").fadeOut();					
				}
			}); 
		}
	}));
});

/************************** Get update category ***********************/
			
function get_update_category(cat_id) 
{	
	$("#form-loader").show();
	
	$.ajax({
		type:"post",
		data:{cat_id:cat_id},
		url:"controller/getUpdateCategoryController.php",
		dataType: "json",
		success: function(result)
		{
			//alert(result.category_id);
			$('#category_id').val(result.category_id);
			$('#category_name').val(result.category_name);
			$('#category_image').val(result.category_image);
			$('#is_active').val(result.is_active);
			$('#created_date').val(result.created_date);
			
			$('#form-loader').fadeOut();   
		}   
	}); 
}
		
/************************** Get update Subcategory ***********************/
			
function get_update_subcategory(sub_cat_id) 
{	
	$("#form-loader").show();

	$.ajax({
		type:"post",
		data:{sub_cat_id:sub_cat_id},
		url:"controller/getUpdateSubCategoryController.php",
		dataType: "json",
		success: function(result)
		{
			//alert(result.category_id);
			$('#sub_category_id').val(result.category_id);
			$('#sub_cate_id').val(result.sub_cate_id);		
			$('#sub_cate_name').val(result.sub_cate_name);
			$('#sub_cate_image').val(result.sub_cate_image);
			$('#sub_is_animated').val(result.is_animated);
			$('#sub_is_active').val(result.is_active);
			$('#sub_created_date').val(result.created_date);
			
			$('#form-loader').fadeOut();   
		}   
	}); 
}
		
//************************** Get Option Sub category ***********************//			

function getOptionSubCategory() 
{	
	var category_id = $("#category_id").val();	
	var is_animated = $("#is_animated").val();
	
	// alert(is_animated);
	
	if(category_id == '' && is_animated == '')
	{
		warningMsg("Please select the category.");	
	}
	else
	{
		
		$.ajax({
			type:"post",
			data:{category_id:category_id, is_animated:is_animated},
			url:"controller/getOptionSubCategoryController.php",
			success: function(result)
				{
					//alert(result);
					$('#sub_cate_id').html(result);
				}   		
		}); 
	}
}


//************************** Get Sub category ***********************//			

function getSubCategory() 
{	
	
	var category_id = $("#category_id").val();	
	var is_animated = $("#is_animated").val();	
	
	if(category_id == '' && is_animated == '')
	{
		warningMsg("Please select the category.");	
	}
	else
	{
		$("#list-loader").show();
		
		$.ajax({
			type:"post",
			data:{category_id:category_id, is_animated:is_animated},
			url:"controller/getSubCategoryController.php",
			success: function(result)
				{
					//alert(result);
					$('#sub-cate-div').html(result);
					
					$("#list-loader").fadeOut();
				}   		
		}); 
	}
}

//************************** Get Animated Sticker ***********************//			


function getAnimatedSticker() 
{	
	
	var category_id = $("#category_id").val();	
	var sub_cate_id = $("#sub_cate_id").val();	
	
	if(category_id == '' || sub_cate_id == '')
	{
		if(category_id == '')
		{
			warningMsg("Please select the category.");	
		}
		else
		{
			warningMsg("Please select the Subcategory.");	
		}
	}
	else
	{
		$("#list-loader").show();
		
		$.ajax({
			type:"post",
			data:{category_id:category_id,sub_cate_id:sub_cate_id},
			url:"controller/getAnimatedStickerController.php",
			success: function(result)
				{
					//alert(result);
					$('#sticker-div').html(result);
					
					$("#list-loader").fadeOut();
				}   		
		}); 
	}
}

//************************** Get Webp Sticker ***********************//			

function getWebpSticker() 
{	
	
	var category_id = $("#category_id").val();	
	var sub_cate_id = $("#sub_cate_id").val();	
	
	if(category_id == '' || sub_cate_id == '')
	{
		if(category_id == '')
		{
			warningMsg("Please select the category.");	
		}
		else
		{
			warningMsg("Please select the Subcategory.");	
		}
	}
	else
	{
		$("#list-loader").show();
		
		$.ajax({
			type:"post",
			data:{category_id:category_id,sub_cate_id:sub_cate_id},
			url:"controller/getWebpStickerController.php",
			success: function(result)
				{
					//alert(result);
					$('#sticker-div').html(result);
					
					$("#list-loader").fadeOut();
				}   		
		}); 
	}
}

//************************** delete Slider ***********************//			

function deleteSlider(id)
{	
	var r = confirm("Are you sure ! you want to remove this slider ?");
	if (r == true) 
	{
		$("#list-loader").show();
		
		$.ajax({
			type:"post",
			data:{slider_id:id},
			url:"controller/removeSliderController.php",
			success: function(result)
			{
				if(result == 0)
				{
					$("#slider_"+id).remove();
					responseSuccessMsg(" Slider removed succesessfully.");
				}
				else if(result == 1)
				{
					responseErrorMsg(" in delete Slider.");
				}
				else
				{   
					responseErrorMsg(result);
				}

				$("#list-loader").fadeOut();					
			}   
		}); 	
	} 
}

//************************** Update Category Date ***********************//			

function updateCategoryDate(id)
{	
	var r = confirm("Are you sure ! you want to Update this category Date?");
	if (r == true) 
	{
		$("#list-loader").show();
		
		$.ajax({
			type:"post",
			data:{category_id:id},
			url:"controller/updateCategoryDateController.php",
			success: function(result)
			{
				if(result == 1)
				{
					responseSuccessMsg(" Date updated successfully.");
				}
				else if(result == 2)
				{
					responseErrorMsg(" in update Date.");
				}
				else
				{   
					responseErrorMsg(result);
				}

				$("#list-loader").fadeOut();					
			}   
		}); 	
	} 
}

//************************** delete Category ***********************//			

function deleteCategory(id)
{	
	var r = confirm("Are you sure ! you want to remove this category ?");
	if (r == true) 
	{
		$("#list-loader").show();
		
		$.ajax({
			type:"post",
			data:{category_id:id},
			url:"controller/removeCategoryController.php",
			success: function(result)
			{
				if(result == 0)
				{
					$("#cate_"+id).remove();
					responseSuccessMsg(" category removed succesessfully.");
				}
				else if(result == 1)
				{
					responseErrorMsg(" in delete category.");
				}
				else
				{   
					responseErrorMsg(result);
				}

				$("#list-loader").fadeOut();					
			}   
		}); 	
	} 
}


//************************** Update SubCategory Date ***********************//			

function updateSubCategoryDate(id)
{	
	var r = confirm("Are you sure ! you want to update this Subcategory Date ?");
	if (r == true) 
	{
		$("#list-loader").show();
		
		$.ajax({
			type:"post",
			data:{sub_cate_id:id},
			url:"controller/updateSubCategoryDateController.php",
			success: function(result)
			{
				if(result == 1)
				{
					responseSuccessMsg(" Updated successfully.");
				}
				else if(result == 2)
				{
					responseErrorMsg(" in Update.");
				}
				else
				{   
					responseErrorMsg(result);
				}

				$("#list-loader").fadeOut();					
			}   
		}); 	
	} 
}


//************************** delete SubCategory ***********************//			

function deleteSubCategory(id)
{	
	var r = confirm("Are you sure ! you want to remove this Subcategory ?");
	if (r == true) 
	{
		$("#list-loader").show();
		
		$.ajax({
			type:"post",
			data:{sub_cate_id:id},
			url:"controller/removeSubCategoryController.php",
			success: function(result)
			{
				if(result == 0)
				{
					$("#sub_cate_"+id).remove();
					responseSuccessMsg(" Subcategory removed succesessfully.");
				}
				else if(result == 1)
				{
					responseErrorMsg(" in delete Subcategory.");
				}
				else
				{   
					responseErrorMsg(result);
				}

				$("#list-loader").fadeOut();					
			}   
		}); 	
	} 
}

//************************** delete Animated Sticker ***********************//

function deleteAnimatedSticker(id)
{	
	var r = confirm("Are you sure ! you want to remove this Sticker ?");
	if (r == true) 
	{
		$("#list-loader").show();
		
		$.ajax({
			type:"post",
			data:{sticker_id:id},
			url:"controller/removeAnimatedStickerController.php",
			success: function(result)
			{
				if(result == 0)
				{
					$("#sticker_"+id).remove();
					responseSuccessMsg(" Sticker removed succesessfully.");
				}
				else if(result == 1)
				{
					responseErrorMsg(" in delete sticker.");
				}
				else
				{   
					responseErrorMsg(result);
				}

				$("#list-loader").fadeOut();					
			}   
		}); 	
	} 
}

//************************** delete Webp Sticker ***********************//			

function deleteWebpSticker(id)
{	
	var r = confirm("Are you sure ! you want to remove this Sticker ?");
	if (r == true) 
	{
		$("#list-loader").show();
		
		$.ajax({
			type:"post",
			data:{sticker_id:id},
			url:"controller/removeWebpStickerController.php",
			success: function(result)
			{
				if(result == 0)
				{
					$("#sticker_"+id).remove();
					responseSuccessMsg(" Sticker removed succesessfully.");
				}
				else if(result == 1)
				{
					responseErrorMsg(" in delete sticker.");
				}
				else
				{   
					responseErrorMsg(result);
				}

				$("#list-loader").fadeOut();					
			}   
		}); 	
	} 
}

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Asia/Kolkata');

include ('sessionController.php');
include ('functionClass.php');
	
@$admin_name = $_SESSION['cs_sticker_admin_name'];
@$admin_email = $_SESSION['cs_sticker_admin_email'];
@$admin_image = 'icon/admin.png';

@$no_search_found = "no search found..";

@$created_date = date("Y-m-d h:i:s");

$upload_category_path = "../../images/category/";
$link_category_path = "../images/category/";

$upload_subcategory_path = "../../images/subcategory/";
$link_subcategory_path = "../images/subcategory/";

$upload_subcategory_tray_path = "../../images/subcategory_tray/";
$link_subcategory_tray_path = "../images/subcategory_tray/";

$upload_sticker_webp_path = "../../images/sticker_webp/";
$link_sticker_webp_path = "../images/sticker_webp/";

$upload_sticker_animated_path = "../../images/sticker_animate/";
$link_sticker_animated_path = "../images/sticker_animate/";

$upload_sticker_png_path = "../../images/sticker_png/";
$link_sticker_png_path = "../images/sticker_png/";

$upload_slider_path = "../../images/slider/";
$link_slider_path = "../images/slider/";

$data_obj = new Data();

class data  
{   
	var  $conn;
	
	//constructor to eastablishment connection with database
	public function connect_db()
	{   
   
		//host , User , Pass , DB Name
		$conn = new mysqli("localhost", "root", "", "cc_ios_sticker");
		
		// $conn = new mysqli("mysql.hostinger.in", "u498994603_cs_sticker", "KK9099153528kk", "u498994603_cs_sticker");
		
		if (mysqli_connect_errno()) 
		{ 
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit(); 
		} 
		
		$conn->set_charset("utf8mb4");
		
		return  $conn; 
	} 
	
	/*---------------------------------- tbl Admin ----------------------------------*/	
	/*-------------------------------------------------------------------------------*/
	
	public function adminLogin($admin_email,$admin_password)
	{   
		$conn = $this->connect_db(); 
		 	
		$sql = "SELECT * from tbl_admin WHERE admin_email='$admin_email' AND admin_password='$admin_password'";
		$result = mysqli_query($conn,$sql);
		return $result;
	}

	public function get_admin_by_id_password($admin_id,$admin_password)
	{   
		$conn = $this->connect_db(); 
		 	
		$sql = "SELECT * from tbl_admin WHERE id='$admin_id' AND admin_password='$admin_password'";
		$result = mysqli_query($conn,$sql);
		return $result;
	}

	public function update_admin_password($admin_id,$admin_password)
	{   
		$conn = $this->connect_db(); 
		 	
		$sql = "UPDATE tbl_admin SET admin_password='$admin_password' WHERE id='$admin_id'";
		$result = mysqli_query($conn,$sql);
		return $result;
	}

	/*-------------------------------------  Dashboard  -----------------------------------*/	
	/*-------------------------------------------------------------------------------------*/
	
		
		
	/*------------------------------------  tbl category  -----------------------------------*/	
	/*---------------------------------------------------------------------------------------*/ 
	
	public function get_category_count()
	{
		$conn = $this->connect_db(); 		
		$sql = "SELECT count(*) as cat_count FROM tbl_category";
		$result = mysqli_query($conn,$sql);
		return $result;
	}
	
	public function get_category()
	{
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_category ORDER BY category_name ASC";
		$result = mysqli_query($conn,$sql);
		return $result;
	}	
	
	public function get_active_category()
	{
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_category WHERE is_active = 'YES' ORDER BY category_name ASC";
		$result = mysqli_query($conn,$sql);
		return $result;
	}	
	
	public function get_category_by_name($category_name)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_category WHERE category_name = '$category_name'";
		$result = mysqli_query($conn,$sql);
		return $result;
	}	
	
	public function get_category_by_id($category_id)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_category WHERE id = '$category_id'";
		$result = mysqli_query($conn,$sql);
		return $result;
	}	
	
	public function get_category_by_name_not_id($category_id,$category_name)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_category WHERE id != '$category_id' AND category_name = '$category_name'";
		$result = mysqli_query($conn,$sql);
		return $result;
	}	
	
	public function add_category($category_name,$category_image,$created_date)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "INSERT INTO tbl_category (category_name,category_image,created_date) VALUE ('$category_name','$category_image','$created_date')";
		$result = mysqli_query($conn,$sql);
		if($result)
		{
			return true;
		}
		else
		{
			return false;
		}	
	}

	public function update_category($category_id,$category_name,$category_image)
	{
		$conn = $this->connect_db(); 		
		$sql = "UPDATE tbl_category SET category_name='$category_name',category_image='$category_image' WHERE id = '$category_id'";
		$result = mysqli_query($conn,$sql);
		if($result)
		{
			return true;
		}
		else
		{ 
			return false;
		}
	}
	
	public function update_category_date($category_id,$created_date)
	{
		$conn = $this->connect_db(); 		
		$sql = "UPDATE tbl_category SET created_date = '$created_date' WHERE id = '$category_id'";
		$result = mysqli_query($conn,$sql);
		if($result)
		{
			return true;
		}
		else
		{ 
			return false;
		}
	}
	
	public function remove_category_by_id($category_id)
	{  			
		$conn = $this->connect_db(); 		
		// $sql = "UPDATE tbl_category SET is_active = 'NO' WHERE id = '$category_id'";
		$sql = "DELETE FROM tbl_category WHERE id = '$category_id'";
		$result = mysqli_query($conn,$sql);
		if($result)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/*----------------------------------  tbl sub category  ---------------------------------*/	
	/*---------------------------------------------------------------------------------------*/ 
		
	public function get_sub_cat_count()
	{
		$conn = $this->connect_db(); 		
		$sql = "SELECT count(*) as sc_count FROM tbl_sub_category";
		$result = mysqli_query($conn,$sql);
		return $result;
	}
	
	public function get_sub_category()
	{
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_sub_category ORDER BY sub_cate_name ASC";
		$result = mysqli_query($conn,$sql);
		return $result;
	}	
	
	public function get_active_sub_category()
	{  			
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_sub_category WHERE is_active = 'YES' ORDER BY sub_cate_name ASC";
		$result = mysqli_query($conn,$sql);
		return $result;
	}	
	
	public function get_sub_cate_by_name($sub_cate_name)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_sub_category WHERE sub_cate_name = '$sub_cate_name'";
		$result = mysqli_query($conn,$sql);
		return $result;
	}	
	
	public function get_sub_cate_by_id_name($category_id,$sub_cate_name)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_sub_category WHERE category_id = '$category_id' AND sub_cate_name = '$sub_cate_name'";
		$result = mysqli_query($conn,$sql);
		return $result;
	}	
	
	public function get_sub_cate_by_catid($category_id)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_sub_category WHERE category_id = '$category_id'";
		$result = mysqli_query($conn,$sql);
		return $result;
	}	
	
	public function get_sub_cate_by_catid_animate($category_id, $is_animated)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_sub_category WHERE category_id = '$category_id' AND is_animated = '$is_animated'";
		$result = mysqli_query($conn,$sql);
		return $result;
	}	
	
	public function get_active_sub_cate_by_cate_id($category_id, $is_animated)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_sub_category WHERE category_id = '$category_id' AND is_animated = '$is_animated' AND is_active = 'YES' ORDER BY sub_cate_name ASC";
		$result = mysqli_query($conn,$sql);
		return $result;
	}	
	
	public function get_sub_cate_by_catid_subid_name($category_id,$sub_cate_id,$sub_cate_name)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_sub_category WHERE category_id = '$category_id' AND id != '$sub_cate_id' AND sub_cate_name = '$sub_cate_name'";
		$result = mysqli_query($conn,$sql);
		return $result;
	}	
	
	public function get_sub_cate_by_id($sub_cate_id)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_sub_category WHERE id = '$sub_cate_id'";
		$result = mysqli_query($conn,$sql);
		return $result;
	}	
	
	public function add_sub_cate($category_id,$sub_cate_name,$sub_cate_image,$sub_cate_tray_image,$is_animated,$created_date)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "INSERT INTO tbl_sub_category (category_id,sub_cate_name,sub_cate_image,sub_cate_tray_image,is_animated,created_date) VALUE ('$category_id','$sub_cate_name','$sub_cate_image','$sub_cate_tray_image','$is_animated','$created_date')";
		$result = mysqli_query($conn,$sql);
		if($result)
		{
			return true;
		}
		else
		{
			return false;
		}	
	}

	public function update_sub_cate($sub_cate_id,$category_id,$sub_cate_name,$sub_cate_image,$sub_cate_tray_image,$is_animated)
	{
		$conn = $this->connect_db(); 		
		$sql = "UPDATE tbl_sub_category SET category_id='$category_id',sub_cate_name='$sub_cate_name',sub_cate_image='$sub_cate_image',sub_cate_tray_image='$sub_cate_tray_image',is_animated='$is_animated' WHERE id = '$sub_cate_id'";
		$result = mysqli_query($conn,$sql);
		if($result)
		{
			return true;
		}
		else
		{ 
			return false;
		}
	}
	
	public function update_sub_cate_date($sub_cate_id,$created_date)
	{
		$conn = $this->connect_db(); 		
		$sql = "UPDATE tbl_sub_category SET created_date = '$created_date' WHERE id = '$sub_cate_id'";
		$result = mysqli_query($conn,$sql);
		if($result)
		{
			return true;
		}
		else
		{ 
			return false;
		}
	}
		
	public function remove_sub_cate_by_id($sub_cate_id)
	{  			
		$conn = $this->connect_db(); 	
		// $sql = "UPDATE tbl_sub_category SET is_active = 'NO' WHERE id = '$sub_cate_id'";		
		$sql = "DELETE FROM tbl_sub_category WHERE id = '$sub_cate_id'";
		$result = mysqli_query($conn,$sql);
		if($result)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	/*-----------------------------------  tbl sticker Webp ---------------------------------*/	
	/*---------------------------------------------------------------------------------------*/ 
	
	public function get_webp_sticker_count()
	{
		$conn = $this->connect_db(); 		
		$sql = "SELECT count(*) as ws_count FROM tbl_sticker_webp";
		$result = mysqli_query($conn,$sql);
		return $result;
	}
		
	public function get_webp_sticker()
	{
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_sticker_webp ORDER BY sticker_name ASC";
		$result = mysqli_query($conn,$sql);
		return $result;
	}	
	
	public function get_webp_sticker_by_id($sticker_id)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_sticker_webp WHERE id = '$sticker_id'";
		$result = mysqli_query($conn,$sql);
		return $result;
	}		
		
	public function get_webp_sticker_by_sub_cate_id($sub_cate_id)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_sticker_webp WHERE sub_cate_id = '$sub_cate_id'";
		$result = mysqli_query($conn,$sql);
		return $result;
	}		
		
	public function add_webp_sticker($category_id,$sub_cate_id,$sticker_image,$created_date)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "INSERT INTO tbl_sticker_webp (category_id,sub_cate_id,sticker_image,created_date) VALUE ('$category_id','$sub_cate_id','$sticker_image','$created_date')";
		$result = mysqli_query($conn,$sql);
		if($result)
		{
			return true;
		}
		else
		{
			return false;
		}	
	}

	public function update_webp_sticker($category_id,$sub_cate_id,$sticker_image)
	{
		$conn = $this->connect_db(); 		
		$sql = "UPDATE tbl_sticker_webp SET category_id='$category_id',sub_cate_id='$sub_cate_id',sticker_image='$sticker_image' WHERE id = '$sticker_id'";
		$result = mysqli_query($conn,$sql);
		if($result)
		{
			return true;
		}
		else
		{ 
			return false;
		}
	}
	
	public function remove_webp_sticker_by_id($sticker_id)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "DELETE FROM tbl_sticker_webp WHERE id = '$sticker_id'";
		$result = mysqli_query($conn,$sql);
		if($result)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	/*-----------------------------------  tbl sticker Webp ---------------------------------*/	
	/*---------------------------------------------------------------------------------------*/ 
	
	public function get_animated_sticker_count()
	{
		$conn = $this->connect_db(); 		
		$sql = "SELECT count(*) as ws_count FROM tbl_sticker_animated";
		$result = mysqli_query($conn,$sql);
		return $result;
	}
		
	public function get_animated_sticker()
	{
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_sticker_animated ORDER BY sticker_name ASC";
		$result = mysqli_query($conn,$sql);
		return $result;
	}	
	
	public function get_animated_sticker_by_id($sticker_id)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_sticker_animated WHERE id = '$sticker_id'";
		$result = mysqli_query($conn,$sql);
		return $result;
	}		
		
	public function get_animated_sticker_by_sub_cate_id($sub_cate_id)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_sticker_animated WHERE sub_cate_id = '$sub_cate_id'";
		$result = mysqli_query($conn,$sql);
		return $result;
	}		
		
	public function add_animated_sticker($category_id,$sub_cate_id,$sticker_image,$created_date)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "INSERT INTO tbl_sticker_animated (category_id,sub_cate_id,sticker_image,created_date) VALUE ('$category_id','$sub_cate_id','$sticker_image','$created_date')";
		$result = mysqli_query($conn,$sql);
		if($result)
		{
			return true;
		}
		else
		{
			return false;
		}	
	}

	public function update_animated_sticker($category_id,$sub_cate_id,$sticker_image)
	{
		$conn = $this->connect_db(); 		
		$sql = "UPDATE tbl_sticker_animated SET category_id='$category_id',sub_cate_id='$sub_cate_id',sticker_image='$sticker_image' WHERE id = '$sticker_id'";
		$result = mysqli_query($conn,$sql);
		if($result)
		{
			return true;
		}
		else
		{ 
			return false;
		}
	}
	
	public function remove_animated_sticker_by_id($sticker_id)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "DELETE FROM tbl_sticker_animated WHERE id = '$sticker_id'";
		$result = mysqli_query($conn,$sql);
		if($result)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/*------------------------------------  tbl slider  -----------------------------------*/	
	/*---------------------------------------------------------------------------------------*/ 
		
	public function get_slider_count()
	{
		$conn = $this->connect_db(); 		
		$sql = "SELECT count(*) as sl_count FROM tbl_slider";
		$result = mysqli_query($conn,$sql);
		return $result;
	}
	
	public function get_slider()
	{
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_slider ORDER BY slider_name ASC";
		$result = mysqli_query($conn,$sql);
		return $result;
	}	
	
	public function get_active_slider()
	{  			
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_slider WHERE is_active = 'YES' ORDER BY slider_name ASC";
		$result = mysqli_query($conn,$sql);
		return $result;
	}	
	
	public function get_slider_by_name($slider_name)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_slider WHERE slider_name = '$slider_name'";
		$result = mysqli_query($conn,$sql);
		return $result;
	}	
	
	public function get_slider_by_id_name($category_id,$slider_name)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_slider WHERE category_id = '$category_id' AND slider_name = '$slider_name'";
		$result = mysqli_query($conn,$sql);
		return $result;
	}	
	
	public function get_slider_by_catid($category_id)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_slider WHERE category_id = '$category_id'";
		$result = mysqli_query($conn,$sql);
		return $result;
	}	
	
	public function get_slider_by_catid_sid_name($category_id,$slider_id,$slider_name)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_slider WHERE category_id = '$category_id' AND id != '$slider_id' AND slider_name = '$slider_name'";
		$result = mysqli_query($conn,$sql);
		return $result;
	}	
	
	public function get_slider_by_id($slider_id)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "SELECT * FROM tbl_slider WHERE id = '$slider_id'";
		$result = mysqli_query($conn,$sql);
		return $result;
	}	
	
	public function add_slider($category_id,$slider_name,$slider_image,$created_date)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "INSERT INTO tbl_slider (category_id,slider_name,slider_image,created_date) VALUE ('$category_id','$slider_name','$slider_image','$created_date')";
		$result = mysqli_query($conn,$sql);
		if($result)
		{
			return true;
		}
		else
		{
			return false;
		}	
	}

	public function update_slider($category_id,$slider_id,$slider_name,$slider_image)
	{
		$conn = $this->connect_db(); 		
		$sql = "UPDATE tbl_slider SET category_id='$category_id',slider_name='$slider_name',slider_image='$slider_image' WHERE id = '$slider_id'";
		$result = mysqli_query($conn,$sql);
		if($result)
		{
			return true;
		}
		else
		{ 
			return false;
		}
	}
	
	public function remove_slider_by_id($slider_id)
	{  			
		$conn = $this->connect_db(); 		
		$sql = "DELETE FROM tbl_slider WHERE id = '$slider_id'";
		$result = mysqli_query($conn,$sql);
		if($result)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>

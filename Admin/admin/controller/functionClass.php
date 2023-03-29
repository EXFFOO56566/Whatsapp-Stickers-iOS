<?php
error_reporting(E_ALL ^ E_DEPRECATED);
//Create Connection Class
class comman_class
{

//<!---------------------- Clear The Input Tag Value ---------------------->
	
	public static function clear_input_value($text)
	{
		$text = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $text);
		$text = preg_replace("~\<style(.*)\>(.*)\<\/style\>~"," ",$text);		
		$text = preg_replace('/<iframe.*?\/iframe>/i','', $text);
		
		$text = str_replace('SELECT','', $text);
		$text = str_replace('select','', $text);
		$text = str_replace('UPDATE','', $text);
		$text = str_replace('update','', $text);
		$text = str_replace('DELETE','', $text);
		$text = str_replace('delete','', $text);
		$text = str_replace('INSERT','', $text);
		$text = str_replace('insert','', $text);
		
		return $text;		
	}
	
//<!------------------------------- Generate Uniq Id ----------------------------------------->
	
	public static function uniq_ten_digit_num()
	{
		return sprintf("%06d", mt_rand(1, 9999999999));
	}
	
//<!------------------------------- Generate App Id ----------------------------------------->
	
	public static function uniq_app_digit_num()
	{
		return sprintf("%06d%04X", mt_rand(1, 9999999999), mt_rand(32768, 49151));
	}
	
//<!------------------------------- Generate Uniq Id ----------------------------------------->
	
	public static function uniq_id()
	{
		if (function_exists('com_create_guid') === true)
		{
			return trim(com_create_guid(), '{}');
		}
		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}
	
	
//<!-----------------------------------Verification Code -------------------------------------->
	
	public static function verification_code()
	{
		if (function_exists('com_create_guid') === true)
		{
			return trim(com_create_guid(), '{}');
		}
		return sprintf('%04X%04X', mt_rand(0, 65535),mt_rand(0, 65535));
	}
	
//<!--------------------------------- Remove Special Character ---------------------------->
	
	public static function remove_special_character($string)
	{
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}
	
//<!------------------------- Single Uplaod Image For User ------------------------>

	public static function tray_image_upload($image_path)
	{
		$new_image_name = '';
		if(!empty($_FILES["tray_image_file"]["name"]))
		{
			$image_name = $_FILES["tray_image_file"]["name"];	
			$tmp_arr = explode(".",$image_name);
			$img_name = $tmp_arr[0];
			$img_extn = $tmp_arr[1];
			if($img_extn == 'jpg' || $img_extn == 'JPG' || $img_extn == 'png')
			{
				$new_image_name = preg_replace('/[^A-Za-z0-9\-]/', '', $img_name)."_".mt_rand()."_".date('YmdHis').'.'.$img_extn;	
				move_uploaded_file($_FILES["tray_image_file"]["tmp_name"],$image_path.$new_image_name);
			}
		}
		
		return $new_image_name; 
	}
	
//<!------------------------- Single Uplaod Image For User -------------------------->

	public static function single_image_upload($image_path)
	{
		$new_image_name = '';
		if(!empty($_FILES["image_file"]["name"]))
		{
			$image_name = $_FILES["image_file"]["name"];	
			$tmp_arr = explode(".",$image_name);
			$img_name = $tmp_arr[0];
			$img_extn = $tmp_arr[1];
			if($img_extn == 'jpg' || $img_extn == 'JPG' || $img_extn == 'png')
			{
				$new_image_name = preg_replace('/[^A-Za-z0-9\-]/', '',$img_name)."_".mt_rand()."_".date('YmdHis').'.'.$img_extn;	
				move_uploaded_file($_FILES["image_file"]["tmp_name"],$image_path.$new_image_name);
			}
		}
		
		return $new_image_name; 
	}
	
//<!------------------------- Multiple Property Images Uplaod --------------------------->
	
	public static function multiple_png_image_upload($image_path)
	{
		$static_url = array();
		
		if(!empty($_FILES['image_files']['name'][0]))
		{
			for ($i = 0; $i < count($_FILES['image_files']['name']); $i++) 
			{
				$image_name = $_FILES["image_files"]["name"][$i];	
				$tmp_arr = explode(".",$image_name);
				$img_name = $tmp_arr[0];
				$img_extn = $tmp_arr[1];
				if($img_extn == 'PNG' || $img_extn == 'png')
				{
					$new_image_name = preg_replace('/[^A-Za-z0-9\-]/', '',$img_name)."_".mt_rand()."_".date('YmdHis').'.'.$img_extn;
					move_uploaded_file($_FILES['image_files']['tmp_name'][$i],$image_path.$new_image_name);
					
					$static_url[] = $new_image_name;
				}
			}
		}
		return $static_url;
	}
	
	public static function multiple_webp_image_upload($image_path)
	{
		$static_url = array();
		
		if(!empty($_FILES['image_files']['name'][0]))
		{
			for ($i = 0; $i < count($_FILES['image_files']['name']); $i++) 
			{
				$image_name = $_FILES["image_files"]["name"][$i];	
				$tmp_arr = explode(".",$image_name);
				$img_name = $tmp_arr[0];
				$img_extn = $tmp_arr[1];
				if($img_extn == 'webp' || $img_extn == 'WEBP')
				{
					$new_image_name = preg_replace('/[^A-Za-z0-9\-]/', '',$img_name)."_".mt_rand()."_".date('YmdHis').'.'.$img_extn;
					move_uploaded_file($_FILES['image_files']['tmp_name'][$i],$image_path.$new_image_name);
					
					$static_url[] = $new_image_name;
				}
			}
		}
		return $static_url;
	}
	
	public static function multiple_animated_image_upload($image_path)
	{
		$static_url = array();
		
		if(!empty($_FILES['image_files']['name'][0]))
		{
			for ($i = 0; $i < count($_FILES['image_files']['name']); $i++) 
			{
				$image_name = $_FILES["image_files"]["name"][$i];	
				$tmp_arr = explode(".",$image_name);
				$img_name = $tmp_arr[0];
				$img_extn = $tmp_arr[1];
				if($img_extn == 'webp' || $img_extn == 'WEBP')
				{
					$new_image_name = preg_replace('/[^A-Za-z0-9\-]/', '',$img_name)."_".mt_rand()."_".date('YmdHis').'.'.$img_extn;
					move_uploaded_file($_FILES['image_files']['tmp_name'][$i],$image_path.$new_image_name);
					
					$static_url[] = $new_image_name;
				}
			}
		}
		return $static_url;
	}
}

?>



	
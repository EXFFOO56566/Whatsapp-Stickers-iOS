<?php

$slider_result = $data_obj->get_slider_count();
$slider_raw = mysqli_fetch_assoc($slider_result);
$slider_count = $slider_raw['sl_count'];

$category_result = $data_obj->get_category_count();
$category_raw = mysqli_fetch_assoc($category_result);
$category_count = $category_raw['cat_count'];

$sub_cat_result = $data_obj->get_sub_cat_count();
$sub_cat_raw = mysqli_fetch_assoc($sub_cat_result);
$sub_cat_count = $sub_cat_raw['sc_count'];

$webp_sticker_result = $data_obj->get_webp_sticker_count();
$webp_sticker_raw = mysqli_fetch_assoc($webp_sticker_result);
$webp_sticker_count = $webp_sticker_raw['ws_count'];

?>
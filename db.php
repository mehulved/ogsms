<?php
include("wp-blog-header.php");

function query_db($manufacturer, $model) {
	global $wpdb;
	global $table_prefix;
	$query = "SELECT product_id, post_id, model, offindia_mahamp, offindia_roi, onindia from " . $table_prefix. "og_products where model='$model'";
	$result = $wpdb->get_results($query);
	return $result;
}

function db_reply($manufacturer, $model) {
	$result = query_db($manufacturer, $model);
	$pricearray = get_price($result, $manufacturer);
	$off_mah_mp = $pricearray["off_mah_mp"];
	$off_roi = $pricearray["off_roi"];
	$on_india = $pricearray["on_india"];
	$reply = "Price of $manufacturer $model for Maharashtra&MP: $off_mah_mp, for Rest of India: $off_roi, Online: $on_india";
	return $reply;
}

function get_price($result, $manufacturer) {
	foreach ($result as $product) {
		foreach (get_the_category($product->post_id) as $category) {
			if (strtolower($category->cat_name) == strtolower($manufacturer)) {
				$pricearray = array("off_mah_mp" => $product->offindia_mahamp,"off_roi" => $product->offindia_roi, "on_india" => $product->onindia);
				echo $product->offindiamahamp;
			}
		}
	}
	return $pricearray;
}
?>	

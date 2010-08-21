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
	if ($pricearray != null) {
		$off_mah_mp = $pricearray["off_mah_mp"];
		$off_roi = $pricearray["off_roi"];
		$on_india = $pricearray["on_india"];
		$reply_std = "Price of $manufacturer $model ";
		if ($off_mah_mp!=0) {
			$reply_off_mah_mp = " for Maharashtra & MP: $off_mah_mp,";
		}
		else {
			$reply_off_mah_mp = null;
		}
		if ($off_roi!=0) {
			$reply_off_roi = " for Rest of India: $off_roi,";
		}
		else {
			$reply_off_roi = null;
		}
		if ($on_india!=0) {
			$price_on_india = "Online: $on_india";
		}
		else {
			$price_on_india = null;
		}

		$reply = $reply_off_mah_mp . $reply_off_roi . $reply_on_india;
	}
	else {
		$reply = "Sorry! The requested device could not be found.";
	}
	return $reply;
}

function get_price($result, $manufacturer) {
	if (sizeof($result) > 0) {
		foreach ($result as $product) {
			foreach (get_the_category($product->post_id) as $category) {
				if (strtolower($category->cat_name) == strtolower($manufacturer)) {
					$pricearray = array("off_mah_mp" => $product->offindia_mahamp,"off_roi" => $product->offindia_roi, "on_india" => $product->onindia);
					echo $product->offindiamahamp;
				}
			}
		}
	}
	else {
		$pricearray=null;
	}
		return $pricearray;
}

?>	

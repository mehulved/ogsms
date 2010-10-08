<?php
include("wp-blog-header.php");

function query_db($manufacturer, $model) {
	/* This function will take the manufacturer and model number and return the results after querying the database */
	global $wpdb;
	global $table_prefix;
	$query = "SELECT * from " . $table_prefix . "pricesearch where model='$model';";
	$result = $wpdb->get_results($query);
	return $result;
}

function db_reply($manufacturer, $model) {
	/* Gets the manufacturer name and model number from the received message and returns a reply to be sent to the sender */ 
	$result = query_db($manufacturer, $model); //first we query the database
	$pricearray = get_price($result, $manufacturer); //and then filter the results to get the price
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
	/* go through the results and return the price of nearest or exact match */
	if (sizeof($result) > 0) {
		foreach ($result as $product) {
			if (strtolower($product->brand) == strtolower($manufacturer)) {
				$pricearray = array("off_mah_mp" => $product->offline_mh_mp,"off_roi" => $product->offline_roi, "on_india" => $product->online_india);
				print_r ($pricearray);
				echo $product->offindiamahamp;
			}
		}
	}
	else {
		$pricearray=null;
	}
		return $pricearray;
}

?>	

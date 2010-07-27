<?php

include 'db.php';

$msisdn = $_GET["msisdn"]; //Sender's Phone Number
$content = $_GET["content"]; // Content of the SMS
/* 
We will convert the contents from string to array so we can separate each field and fetch it from the database
*/
$content_array = explode(" ",$content); 
$array_length = sizeof($content_array);

if (($array_length<3) or ($array_length>4)) {
	$reply="You have sent a wrong command. Correct command is PRICE Manufacturer ModelNo. eg. PRICE Nokia E71";
}
else {
	$manufacturer = $content_array[1];
	$model = $content_array[2] . " " . $content_array[3];
	$reply=db_reply($manufacturer,$model);
}

$reply = $reply . " \n - Brought to you by www.onlygizmos.com";
$response = array('msisdn'=>$msisdn, 'content'=>$reply);
$json_response = json_encode($response);
echo "[$json_response]";

?>

<?php

include 'db.php';

$msisdn = $_GET["msisdn"]; //Sender's Phone Number
$content = $_GET["content"]; // Content of the SMS
/* 
We will convert the contents from string to array so we can separate each field and fetch it from the database
*/
$content_array = explode(" ",$content); 
$array_length = sizeof($content_array);

if ($array_length<3) {
	$reply="You have sent a wrong command. Correct command is PRICE Manufacturer ModelNo. eg. PRICE Nokia E71";
}
else {
	/* First argument is the manufacturer name and what follows is considered as the model number */
	$manufacturer = $content_array[1]; 
	$model = "";
	for ($i=2; $i<=$array_length; $i++) 
	{
		$model .= $content_array[$i] . " ";
	}
	$reply=db_reply($manufacturer,$model);
}

/* Adding our name */
$reply .= " \n - Brought to you by www.onlygizmos.com";

/* store the sender's number and reponse in the variable to be sent to the api, json encode it and send it. */
$response = array('msisdn'=>$msisdn, 'content'=>$reply);
$json_response = json_encode($response);
echo "[$json_response]";

?>

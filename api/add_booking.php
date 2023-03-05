<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Method: *");
require_once "core.php";

sleep(1);




if (
	isset(
		$_POST['date']
	) && !empty($_POST['date'])
	&& isset(apache_request_headers()['token'])
) {
	$token = apache_request_headers()['token'];
	$obj = new visa();
	$obj->add_booking($_POST['date'], $_POST['hours'], $_POST['payment_id'], $_POST['hall_id'], $token);
} else
	echo json_encode(array('message' => 'All fields are required', 'data' => [], 'error' => '', 'code' => 400));

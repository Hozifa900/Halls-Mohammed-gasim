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
		$_POST['hall_name']
	) && !empty($_POST['hall_name'])
	&& isset(apache_request_headers()['token'])
) {
	$token = apache_request_headers()['token'];
	$obj = new visa();
	$obj->add_hall($_POST['hall_name'], $_POST['owner'], $_POST['email'], $_POST['phone'], $_POST['price'], $_POST['services'], $_POST['location'], $_POST['capacity'], $_POST['bank_account_id'], $_POST['bank_account_name'], $_POST['images'], $token);
} else
	echo json_encode(array('message' => 'All fields are required', 'data' => [], 'error' => '', 'code' => 400));

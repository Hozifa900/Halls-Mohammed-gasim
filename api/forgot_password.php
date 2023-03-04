<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Method: *");
require_once "core.php";

sleep(1);



if (isset($_FILES['email'])) {
	$obj->forgot_password($_POST['email']);
} else
	echo json_encode(array('message' => 'Email field is require', 'data' => [], 'error' => '', 'code' => 400));

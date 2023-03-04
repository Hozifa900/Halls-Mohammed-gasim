<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Method: *");
require_once "core.php";


sleep(1);

if (
	isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])
) {
	$obj = new visa();
	$obj->login($_POST['email'], $_POST['password']);
} else {
	echo json_encode(array('message' => 'All fields are required', 'data' => [], 'error' => '', 'code' => 400));
}

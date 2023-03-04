<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Method: *");
require_once "core.php";

sleep(1);
if (isset(apache_request_headers()['token'])) {
    $token = apache_request_headers()['token'];
    $obj = new visa();
    $obj->get_profile($token);
} else {
    echo json_encode(array('message' => 'There is no token in this request', 'data' => '', 'error' => 'token required', 'code' => 400));
}

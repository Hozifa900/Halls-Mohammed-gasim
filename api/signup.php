<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Method: *");
require_once "core.php";

sleep(1);
if (
	isset($_POST['name']) && !empty($_POST['name'])
	&& isset($_POST['phone']) && !empty($_POST['phone'])
	&& isset($_POST['email']) && !empty($_POST['email'])
	&& isset($_POST['password']) && !empty($_POST['password'])
) {
	$obj = new visa();
	$obj->signup($_POST['name'], $_POST['phone'], $_POST['email'], $_POST['password']);
} else {
	echo json_encode(array('message' => 'All fields are required', 'data' => [], 'error' => '', 'code' => 400));
}


/*
echo json_encode(array('your phone' => $_POST['phone'], 'your email' => $_POST['email'], 'your password' => $_POST['password']));
if (isset($_POST['name']))
echo json_encode(array('name' => $_POST['name'].' Succesfly'.$_POST['name']." Ok"));
else
echo json_encode(array('name' => "No name ".$_POST['name']));




fetch('http://touch.extra-laboratory.com/api/signup.php', {
	method: 'POST',
	body: 'name=' + encodeURIComponent('New Pirate Captain') + '&body=' + encodeURIComponent('Arrrrrr-ent you excited?') + '&userID=3',
	headers: {
		'Content-type': 'application/x-www-form-urlencoded'
	}
}).then(function (response) {
	if (response.ok) {
		return response.json();
	}
	return Promise.reject(response);
}).then(function (data) {
	console.log(data);
}).catch(function (error) {
	console.warn('Something went wrong.', error);
});
*/

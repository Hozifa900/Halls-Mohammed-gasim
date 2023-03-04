<?php
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Method: *");
class visa
{
	protected $connect;

	public function __construct()
	{
		$this->connect = mysqli_connect('localhost', 'root', 'root', 'hallsbooking');
	}

	public function __destruct()
	{
		mysqli_close($this->connect);
	}


	/* <---------- This function to register new users --------------------------------> */
	public function signup($name, $phone, $email, $password, $role)
	{
		$sql = " SELECT * FROM `users` WHERE `users`.`email` = '$email' ";
		$query = mysqli_query($this->connect, $sql);
		$num = mysqli_num_rows($query);
		$row = mysqli_fetch_array($query);

		if ($num > 0) {
			echo json_encode(array('message' => "This user already exist.", 'error' => '', 'status' => 400));
		} else {
			// Here the user register with email and password
			$sql = " INSERT INTO `users`(`user_name`, `phone`, `email`, `password`, `role` ) 
					VALUES ('$name', '$phone', '$email', '$password', '$role') ";
			$query = mysqli_query($this->connect, $sql);
			if ($query) {
				$sql = " SELECT * FROM `users` WHERE  `users`.`email` = '$email' ";
				$query = mysqli_query($this->connect, $sql);
				$row = mysqli_fetch_array($query);
				$id = $row['user_id'];
				$str = rand();
				$token = md5($str);
				$sql = " INSERT INTO `user_token`(`user_id`, `token` ) 
					VALUES ('$id', '$token') ";
				$query = mysqli_query($this->connect, $sql);
				$user = array(
					'name' => $name,
					'phone' => $phone,
					'email' => $email,
					'token' => $token
				);
				echo json_encode(array('message' => "User created successfully.", 'data' => $user, 'error' => '', 'code' => 200));
			}
		}
		if (mysqli_error($this->connect)) {
			echo json_encode(array('message' => 'This database error', 'data' => [], 'error' => mysqli_error($this->connect), 'code' => 500));
		}
	}
	/* <----------- Registration End ----------------------------------------------------> */




	/* <----------- This function for login -------------------------------------------------> */
	public function login($email, $password, $role)
	{
		$email = mysqli_real_escape_string($this->connect, $email);
		$password = mysqli_real_escape_string($this->connect, $password);
		$sql = " SELECT * FROM `users` WHERE `users`.`password` = '$password' AND `users`.`email` = '$email' AND `users`.`role` = '$role' ";
		$query = mysqli_query($this->connect, $sql);
		$num = mysqli_num_rows($query);
		$row = mysqli_fetch_array($query);
		if ($num == 1) {
			$id = $row['user_id'];
			$str = rand();
			$token = md5($str);
			$sql = " UPDATE `user_token` SET `user_token`.`token`= '$token' WHERE `user_id` = '$id'";
			$query = mysqli_query($this->connect, $sql);
			$user = array(array(
				'name' => $row['user_name'],
				'phone' => $row['phone'],
				'email' => $row['email'],
				'token' => $token,
			));
			echo json_encode(array('message' => "Signin successfully.", 'data' => $user, 'code' => 200));
		} else
			echo json_encode(array('message' => "Incorrect credential.", 'data' => [], 'code' => 401));

		if (mysqli_error($this->connect)) {
			echo json_encode(array('message' => mysqli_error($this->connect), 'data' => [], 'error' => '', 'code' => 500));
		}
	}
	/* <---------- Login End -------------------------------------------------------------------> */


	/* < ----------- This function to get user information ---------------------------------------> */
	public function get_profile($token)
	{
		$token = mysqli_real_escape_string($this->connect, $token);
		$sql = " SELECT * FROM `user_token` WHERE `user_token`.`token` = '$token'";
		$query = mysqli_query($this->connect, $sql);
		$num = mysqli_num_rows($query);
		if ($num == 1) {
			$r = [];
			$sql = "SELECT * FROM `users`";
			$query = mysqli_query($this->connect, $sql);
			$row = mysqli_fetch_array($query);
			$user = array(
				'name' => $row['user_name'],
				'phone' => $row['phone'],
				'email' => $row['email'],
			);
			echo json_encode(array('message' => "get successfully.", 'data' => $user, 'error' => '', 'code' => 200));
			die();
		} else {
			echo json_encode(array('message' => 'Bad token', 'data' => [$token], 'error' => 'This token is old or invalid', 'code' => 400));
			die();
		}
		if (mysqli_error($this->connect)) {
			echo json_encode(array('message' => mysqli_error($this->connect), 'data' => [], 'error' => 'SQL error', 'code' => 500));
			die();
		}
	}
	/* <---------- Get user info End ----------------------------------------------------------------> */

	/* <--------- This function to add hall ----------------------------------------------------------> */
	public function add_hall($hall_name, $owner, $email, $phone, $price, $services, $location, $capacity, $bank_account_id, $bank_account_name, $images, $token)
	{
		$hall_name = mysqli_real_escape_string($this->connect, $hall_name);
		$owner = mysqli_real_escape_string($this->connect, $owner);
		$email = mysqli_real_escape_string($this->connect, $email);
		$phone = mysqli_real_escape_string($this->connect, $phone);
		$sql = " SELECT * FROM `user_token` WHERE `user_token`.`token` = '$token' ";
		$query = mysqli_query($this->connect, $sql);
		$num = mysqli_num_rows($query);
		$row = mysqli_fetch_array($query);
		$user_id = $row['user_id'];
		if ($num > 0) {
			// then submit the order details .............. ..... .. .. . . .. .... .. .. 
			$sql = " INSERT INTO `halls`(`hall_name`, `owner`, `email`,`phone`, `price`, `services`, `location`, `capacity`, `bank_account_id` , `bank_account_name` , `images`  ) 
							VALUES ('$hall_name', '$owner', '$email', '$phone', '$price', '$services', '$location', '$capacity', '$bank_account_id', '$bank_account_name', '$images') ";
			$query = mysqli_query($this->connect, $sql);

			if ($query) {
				echo json_encode(array('message' => 'Hall added successfully', 'data' => [], 'error' => '', 'code' => 200));
				die();
			}
		} else {
			echo json_encode(array('message' => "Bad token.", 'data' => [], 'error' => '', 'code' => 400));
			die();
		}
		if (mysqli_error($this->connect)) {
			echo json_encode(array('message' => 'server error', 'data' => [], 'error' => mysqli_error($this->connect), 'code' => 500));
			die();
		}
	}
	/* <-------- Add hall End --------------------------------------------------------------------> */


	/* <---------- This function to get booking -----------------------------------------------------------> */
	public function get_booking($token)
	{
		$token = mysqli_real_escape_string($this->connect, $token);
		$sql = " SELECT * FROM `user_token` WHERE `user_token`.`token` = '$token'";
		$query = mysqli_query($this->connect, $sql);
		$num = mysqli_num_rows($query);
		$row = mysqli_fetch_array($query);

		if ($num == 1) {
			$r = [];
			$sql = "SELECT * FROM `booking`, `halls`, `users` WHERE `users`.`user_id` = `booking`.`user_id` AND `halls`.`hall_id` = `booking`.`hall_id`  ORDER BY `order`.`id` DESC";
			$query = mysqli_query($this->connect, $sql);
			$i = 0;
			while ($row = mysqli_fetch_array($query)) {
				$r[$i] = array(
					'hall_name' => $row['hall_name'], 'owner' => $row['owner'],
					'email' => $row['email'], 'phone' => $row['phone'],  'price' => $row['price'],
					'services' => 'services', 'location' => 'location', 'capacity' => $row['capacity'],
					'bank_account_id' => $row['bank_account_id'], 'bank_account_name' => $row['bank_account_name'], 'images' => $row['images'],
					'date' => $row['date'], 'hours' => $row['hours'], 'payment_id' => $row['payment_id'],
					'user_name' => $row['user_name']

				);
				$i++;
			}
			echo json_encode(array('message' => 'get successfully.', 'data' => $r, 'error' => '', 'code' => 200));
			die();
		} else {
			echo json_encode(array('message' => 'Bad token', 'data' => [$token], 'error' => 'This token is old or invalid', 'code' => 400));
			die();
		}
		if (mysqli_error($this->connect)) {
			echo json_encode(array('message' => mysqli_error($this->connect), 'data' => [], 'error' => 'SQL error', 'code' => 500));
			die();
		}
		/* <------------ Get booking End ---------------------------------------------------------> */
	}
}

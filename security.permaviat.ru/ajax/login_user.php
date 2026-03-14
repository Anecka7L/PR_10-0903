<?php
	session_start();
	require_once("../settings/connect_datebase.php");
	require_once("../libs/autoload.php");
	
	$login = $_POST['login'];
	$password = $_POST['password'];
	

	if(isset($_POST["g-recaptcha-response"]) == false){
		echo "Нет пройденной \"Я не робот\"";
		exit;
	}
	
	$Secret = "6Lc37YYsAAAAAJCnHMhwAZEE3spSqFEJvOIC18V2";
	$Recaptcha = new \ReCaptcha\ReCaptcha($Secret);
	$Response = $Recaptcha->verify($_POST["g-recaptcha-response"], $_SERVER['REMOTE_ADDR']);

	if(!$Response->isSuccess()){
		echo "Пользователь не распознан.";
		exit;
	}
	
	// ищем пользователя
	$query_user = $mysqli->query("SELECT * FROM `users` WHERE `login`='".$login."' AND `password`= '".$password."';");
	
	$id = -1;
	while($user_read = $query_user->fetch_row()) {
		$id = $user_read[0];
	}
	
	if($id != -1) {
		$_SESSION['user'] = $id;
	}
	echo md5(md5($id));
?>

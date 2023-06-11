<?php

function est_connecter():bool{
	if (session_status()=== PHP_SESSION_NONE) {
		session_start();
	}
	return !empty($_SESSION['connecte']);

}
function force_user_connecte():void{
	if (!est_connecter()) {
	unset($_SESSION['connecte']);
	header('Location: /login.php');
	exit();
	}
}


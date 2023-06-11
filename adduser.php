<?php
session_start();

//Open a new connection to the MySQL server
$mysqli = new mysqli('localhost', 'root', '', 'pharmacie');

//Output any connection error
if ($mysqli->connect_error) {
    die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$nom_client = mysqli_real_escape_string($mysqli, $_POST['nom_client']);
$prenom_client = mysqli_real_escape_string($mysqli, $_POST['prenom_client']);
$mail = mysqli_real_escape_string($mysqli, $_POST['mail']);
$numero_client=mysqli_real_escape_string($mysqli, $_POST['numero_client']);
$password = mysqli_real_escape_string($mysqli, $_POST['password']);

function isAjax(){
	return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
}

//VALIDATION
	//VALIDATION
preg_match("#[7][0,5-8][0-9]{7}#",$numero_client,$num_valid);

if (strlen($nom_client) < 2){
    echo "nom_client";
} elseif (strlen($prenom_client) < 3) {
    echo "prenom_client";
} elseif ( (strlen($numero_client)<9) && (!$num_valid)){
	echo "numero_client";
} elseif (strlen($mail) <= 4) {
    echo "eshort";
} elseif (filter_var($mail, FILTER_VALIDATE_EMAIL) === false) {
    echo "eformat";
} elseif (strlen($password) <= 4) {
    echo "pshort";
	
//VALIDATION
	
} else {
	
	//PASSWORD ENCRYPT
	$spassword = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
	
	$query = "SELECT * FROM client_tbl WHERE mail='$mail'";
	$result = mysqli_query($mysqli, $query) or die(mysqli_error());
	$num_row = mysqli_num_rows($result);
	$row = mysqli_fetch_array($result);
	
	
		if ($num_row < 1) {

			$insert_row = $mysqli->query("INSERT INTO client_tbl (nom_client, prenom_client,numero_client,mail, password) VALUES ('$nom_client', '$prenom_client','$num_valid[0]','$mail','$spassword')");

			if ($insert_row) {
				$_SESSION['login'] = $mysqli->insert_id;
				$_SESSION['nom_client'] = $nom_client;
				$_SESSION['prenom_client'] = $prenom_client;

				echo 'true';
			}

		} else {

			echo 'false';

		}
		
}









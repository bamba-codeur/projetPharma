<?php
try {
	$bdd= new PDO('mysql:host=localhost;dbname=pharmacie;charset=utf8','root','',[
	PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE=> PDO::FETCH_OBJ
	]);
	
} catch (Exception $e) {
	echo die('Erreur :'. $e->getMessage());	
}
?>
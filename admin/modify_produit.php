<?php
session_start();
if(!isset($_SESSION['mdp'])){
	header("Location:index.php");
}
?>
<?php
require_once('../connexion.php');


$req=$bdd->prepare("select nom_produit,prix_produit,mode_emploi,stock_initial from produit_tbl where id_produit=?");
$rep=$req->execute(array($_GET['mod_id']));
foreach ($req as $donnees){
 
}
//-----deconnexion
if (isset($_GET['logout'])){
		unset($_SESSION['mdp']);
}

?>


<!DOCTYPE html>
<html>
<head>
	<title>page de modication des produits</title>
	<meta charset="utf-8">
</head>
<body>
	<a href="index.php?$_GET['logout']"><input type="button" name="deconnexion" value="deconnexion"></a>
	<h1>Bienvenue dans la page de modifation des produits </h1>
	<form method="post" action="" enctype="multipart/form-data">
		<fieldset>
		<br><label for="nom">MEDICAMENT:</label><input type="text" name="produits" value="<?= $donnees->nom_produit ?>"><br>
		<br><label for="price">PRIX:</label><input type="text" name="price" value="<?= $donnees->prix_produit ?>"><br>
		<br><label for="emploi">MODE EMPLOI:<br></label><textarea cols="25" rows="10" name="emploi"><?= $donnees->mode_emploi ?></textarea><br>
		<br><label for="stock">STOCK:</label><input type="text" name="stock" value="<?= $donnees->stock_initial ?>"><br>
		<br><input type="submit" name="modifier" value="modifier">
		</fieldset>
	</form>
<?php
if (isset($_POST['modifier'])) {
	$nom_produit=$_POST['produits'];
	$emploi=htmlspecialchars($_POST['emploi']);
	$price=$_POST['price'];
	$stock=$_POST['stock'];
	$id=$_GET['mod_id'];
	$newDate = date("Y-m-d H:i:s");
	$update=$bdd->prepare("UPDATE produit_tbl  SET nom_produit='$nom_produit',prix_produit='$price',mode_emploi=:emploi,date_approvision='".$newDate."',stock_initial='$stock',stock_restant='$stock' where id_produit='$id';");
	$update->bindParam(':emploi', $emploi, PDO::PARAM_STR);
	$update->execute();
	echo "<pre>";
	print_r($update);
	echo "</pre>";
	if ($update) {
		echo "success!";
	}
}





?>
</body>
</html>
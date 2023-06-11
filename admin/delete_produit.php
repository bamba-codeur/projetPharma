<?php
session_start();
if(!isset($_SESSION['mdp'])){

	header("Location:index.php");
}
?>

<?php
require_once('../connexion.php');
$requ="delete from produit_tbl where id_produit='".$_GET['del_id']."'";
$repo=$bdd->query($requ);
header("location: affichage_produit.php");
?> 
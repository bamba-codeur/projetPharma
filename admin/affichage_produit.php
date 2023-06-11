<?php
session_start();
if (!isset($_SESSION['mdp'])){
		header('location:index.php');
}
//-----deconnexion
if (isset($_GET['logout'])){
		unset($_SESSION['mdp']);
}
if(isset ($_SESSION['login']));
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!--font-awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
</head>
<?php
require_once ("../dataconnexion/connexion.php");
$req="select id_produit,nom_produit,mode_emploi,prix_produit,DATE_FORMAT(date_approvision, '%d/%m/%Y à %Hh%imin%ss') AS
date_approvi,stock_initial,stock_restant from produit_tbl";
$rep1=$bdd->query($req);
$result1=$rep1->fetchAll();


?>
<body>
	<a href="ajout_produit.php">ajouter un produit</a>
	<a href="category.php">category</a>
	<h1>Bienvenue!  , <?= $_SESSION['login'] ?></h1>
	<a href="index.php?$_GET['logout']" style="text-align: right;"><input type="button" name="deconnexion" value="deconnexion" ></a>
	<table border="1" cellspacing="0" cellpadding="2">
		<tr>
			<th>NUMERO</th>
			<th>NOM du PRODUIT</th>
			<th>MODE D'EMPLOI</th>
			<th>PRIX</th>
			<th>Date d'approvisionnement</th>
			<th>STOCK Initial</th>
			<th>STOCK Restant</th>

				
		</tr>
		<?php foreach($result1 as $donnees):?>
			<tr>
				<td><?php echo $donnees->id_produit ?> </td>
				<td><?php echo $donnees->nom_produit ?></td>
				<td><?php echo $donnees->mode_emploi ?></td>
				<td><?php echo $donnees->prix_produit ?> F CFA</td>
				<td><?php echo $donnees->date_approvi; ?></td>
				<td><?php echo $donnees->stock_initial ?></td>

				<?php if ($donnees->stock_initial<=200): ?>
					<td style="background-color: red"><?php echo $donnees->stock_restant;   ?>  </td>
				<?php endif ?>
				<?php if ($donnees->stock_initial>200): ?>	
				<td style="background-color: green"><?php echo $donnees->stock_restant;   ?>    </td>
				<?php endif ?>
				<td><img src="photo/<?php echo $donnees->nom_produit?>.jpg"></td>
				<td><input type="button" name="modify" value="MODIFIER" onclick="modifyme(<?=  $donnees->id_produit ?> )"></td>
				<td><input type="button" name="delete" value="SUPPRIMER" onclick="deleteme(<?= $donnees->id_produit ?>)"></td>
			</tr>
		<?php endforeach ?>		
	</table>
	<script type="text/javascript">	
		function modifyme(modid){
			if(confirm("etes vous sur de vouloir modifier ce medicament ?")){

				window.location.href='modify_produit.php?mod_id=' +modid+'';
				return true;
			}
		}
		function deleteme(delid){
			if (confirm("etes vous sur de vouloir supprimer ce medicament")){
					window.location.href='delete_produit.php?del_id=' +delid+'';
				return true ;
			}
		}
	</script>
</body>
</html>
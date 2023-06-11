  <?php
session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<title>ajout produit</title>
	<meta charset="utf-8">
</head>
<?php
require_once ("../dataconnexion/connexion.php");
$req3="SELECT * from category_tbl";
$rep3=$bdd->query($req3);
if(isset($_POST['ajout'])){

$nom_produit=$_POST['nom_produit'];
$emploi=$_POST['emploi'];
$emploi=$bdd->quote($emploi);
$price=$_POST['price'];
$stock=$_POST['stock'];
$category=$_POST['category'];
//recuperation du nom de l'image
$img=$_FILES['img']['name'];
//stockage temporaire
$img_tmp=$_FILES['img']['tmp_name'];
if (!empty($img_tmp)) {
	$image=explode('.', $img);
	$img_ext=end($image);
//faire un test si on a bien entrer une image
	if (in_array(strtolower($img_ext),array('png','jpg','jpeg'))===false){
		echo "ce n'est pas une image";
	}else{
		//recuperer la taille de l'image 
		$img_size=getimagesize($img_tmp);
		//recuperer la forme de 
		if($img_size['mime']=='image/jpeg') {
			$image_src=imagecreatefromjpeg($img_tmp);
		}else if($img_size['mime']=='image/png'){
			$image_src=imagecreatefrompng($img_tmp);
		}else if($img_size['mime']=='image/jpg') {
			$image_src=imagecreatefromjpg($img_tmp);
		}else{
			$img_src=false;
			echo "Veuillez rentrer une image valide";
		}
		//REDIMENSIONNEMENT DE L'IMAGE EN METTANT HAUTEUR 200 ET LARGEGRUR=200
		if ($image_src!==false) {
			$image_width=200;
			if ($img_size[0]==$image_width) {
				$image_finale=$image_src;
			}else{
				$new_width[0]=$image_width;
				$new_height[1]=200;
				$image_finale=imagecreatetruecolor($new_width[0],$new_height[1]);
				imagecopyresampled($image_finale, $image_src,0,0,0,0, $new_width[0],$new_height[1],$img_size[0],$img_size[1]);
			}
			//deplacer notre image kon vient de creer dans le dossier que l'on a cree dans le dossier admin qui s'appelle photo
			imagejpeg($image_finale,'photo/'.$nom_produit.'.jpg');
		}

	}
	
}else{
	echo "insrere un image";
}
$req="SELECT COUNT(*) from produit_tbl where nom_produit='$nom_produit';";
$rep=$bdd->query($req);
//$num_rows=$rep->fetchColumn();
	$newDate = date("Y-m-d H:i:s");
	$insert="INSERT INTO produit_tbl(nom_produit,prix_produit,name_category,mode_emploi,date_approvision,stock_initial,stock_restant) VALUES ('$nom_produit','$price','$category',$emploi,'".$newDate."','$stock',$stock);";	

	$rep1=$bdd->query($insert);
	if ($rep1) {
		echo "correct";
	}else{
		print_r($insert);
		echo 'error';
	}
	header('location:affichage_produit.php');

}


?>
<body>
	<h1>Bienvenue! dans le menu d'ajouter des produit</h1>

	<form method="post" action="ajout_produit.php" enctype="multipart/form-data">
		<fieldset>
			<label for id="nom_produit">NOM DU MEDICAMENT:</label><input type="text" name="nom_produit" id="nom_produit" placeholder="saisir le nom du medicament "><br>
			<br><label for="emploi">MODE EMPLOI:</label><br><textarea name="emploi" id="emploi"></textarea><br>
		<br><label for="price">PRIX :</label><input type="text" name="price" id="price" required="required" placeholder="veuillez saisir le prix du medicament"><br>
		<br><label for="stock">STOCK:</label><input type="text" name="stock" id="stock" required="required" placeholder="saisir la quantite du stock"><br>
		<br><label for="category">Category:</label><select name="category">
													<?php foreach($rep3 as $data): ?>
													<option><?= $data->nom_category ?></option>
													<?php endforeach ?>
													</select><br><br>
		<br><input type="file" name="img"><br>
		<br><input type="submit" name="ajout" value="ajouter"><br>
		</fieldset>
	</form>
</body>
</html>
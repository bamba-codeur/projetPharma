<?php
$title='categorie des produit';
try{
	$bdd= new PDO('mysql:host=localhost;dbname=pharmacie;charset=utf8','root','');

}catch(EXception $e){

	die('Erreur'.$e->getMessage());
}
if (isset($_POST['ajouter']) && isset($_POST['name_category']) ) {
	$category=$_POST['name_category'];
	$req="SELECT  count(*) from category_tbl where nom_category='$category'";
	$rep=$bdd->query($req);
	$num_rows=$rep->fetchColumn();
	if ($num_rows<1) {
		$rep1="INSERT INTO category_tbl(nom_category)values('$category')";
		$req1=$bdd->query($rep1);
	}else{
		echo "this name exist !";
	}

	
}
	$req2="SELECT  * from category_tbl";
	$rep2=$bdd->query($req2);
?>
<!DOCTYPE html>
<html>
<head>
	<title><?= $title ?? 'pharmacie' ?></title>
</head>
<body>
		<h1>Bienvenue dans la page d'insertion de nouvelle categorie</h1>



	<form method="post" action="">
		<label for="nam">nom</label>:<input type="text" name="name_category">
		<input type="submit" name="ajouter" value="ajouter">

	</form>
	<h2>La liste de category qui existe dans la base de donnee</h2>
	<table border="1">
			<tr>
				<th>numero</th>
				<th>Nom</th>
			</tr>
	<?php foreach($rep2 as $data): ?>
			<tr>
				<td><?=$data['id_category']?></td>
				<td><?=$data['nom_category']?></td>

			<tr>
	<?php endforeach ?>


		</table>


</body>
</html>
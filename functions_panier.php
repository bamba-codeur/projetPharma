<?php

function Panier(){
	try {
		$bdd= new PDO('mysql:host=localhost;dbname=pharmacie;charset=utf8','root','');
	
	}catch (Exception $e) {
		echo die('Erreur :'. $e->getMessage());	
	}

	if(!isset($_SESSION['panier'])){

		$_SESSION['panier']=[];
		$_SESSION['panier']['nom_produit']=[];
		$_SESSION['panier']['quantite_produit']=[];
		$_SESSION['panier']['prix_produit']=[];
		$_SESSION['panier']['verrou']=false;
		$select=$bdd->query("SELECT tva from produit_tbl");
		//$data=$select->fetch(PDO::FETCH_OBJ);
		//$_SESSION['panier']['tva']=$data['tva'];
	}
	return true;
}
function ajouterArticle($nom_produit,$quantite_produit,$prix_produit){ 
	if(Panier()&& !isVerrouille()){
		$position_produit=array_search($nom_produit, $_SESSION['panier']['nom_produit']);

		if ($position_produit!==false){
			$_SESSION['panier']['quantite_produit'][$position_produit]+=$quantite_produit;
		}else{

			array_push($_SESSION['panier']['nom_produit'],$nom_produit);
			array_push($_SESSION['panier']['quantite_produit'],$quantite_produit);
			array_push($_SESSION['panier']['prix_produit'],$prix_produit);			
		}
	}else{
		echo "erreur veuillez conctacter l'administrateur";
	}
}
function modifierQTeArticle($nom_produit,$quantite_produit){
	if (Panier()&& !isVerrouille()) {
			if ($quantite_produit>0) {
				$position_produit=array_search($nom_produit,$_SESSION['panier']['nom_produit']);
				if ($position_produit!==false){
					$_SESSION['panier']['quantite_produit'][$position_produit]=$quantite_produit;
				}
			}else{

				supprimerArticle($nom_produit);
			}
	}else{
		echo "Erreur veuillez contacter un admin";
	}

}
function supprimerArticle($nom_produit){
	if (Panier() && !isVerrouille()) {
		$tmp=[];
		$tmp['nom_produit']=[];
		$tmp['quantite_produit']=[];
		$tmp['prix_produit']=[];
		$tmp['verrou']=$_SESSION['panier']['verrou'];
		//$tmp['tva']=$_SESSION['panier']['tva'];
		for ($i=0; $i <count($_SESSION['panier']['nom_produit']) ; $i++){ 
			if ($_SESSION['panier']['nom_produit'][$i]!=$nom_produit) {
				array_push($tmp['nom_produit'],$_SESSION['panier']['nom_produit'][$i]);
				array_push($tmp['quantite_produit'],$_SESSION['panier']['quantite_produit'][$i]);
				array_push($tmp['prix_produit'],$_SESSION['panier']['prix_produit'][$i]);		
			}
		}
		$_SESSION['panier']=$tmp;
		unset($tmp);
	}else{
		echo "Erreur,veuillez contacter un administrateur ";
	}
}
function montantGlobal(){
	$total=0;
	if (Panier() && !isVerrouille()) {
	 for ($i=0; $i <count($_SESSION['panier']['nom_produit']) ; $i++){
		if(is_numeric($_SESSION['panier']['quantite_produit'][$i]) && is_numeric($_SESSION['panier']['prix_produit'][$i])){
			$total+=$_SESSION['panier']['quantite_produit'][$i]*$_SESSION['panier']['prix_produit'][$i];
		}else{
			echo "error";
		}
	 }
	}
	return $total;
}
function montantGlobalTva(){
	$total=0;
	for ($i=0; $i <count($_SESSION['panier']['nom_produit']) ; $i++){ 
		$total+=$_SESSION['panier']['quantite_produit'][$i]*$_SESSION['panier']['prix_produit'][$i];
	}
	return $total+$total*$_SESSION['panier']['tva']/100;
}
function supprimerPanier(){
		unset($_SESSION['panier']);
}
function isVerrouille(){
	if (isset($_SESSION['panier']) && isset($_SESSION['verrou'])) {
		return true;
	}else{
		return false ;
	}
}
function compterArticle(){
	if (isset($_SESSION['panier'])) {
		return count($_SESSION['panier']['nom_produit']);
	}else{
		return 0 ;
	}
}
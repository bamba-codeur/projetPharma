<?php

session_start();
ini_set('memory_limit', '256M');
?>
<?php

require_once("include/head.php");
require_once("connexion.php");
require_once("functions_panier.php");
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

$erreur=false;
$action=(isset($_POST['action'])?$_POST['action']:(isset($_GET['action'])?$_GET['action']:null));
if ($action!==null) {
	if (!in_array($action, array('ajout','suppression','refresh'))) 
		$erreur=true;
		$l=(isset($_POST['l'])?$_POST['l']:(isset($_GET['l'])?$_GET['l']:null));
		$q=(isset($_POST['q'])?$_POST['q']:(isset($_GET['q'])?$_GET['q']:null));
		$p=(isset($_POST['p'])?$_POST['p']:(isset($_GET['p'])?$_GET['p']:null));
		$l=preg_replace('#\v#', '', $l);
		$p=floatval($p);
		if (is_array($q)) {
			$QteArticle=array();
			$i=0;
			foreach($q as $contenu){
				$QteArticle[$i++]=intval($contenu);
			}

		}else{
			$q=intval($q);
		}
	
}
if (!$erreur) {
	switch ($action) {
		case 'ajout':
			ajouterArticle($l,$q,$p);
			break;
		
		case 'suppression':
			supprimerArticle($l);
			break;
		case 'refresh':
			for ($i=0; $i <count($QteArticle) ; $i++) { 
				modifierQTeArticle($_SESSION['panier']['nom_produit'][$i],round($QteArticle[$i]));
			}
			break;
			default:

			break;
			
	}
}
$req="SELECT * from produit_tbl;";
$rep=$bdd->query($req);
$reponse=$rep->fetchall();



?>
<div class="container">
	<div class="row">
		<div class="col-xs-8">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title">
						<div class="row">
							<div class="col-xs-6">
								<h5><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</h5>
							</div>
							<div class="col-xs-6">
									<a class="btn btn-success btn-lg" href="index.php" role="button" class=""><span class="glyphicon glyphicon-share-alt"></span> Continue shopping</a>
									
								</button>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<form method="post" action="">
						
						
		<?php
				if (isset($_GET['deletepanier'])&& $_GET['deletepanier']==true) {
					supprimerPanier();
				}
				if (Panier()){
					$nbProduits=count($_SESSION['panier']['nom_produit']);
					$l=isset($l);
				
					$stock=$bdd->query("select count(nom_produit) from produit_tbl where nom_produit='$l' ");
					//mis a jour du panier

					if ($nbProduits<=0) {
							echo "<br><p style='font-size:20px; color:Red;'>Ooops,panier vide!</p>";

					}else{
							for ($i=0; $i <$nbProduits ; $i++): ?>

									<div class="panel-body">
										
									<div class="row">
										<div class="col-xs-2"><img class="img-responsive" src="admin/photo/<?php echo($_SESSION['panier']['nom_produit'][$i]);?>.jpg">
										
										</div>
										<div class="col-xs-4">
											<h4 class="product-name"><strong><?php echo $_SESSION['panier']['nom_produit'][$i]; ?></strong></h4><h4><small></small></h4>
										</div>
										<div class="col-xs-6">
											<div class="col-xs-6 text-right">
												<h6><strong><?php echo $_SESSION['panier']['prix_produit'][$i];?><span class="text-muted">x</span></strong></h6>
											</div>
											<div class="col-xs-4">
												<input type="text" name="q[]" class="form-control input-sm" value="<?php echo $_SESSION['panier']['quantite_produit'][$i]; ?>">
											</div>
											<div class="col-xs-2">
													<a href="panier.php?action=suppression&amp;l=<?= rawurlencode($_SESSION['panier']['nom_produit'][$i]); ?>"><span class="glyphicon glyphicon-trash"></span></a> 
											</div>
										</div>
									</div>
									
								</form>	
											<?php endfor ?>
												
								
								<?php } 			
					
								}

							 	?>
							 	<hr>
									<div class="row">
										<div class="row align-items-right">
											<div class="col-xs-3">
												<h6 class="text-right" style="color: green">Added items?</h6>
											</div>
											<div class="col-xs-3">
												<input type="submit" value="rafraichir" type="button" class="btn btn-success" >
											</div>
											<div class="col-xs-3">
												<input type="hidden" name="action" value="refresh"/>
														<a href="?deletepanier=true" style="color: green">Supprimer le panier</a>
											</div>
										</div>
									</div>
								</div>
							 	<div class="panel-footer">
									<div class="row text-center">
										<div class="col-xs-9">
											<h4 class="text-right">Total <strong>:<?php echo montantGlobal()." FCFA"; ?></strong></h4>
										</div>
										<div class="col-xs-3">
											<button type="button" class="btn btn-success btn-block">
												Checkout
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>	
<?php

require_once("include/footer.php");

?>
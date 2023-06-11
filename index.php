<?php
session_start();
require_once "functions_panier.php";
require_once "include/head.php";
require_once "include/slide.php";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";



?>


<?php
require_once "dataconnexion/connexion.php";


$req="SELECT * from produit_tbl;";
$rep=$bdd->query($req);
$reponse=$rep->fetchall();
?>
        <div class="row">
          <?php foreach($reponse as $donnees): ?>
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              
              <a href="#"><img class="card-img-top" src="admin/photo/<?php echo htmlentities($donnees->nom_produit);?>.jpg" alt=""></a>
              <div class="card-body">
                <h4 class="card-title">
                  <a href="#"></a>
                </h4>
                <h4><?= htmlentities($donnees->nom_produit )?></h4>
                <h5><?= $donnees->prix_produit ?>FCFA</h5>
               <?php if ($donnees->stock_restant!=0) { ?><button type="submit" name="add" class="btn btn-warning my-3" ><a href="panier.php?action=ajout&amp;l=<?php echo $donnees->nom_produit ?>&amp;q=1&amp;p=<?php echo $donnees->prix_produit ?>" style="color:black;">Ajouter au panier<i class="fas fa-shopping-cart" class="btn btn-success"></i></a></button><?php }else{echo '<h5 style="color:red;">Stock epuise ! </h5>';}?>
               <input type="hidden" name="id_produit" value="<?php echo $donnees->id_produit ?>">
              </div>
              <div class="card-footer">
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
              </div>
            </div>
          </div>
        <?php endforeach ?>
    

      


<?php
require_once('include/footer.php');
?> 
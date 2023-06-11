<?php

$error=null;
if (isset($_POST['ok'])){
	if (isset($_POST['login']) and isset($_POST['mdp'])) {
		if ($_POST['mdp']=='1234') {
			$_SESSION['login']=$_POST['login'];
			$_SESSION['mdp']='1234';
			session_start();
			$_SESSION['connecte']==1;
			header("location:affichage_produit.php");
		}	
	else{
		$error="Mot de passe incorrect!";
	}
}
}
require_once "auth.php";
if( est_connecter()){
	header('Location: /affichage_produit.php');
}

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<!--font-awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link rel="stylesheet" type="text/css" href="style.css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="decore.css">
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


<!--Pulling Awesome Font -->
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
<!--
<h1>Bienvenue Dans la page administrateur , veuillez le mot de passe</h1>
<form method="POST">
	<fieldset>
		<label for="login">Login:</label><input type="text" name="login" id="login" required="required"><br>
		<br><label for="mdp">Password</label><input type="Password" name="mdp" required="required"><br>
		<br><input type="submit" name="ok" value="confirmer">
	</fieldset>
-->
	

<div class="container">
	<?php if($error): ?>
	<div class="alert alert-danger"><?= $error ?></div>
	<?php endif ?>
    <div class="row">
        <div class="col-md-offset-5 col-md-3">
        	<form method="post">
            <div class="form-login">
            <h4>ADMIN.</h4>
            <input type="text" id="login" name="login" class="form-control input-sm chat-input" placeholder="username" />
            </br>
            <input type="text" id="mdp" name="mdp" class="form-control input-sm chat-input" placeholder="password" />
            </br>
            <div class="wrapper">
            <span class="group-btn">     
                <input type="submit" name="ok" id="ok" class="btn btn-success" ><i class="fa fa-sign-in"></i>
            </span>
            </div>
            </div>
            </form>
        
        </div>
    </div>
</div>

</body>
</html>
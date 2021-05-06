<?php
 	require_once('bd.php');
 	require('utilisateur.php');

 	$stateMsg = "";

	if(isset($_POST["valider"])){
	    $pseudo = $_POST["pseudo"];
	    $hashMdp = md5($_POST["mdp"]);
	    
	    $db = getDB();
	    
	    $exist = getUserUtilisateur($db, $pseudo, $hashMdp);

	    if($exist){
	        setConnected($db, $pseudo);
	        $_SESSION["logged"] = "Déconnexion";
	        header('Location: page_accueil.php');
	        exit();
	    } else{
	        $stateMsg = "Le couple pseudo/mot de passe ne correspond &agrave; aucun utilisateur enregistr&eacute;";
	    }
	}


?>

<!doctype html>
<html lang="fr">
	<head>
	  <meta charset="utf-8">
	  <title>Connexion pour modifier le catalogue</title>
	  <link rel="stylesheet" href="style.css">
	</head>

	<body>
		<div class="loginBanner">
			<h1>Connexion pour modifier le catalogue</h1>
		    <div class="errorMsg"><?php echo $stateMsg; ?></div>
		    <?php if(isset($successMsg)){echo $successMsg;} ?>
		        <form action="index.php" method="POST">
		            <table>
		                <tr>
		                	<td class="loginInfo">Pseudo</td><td><input type="text" name="pseudo"></td>
		               		<td class="loginInfo">Mot de passe</td><td><input type="password" name="mdp"></td>
		               		<td><input class="button" type="submit" name="valider" value="Se connecter"></td>
		                </tr>       
		                <br/>	                
		            </table>
		        </form>
		   </div>
	</body>
</html>
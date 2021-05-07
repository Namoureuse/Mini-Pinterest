<?php
	session_start();
 	require_once('bd.php');
 	require('utilisateur.php');
	$db = getDB();
 	$stateMsg = "";
 	$isConnected = isConnected();

	if ($isConnected){
	  $user = getUserFromSession($db, $_SESSION['userId']);
	} else {
	  $user = null;
	}
	if(!is_null($user)){
	  $connectionTime = connectionTime($user['connectedOn']);
	} else {
	  $connectionTime = null;
	}
   
   	if (isset($_POST['valider'])) {
   		$error = false;
   		$user = null;
        $pseudo = $_POST["pseudo"];
        $pwd = $_POST["motdepasse"];

	    if (empty($pseudo)){
	      $wrongpseudo = "Pseudo incorrect.";
	      $error = true;
	    } else {
	          $pseudo = tests($pseudo);
	          $wrongpseudo = "";
	    }
	    if (empty($pwd)) {
	          $wrongpwd = "Mot de passe incorrect.";
	          $error = true;
	    } else {
	          $pwd = tests($pwd);
	    }

	    if(!$error){
	    	$user = getUserFromConnection($db, $pseudo, $pwd);

	    	if (!$user){
	    		$error = true;
	    		$stateMsg = "Pseudo/mot de passe incorrect.";
	    	} 
	    	if(!$error && $user["etat"] == "connected") {
	    		$error = true;
	    		$stateMsg = "Déjà connecté.";
	    	}	
	    }

	    if(!$error && !is_null($user)) {
	        setConnectedUtilisateur($db, $user["id"]);
	        $_SESSION["userId"] = $user["id"];
	        header('Location:page_accueil.php');
	        exit();
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
		<div>
	        <?php if($isConnected){
	            echo "Utilisateur : " .  $user['pseudo'] . "</br>Connecté depuis : " . $connectionTime;
	          }
	        ?> 
     	</div>
		<div class="loginBanner">
			<h1>Connexion pour modifier le catalogue</h1>
				<?php if(!$isConnected){ ?>
					<form action="connexion.php" method="post">
			            <table>
			                   	<td class="loginInfo">Pseudo</td><td><input type="text" name="pseudo" id="pseudo" placeholder="Pseudo">
	                            <small class="col-10">
	                                <?php
	                                if(isset($wrongpseudo) && $wrongpseudo){
	                                   echo '<p class="error">' . $wrongpseudo . '<p>';
	                                }
	                                ?>
	                            </small></td>
			               		<td class="loginInfo">Mot de passe</td><td><input type="password" name="motdepasse">
	                               <small class="col-10">
	                               <?php
	                                if(isset($wrongpwd) && $wrongpwd){
	                                    echo '<p class="error">' . $wrongpwd . '<p>';
	                                }
	                                ?>
	                            </small></td>
			               		<td><input class="button" type="submit" name="valider" value="Se connecter"></td>
			                </tr>       
			                <br/>	                
			            </table>
			        </form>
			<?php	} else {?>

		   </div>

		   <div>
		   		Déjà connecté
		   </div>

		<?php } ?>

			<div>
		   		<a href="page_accueil.php"> Page d'accueil </a>
		   </div>
           
<?php
	function tests($donnees){
	  $donnees = trim($donnees);
	  $donnees = stripslashes($donnees);
	  $donnees = htmlspecialchars($donnees);
	  return $donnees;
	}
?>
</body>
</html>
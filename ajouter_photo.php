<?php
	session_start();
 	require_once('bd.php');
 	require_once('utilisateur.php');
 	$db=getDB();

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
   		$fichier = $_POST["fichier"];
   		//$file = $_FILES['fichier'];
        $description = $_POST["description"];
        $cat = $_POST["cat"];

        //var_dump($fichier, $file);

       	if (empty($description)){
	      $wrongdescription = "Description vide.";
	      $error = true;
	    } else {
	          $description = tests($description);
	          $wrongdescription = "";
	    }
	    if (empty($cat)){
	      $wrongcat = "Il faut choisir une catégorie !";
	      $error = true;
	    } else {
	          $description = tests($description);
	          $wrongdescription = "";
	    }
	    if(!$error){
	    	addPicture($db, $fichier, $description, $cat, $_SESSION['userId']);
	    	//header('Location:affichage.php?photoId.php');
	        //exit();
	    }
	}

 	$queryCategories = executeQuery($db, "SELECT * FROM categorie");
	$categories = $queryCategories->fetch_all(MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="fr">
	<head>
	    <meta charset="utf-8">
	    <title>Ajouter une photo</title>
	    <link rel="stylesheet" href="style.css">
	</head>

	<body>
		<div>
	        <?php if($isConnected){
	            echo "Utilisateur : " .  $user['pseudo'] . "</br>Connecté depuis : " . $connectionTime;
	          }
	        ?> 
     	</div>
		<h1>
			Quelle photo?
		</h1>
		<form action="ajouter_photo.php" method="post">
			<div>
				<table>
					<tr><td>Choisir le fichier:</td></tr>
					<tr><td><input type="file" name="fichier" accept=".png, .jpg, .jpeg, .gif"> </td></tr>
					<tr><td>Décrire la photo une en phrase:</td></tr>
					<tr><td><textarea name="description" id="description"></textarea></td></tr>
					<tr><td>Choisir une catégorie:</td></tr>
					<tr><td><select name="cat" >
	                  	<?php
	                      foreach ($categories as $categorie) {
	                          $selected = (isset($_POST['cat']) && $_POST['cat'] == $categorie['catId'])
	                            ? " selected"
	                            : "";
	                          echo "<option value=".$categorie['catId'].$selected.">".$categorie['nomCat']."</option>";
	                    }
	                  ?></td></tr>
				</table>
				<div>
					<input class="button" type="submit" name="valider" value ="Valider">
				</div>
			</div>
		</form>

		<?php
			/*Cette fonction doit être définie hors d'une condition (if/else), donc on la définie avant de l'utiliser dans une boucle*/
			function tests($donnees){
			    $donnees = trim($donnees); //trim supprime les espaces (ou d'autres caractères) en début et fin de chaîne
			    $donnees = stripslashes($donnees); //stripslashes supprime les antislashs d'une chaîne
			    $donnees = htmlspecialchars($donnees); //htmlspecialchars convertit les caractères spéciaux en entités HTML
			    return $donnees;
			}
		?>
	</body>
</html>

<?php
	closeConnexion($db);
?>

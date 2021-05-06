<?php
	session_start();
 	require_once('bd.php');
 	$db=getDB();

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
		<h1>
			Quelle photo?
		</h1>
		<form action="ajouter_photo.php" method="post">
			<div>
				<table>
					<tr><td>Choisir le fichier:</td></tr>
					<tr><td><input type="file" name="fichier"></td></tr>
					<tr><td>Décrire la photo une en phrase:</td></tr>
					<tr><td><textarea name="describe" id="describe"></textarea></td></tr>
					<tr><td>Choisir une catégorie:</td></tr>
					<tr><td>					<select name="cat" >
	                  <?php
	                      foreach ($categories as $categorie) {
	                          $selected = (isset($_GET['cat']) && $_GET['cat'] == $categorie['catId'])
	                            ? " selected"
	                            : "";
	                          echo "<option value=".$categorie['catId'].$selected.">".$categorie['nomCat']."</option>";
	                      }
	                  ?></td></tr>
				</table>
				<div>
					<input type="button" name="valider" value ="Valider">
				</div>
			</div>
		</form>
		
	</body>
</html>

<?php
	closeConnexion($db);
?>

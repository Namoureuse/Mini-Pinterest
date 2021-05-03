<?php session_start();
	require_once ('bd.php');

	$db=getDB($dbHost,$dbUser,$dbPwd, $dbName);
	$repertoire="data/";

	$photoID=$_GET['photoId'];
	$_SESSION['photoId']=$photoID;
	if(isset($_SESSION['']))
?>

<!doctype html>
<html lang="fr">
	<head>
	    <meta charset="utf-8">
	    <title>Détails Mini-Pinterest</title>
	    <link rel="stylesheet" href="style.css">
	    <link rel="stylesheet" href="bootstrap.css">
	    <link rel="stylesheet" href="page_acceuil.css">
	</head>

	<body>
		<?php
		    if(isset($_GET['photoId']) && $_GET['photoId'] != "") {
		      $queryPhoto = executeQuery($db, "SELECT * FROM photo WHERE photoId =".$_GET['photoId']);
		      $photo = $queryPhoto->fetch_assoc();
		      $photoName = $photo['nomFich'];
		      $photoDesc = $photo['description'];
		      $queryCat = executeQuery($db, "SELECT nomCat FROM categorie NATURAL JOIN photo WHERE photoId =".$_GET['photoId']);
		      $categ = $queryCat->fetch_assoc();
		      $categName = $categ['nomCat'];
		    }
		?>

		<h1>
			Détails de l'image 
		</h1>

		<div>
			<a href="page_accueil.php"> Retour à la page d'accueil </a>
		</div>

		<div>
			<?php
				echo "<img src='" . $photoName . "' class = 'photo'/>";
				echo "Description : " . $photoDesc;
				echo "Nom du fichier : " . $photoName;
				echo "Catégorie : " . $categName;
			?>
		</div>
	</body>
</html>

<?php
	closeConnexion($db);
?>

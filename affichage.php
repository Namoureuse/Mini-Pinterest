<?php 
	session_start();
	require_once ('bd.php');

	$db=getDB();
	$repertoire="data/";

	$photoID=$_GET['photoId'];
?>

<!doctype html>
<html lang="fr">
	<head>
	    <meta charset="utf-8">
	    <title>Détails Mini-Pinterest</title>
	    <link rel="stylesheet" href="style.css">
	</head>

	<body>
		<?php
		    if(isset($_GET['photoId']) && $_GET['photoId'] != "") {
		      $queryPhoto = executeQuery($db, "SELECT * FROM photo WHERE photoId =".$_GET['photoId']);
		      $photo = $queryPhoto->fetch_assoc();
		      $photoName = $photo['nomFich'];
		      $photoDesc = $photo['description'];
		      $queryCat = executeQuery($db, "SELECT * FROM categorie NATURAL JOIN photo WHERE photoId =".$_GET['photoId']);
		      $categ = $queryCat->fetch_assoc();
		      $categName = $categ['nomCat'];
		      $categId = $categ['catId'];
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
				echo "<img src='" . $photoName . "' class = 'photo_detail'/>";
			?>

			<table class="tab">
				<tr class="ligne">
					<td class="bordure">
						Description
					</td>
					<td class="bordure">
						<?php
							echo $photoDesc;
						?>
					</td>
				</tr>
				<tr>
					<td class="bordure">
						Nom
					</td>
					<td class="bordure">
						<?php
							echo $photoName;
						?>
					</td>
				</tr>
				<tr>
					<td class="bordure">
						Catégorie
					</td>
					<td class="bordure">
						<?php
							echo "<a href='page_accueil.php?cat=" . $categId . "'>".$categName."</a>";
						?>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>

<?php
	closeConnexion($db);
?>

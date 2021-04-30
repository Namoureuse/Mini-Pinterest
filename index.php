<?php
	session_start();
	require_once 'bd.php';

	$link = getConnection($dbHost, $dbUser, $dbPwd, $dbName);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Mini-Pinterest</title>
    <link rel="stylesheet" href="style.css">
  </head>

  <body>
  	<div class="div_gris">
  		x photo(s) sélectionnée(s)
  	</div>
  	<div>
  		<form method="post" action="traitement.php">
		    <p>
		        <label for="categorie">Quelles photos souhaitez-vous sélectionner?</label>

		       <select name="categorie" id="categorie">
		       		<option value="all_pictures">Toutes les photos</option>
		       		<option value="autre">Test</option>
		       </select>

		       <input type="submit" value="Valider" />
		    </p>
</form>
  	</div>
  	<div>
  		<h1>Toutes les photos</h1>
  	</div>
  	<div>
  		Affichage des photos
  	</div>
  </body>
 </html>

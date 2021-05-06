<?php
  require_once('bd.php');
  $db=getDB($dbHost,$dbUser,$dbPwd, $dbName);
?>

<!doctype html>
<html lang="fr">
	<head>
	  <meta charset="utf-8">
	  <title>Connexion pour modifier le catalogue</title>
	  <link rel="stylesheet" href="style.css">
	</head>
	
	<body>
		<h1>Connexion pour modifier le catalogue</h1>
	    <div class="loginBanner">
	        <form action="inscription.php" method="POST">
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

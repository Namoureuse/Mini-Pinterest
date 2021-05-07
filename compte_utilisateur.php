<?php
	session_start();
 	require_once('bd.php');
 	require_once('utilisateur.php');
 	//require_once('upload_picture.php');
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
?>

<!doctype html>
<html lang="fr">
  <head>
      <meta charset="utf-8">
      <title>Compte utilisateur</title>
      <link rel="stylesheet" href="style.css">
  </head>

  <body>
  	 <div>
        <?php if($isConnected){
            echo "Utilisateur : " .  $user['pseudo'] . "</br>Connecté depuis : " . $connectionTime;
          }
        ?> 
     </div>
     <h1>Mon compte utilisateur</h1>
     <div>
        <a href="page_accueil.php"> Page d'accueil </a>
     </div>
  </body>
</html>
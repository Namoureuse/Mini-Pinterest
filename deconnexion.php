<?php
	session_start();
 	require_once('bd.php');
 	require('utilisateur.php');
	$db = getDB();
	if (isConnected()){
		setDisconnectedUtilisateur($db, $_SESSION['userId']);	        
		header('Location:page_accueil.php');
	    exit();
	}
?>

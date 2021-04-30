<?php

$dbHost = "localhost";// à compléter
$dbUser = "p1905223";// à compléter
$dbPwd = "Swell10Expire";// à compléter
$dbName = "p1905223";

/*Cette fonction prend en entrée l'identifiant de la machine hôte de la base de données, les identifiants (login, mot de passe) d'un utilisateur autorisé 
sur la base de données contenant les tables pour le chat et renvoie une connexion active sur cette base de donnée. Sinon, un message d'erreur est affiché.*/
function getConnection($dbHost, $dbUser, $dbPwd, $dbName)
{
	$link = mysqli_connect($dbHost, $dbUser, $dbPwd, $dbName);
	if (!$link) {
		echo "Echec lors de la connexion a la base de donnees : (" . mysqli_connect_errno() . ") " . mysqli_connect_error();
	}
	return $link;
}

/*Cette fonction prend en entrée une connexion vers la base de données du chat ainsi 
qu'une requête SQL SELECT et renvoie les résultats de la requête. Si le résultat est faux, un message d'erreur est affiché*/
function executeQuery($link, $query)
{
	$result = mysqli_query($link, $query);
	if(!$result){
		echo "La requete ".$query." n'a pas pu etre executee a cause d'une erreur de syntaxe";
	}
	return $result;
}

/*Cette fonction prend en entrée une connexion vers la base de données du chat ainsi 
qu'une requête SQL INSERT/UPDATE/DELETE et ne renvoie rien si la mise à jour a fonctionné, sinon un 
message d'erreur est affiché.*/
function executeUpdate($link, $query)
{
	$result = mysqli_query($link, $query);
	if(!$result){
		echo "La requete de mise a jour n'a pas pu etre executee a cause d'une erreur de syntaxe";
	}
}

/*Cette fonction ferme la connexion active $link passée en entrée*/
function closeConnexion($link)
{
	mysqli_close($link);
}
?>
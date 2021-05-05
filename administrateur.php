<?php

/*Cette fonction prend en entrée un pseudo à ajouter à la relation administrateur et une connexion et
retourne vrai si le pseudo est disponible (pas d'occurence dans les données existantes), faux sinon*/
function checkAvailabilityAdministrateur($pseudo, $link)
{
	$query = "SELECT adpseudo FROM administrateur WHERE adpseudo = '". $pseudo ."';" ;
	$resultat = executeQuery($link, $query);
	return mysqli_num_rows($resultat)==0;
}

/*Cette fonction prend en entrée un pseudo et un mot de passe, associe une couleur aléatoire dans le tableau de taille fixe
array('red', 'green', 'blue', 'black', 'yellow', 'orange') et enregistre le nouvel administrateur dans la relation administrateur via la connexion*/
function registerAdministrateur($pseudo, $hashPwd, $link)
{
	$colors = array('red', 'green', 'blue', 'black', 'yellow', 'orange');
	$index = rand(0, 6);
	$color = $colors[$index];
	$query = "INSERT INTO administrateur VALUES ('". $pseudo ."', '". $hashPwd ."', '". $color ."', 'disconnected');";
	executeUpdate($link, $query) ;
}

/*Cette fonction prend en entrée un pseudo et mot de passe et renvoie vrai si l'administrateur existe (au moins un tuple dans le résultat), faux sinon*/
function getUserAdministrateur($pseudo, $hashPwd, $link)
{
	
	$query = "SELECT adpseudo FROM administrateur WHERE adpseudo = '". $pseudo ."' AND adpwd = '". $hashPwd ."' AND etat = 'disconnected';";
	$resultat = executeQuery($link, $query);
	return mysqli_num_rows($resultat);
}

?>
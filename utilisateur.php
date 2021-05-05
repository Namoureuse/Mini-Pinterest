<?php


/*Cette fonction prend en entrée un pseudo à ajouter à la relation utilisateur et une connexion et
retourne vrai si le pseudo est disponible (pas d'occurence dans les données existantes), faux sinon*/
function checkAvailabilityUtilisateur($pseudo, $link)
{
	$query = "SELECT pseudo FROM utilisateur WHERE pseudo = '". $pseudo ."';";
	$resultat = executeQuery($link, $query);
	return mysqli_num_rows($resultat)==0;

}

/*Cette fonction prend en entrée un pseudo et un mot de passe, associe une couleur aléatoire dans le tableau de taille fixe
array('red', 'green', 'blue', 'black', 'yellow', 'orange') et enregistre le nouvel utilisateur dans la relation utilisateur via la connexion*/
function registerUtilisateur($pseudo, $hashPwd, $link)
{
	$colors = array('red', 'green', 'blue', 'black', 'yellow', 'orange');
	$index = rand(0, 6);
	$color = $colors[$index];
    $query = "INSERT INTO utilisateur VALUES ('". $pseudo ."', '". $hashPwd ."', '". $color ."', 'disconnected');";
	executeUpdate($link, $query) ;
}

/*Cette fonction prend en entrée un pseudo d'utilisateur et change son état en 'connected' dans la relation
utilisateur via la connexion*/
function setConnectedUtilisateur($pseudo, $link)
{
	$query = "UPDATE utilisateur SET etat = 'connected' WHERE pseudo = '". $pseudo ."';";
	executeUpdate($link, $query);
	
}

/*Cette fonction prend en entrée un pseudo et mot de passe et renvoie vrai si l'utilisateur existe (au moins un tuple dans le résultat), faux sinon*/
function getUserUtilisateur($pseudo, $hashPwd, $link)
{
	
	$query = "SELECT pseudo FROM utilisateur WHERE pseudo = '". $pseudo ."' AND mdp = '". $hashPwd ."' AND etat = 'disconnected';";
	$resultat = executeQuery($link, $query);
	return mysqli_num_rows($resultat);
}

/*Cette fonction renvoie un tableau (array) contenant tous les pseudos d'utilisateurs dont l'état est 'connected'*/
function getConnectedUsersUtilisateur($link)
{
	$req = "SELECT pseudo FROM utilisateur WHERE etat = 'connected'";
    $resultat = executeQuery($link, $req);
    $users = array();
    $index = 0;
    while($row = mysqli_fetch_assoc($resultat)) {
        $users[$index] = $row["pseudo"];
        $index += 1;
    }
    return $users;
}

/*Cette fonction prend en entrée un pseudo d'utilisateur et change son état en 'disconnected' dans la relation
utilisateur via la connexion*/
function setDisconnectedUtilisateur($pseudo, $link)
{
	$query = "UPDATE utilisateur SET etat = 'disconnected' WHERE pseudo = '". $pseudo ."';";
	executeUpdate($link, $query);
}

?>
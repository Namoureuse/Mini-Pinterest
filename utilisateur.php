<?php


/*Cette fonction prend en entrée un pseudo à ajouter à la relation utilisateur et une connexion et
retourne vrai si le pseudo est disponible (pas d'occurence dans les données existantes), faux sinon*/
function checkAvailabilityUtilisateur($db, $pseudo)
{
	$query = "SELECT pseudo FROM utilisateur WHERE pseudo = '". $pseudo ."';";
	$resultat = executeQuery($db, $query);
	return mysqli_num_rows($resultat)==0;
}

/*Cette fonction prend en entrée un pseudo et un mot de passe, associe une couleur aléatoire dans le tableau de taille fixe
array('red', 'green', 'blue', 'black', 'yellow', 'orange') et enregistre le nouvel utilisateur dans la relation utilisateur via la connexion*/
function registerUtilisateur($db, $role, $pseudo, $hashPwd)
{
    $query = "INSERT INTO utilisateur (roleId, pseudo, mdp, etat) VALUES ('". $role ."', '". $pseudo ."', '". $hashPwd . "', 'disconnected');";
	executeUpdate($db, $query) ;
}

/*Cette fonction prend en entrée un pseudo d'utilisateur et change son état en 'connected' dans la relation
utilisateur via la connexion*/
function setConnectedUtilisateur($db, $id)
{
	$query = "UPDATE utilisateur SET etat = 'connected', connectedOn ='" . date("Y-m-d H:i:s") . "' WHERE id = '". $id ."';";
	executeUpdate($db, $query);
}

/*Cette fonction prend en entrée un pseudo et mot de passe et renvoie vrai si l'utilisateur existe (au moins un tuple dans le résultat), faux sinon*/
function isConnected()
{
	if(isset($_SESSION['userId']) && !is_null($_SESSION['userId'])){
		return true;
	} else {
		return false;
	}
}

function connectionTime($connectedOn)
{
	$time = 0;
	if(!is_null($connectedOn)) {
		$connectedDatetimeObject = new DateTime($connectedOn);

		$currentDate = date("Y-m-d H:i:s");
		$currentDateObject = new DateTime($currentDate);

		$interval = $connectedDatetimeObject->diff($currentDateObject);
		$time = $interval->format("%H:%I:%S");
	}
	return $time;
}

function getUserFromConnection($db, $pseudo, $hashPwd)
{
	$query = "SELECT id, etat FROM utilisateur WHERE pseudo = '". $pseudo ."' AND mdp = '". $hashPwd ."'";
	$result = executeQuery($db, $query);
	return mysqli_fetch_assoc($result);
}

/*Cette fonction renvoie un tableau (array) contenant tous les pseudos d'utilisateurs dont l'état est 'connected'*/
function getConnectedUsersUtilisateur($db)
{
	$req = "SELECT pseudo FROM utilisateur WHERE etat = 'connected'";
    $resultat = executeQuery($db, $req);
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
function setDisconnectedUtilisateur($db, $id)
{
	$query = "UPDATE utilisateur SET etat = 'disconnected' WHERE id = '". $id ."';";
	executeUpdate($db, $query);
	unset($_SESSION['userId']);
}

function getUserFromSession($db, $id)
{
	$query = "SELECT pseudo, connectedOn FROM utilisateur WHERE id = '". $id ."';";
	$result = executeQuery($db, $query);
	return mysqli_fetch_assoc($result);
}

function addPicture($db, $nomFich, $description, $catId, $usrId)
{
	$query = "INSERT INTO photo (nomFich, description, catId, usrId) VALUES ('". $nomFich ."', '". $description ."', '". $catId . "', '". $usrId . "');";
	executeUpdate($db, $query) ;
	//move_uploaded_file($file, './data/' . basename($nomFich));
}

?>
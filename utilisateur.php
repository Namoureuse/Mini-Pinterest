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


//ajouter_photo.php
function addPicture($db, $file, $description, $catId, $usrId)
{
	$queryPhotoId = executeQuery($db, "SELECT * FROM photo");
	$photoId = $queryPhotoId->fetch_all(MYSQLI_ASSOC);
	$fileType = pathinfo($file['name'], PATHINFO_EXTENSION);

	$maxId = max($photoId);
	$maxId = $maxId['photoId'] + 1;

	$fileName ="DSC". $maxId. "." . $fileType;

	$query = "INSERT INTO photo (nomFich, description, catId, usrId) VALUES ('". $fileName ."', '". $description ."', '". $catId . "', '". $usrId . "');";
	executeUpdate($db, $query) ;
	move_uploaded_file($file['tmp_name'], './data/' . basename($fileName));

	return $maxId;
}

function checkFile($file)
{
	$errorMsg = "";
	$error = false;
	$fileType = pathinfo($file['name'], PATHINFO_EXTENSION);
	$allowedFileTypes = array("gif", "jpg", "jpeg", "png");
	$fileSize = $file['size'];

    if ($fileSize>100000) {//100ko
 	  $errorMsg = "La taille du fichier est supérieure à 100ko !";
      $error = true;   	
    } 
	if (!$error && !in_array($fileType, $allowedFileTypes)) {
		$imageSize = getimagesize($file['tmp_name']);
		if($imageSize[2] != 1 && $imageSize[2] != 2 && $imageSize[2] != 3){ //2 correspond à l'extension dans le tableau renvoyé par getimagesize : 1 = GIF, 2 = JPG, 3 = PNG		
			$errorMsg = "Le fichier doit avoir pour extension .jpg, .jpeg, .png, ou .gif !";
	     	$error = true;	
		}
	} 
	return $errorMsg;
}

//modif_photo.php
function modifyPicture($db, $file, $photo, $description, $catId)
{
	if (!is_null($photo)) {
		if($file['error'] != UPLOAD_ERR_NO_FILE && $file['size'] != 0) {
			$filepath = __DIR__."/data/" . $photo['nomFich'];
			unlink ($filepath);
			if(!file_exists($filepath)){ //check si on a bien remove le fichier
				$fileType = pathinfo($file['name'], PATHINFO_EXTENSION);
				$fileName = "DSC" . $photo['photoId'] . "." . $fileType;
				$filepath = __DIR__."/data/" . $fileName;
				
				move_uploaded_file($file['tmp_name'], './data/' . basename($filepath));
				if (file_exists($filepath)) {
					$query = "UPDATE photo SET nomFich ='" . $fileName . "', description ='" . $description . "', catId ='" . $catId . "' WHERE photoId = '". $photo['photoId'] ."';";
					executeUpdate($db, $query);	
				}
			}		
		} else {
			$query = "UPDATE photo SET description ='" . $description . "', catId ='" . $catId . "' WHERE photoId = '". $photo['photoId'] ."';";
			executeUpdate($db, $query);	
		}
	}

	/*$query = "UPDATE photo SET nomFich = '" . $file ."', description ='" . $description . "', catId ='" . $cat . "' WHERE photoId = '". $photoId ."';";
	executeUpdate($db, $query);*/
}

function selectAllPicturesFromUser($db, $usrId)
{
	$query = "SELECT * FROM photos WHERE usrId = '". $usrId ."';";
	$result = executeQuery($db, $query);
	return mysqli_fetch_assoc($result);
}

/*Fonction qui cherche dans la table le rôle selon un id passé en paramètre : 1: utilisateur, 2: administrateur et retourne cet id*/
function getRoleFromId($db, $usrId)
{
	$query = executeQuery($db, "SELECT roleId FROM utilisateur WHERE id = '". $usrId ."';");
	$result = $query->fetch_assoc();
	return $result['roleId'];
}

//compte_admin.php
function getPseudoFromId($db, $usrId)
{
	  $queryPseudo = executeQuery($db, "SELECT pseudo from utilisateur WHERE id='" . $usrId."';");
      $result = $queryPseudo->fetch_assoc();
      return $result['pseudo'];
}

//compte_admin.php
function getCategorieFromCatId($db, $catId)
{
	  $queryCategorie = executeQuery($db, "SELECT nomCat from categorie WHERE catId='" . $catId."';");
      $result = $queryCategorie->fetch_assoc();
      return $result['nomCat'];
}

//compte_utilisateur.php
function removePhoto($db, $photo)
{
	$filepath = __DIR__."/data/" . $photo['nomFich'];
	unlink ($filepath);

	if(!file_exists($filepath)) {
		$query = "DELETE FROM photo WHERE photoId = '" . $photo['photoId'] . "';";
		executeUpdate($db, $query);
	}
}

?>
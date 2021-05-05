<?php
	require_once('bd.php');
	require_once('administrateur.php');
	require_once('utilisateur.php');
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Application Mini-Pinterest</title>
  <link rel="stylesheet" href="bootstrap.css">
  <link rel="stylesheet" href="style.css">
</head>

<div class="bloc">&nbsp;</div>
<div class="row justify-content-center">
	<div class="menu container p-4 m-4 border rounded border-lignt">
		<form action="inscription.php" method="POST">
            <div class="row justify-content-start">
                <div class="col-4">
                    <p>*champs obligatoires</p>
                </div>
            </div>
            <div  class="row justify-content-start p-2">
                <!--<div class="col-5" > !-->
                    <p>Selectionnez du profil</p>
                
                <!--<div class="col-6">!-->
                    <select name="dowpdown" >
                        <option value="0" SELECTED>UTILISATEUR</option>
                        <option value="1">ADMINISTRATEUR</option>
                    </select>
                
                <!--<div class="row justify-content-start p-2">
                    <div class="col-5 ">!-->
                        Choisir un pseudo*
                   
                    <!--<div class="col-6 ">!-->
                        <input type="text" name="pseudo"  placeholder="Pseudo">
                   
                    <div class="col-1">
                        <?php
                            if(isset($wrongpseudo) && $wrongseudo){
                                echo $wrongpseudo;}
                        ?>
                    </div>
                    <div class="row justify-content-start p-2">
                        <!--<div class="col-10 ">!-->
                            Choisissez un Mot de passe*
                        
                        <!--<div class="col-6 ">!-->
                            <input type="password" name="motdepasse" >
                        
                        <div class="col-10">
                            <?php
                                if(isset($wrongpwd) && $wrongpwd){
                                    echo $wrongpwd;
                                }
                            ?>
                        </div>
                        <div class="row justify-content-start p-2">
                            <!--<div class="col-5">!-->
                                Confirmez votre Mot de passe
                            
                           <!-- <div class="col-6 ">!-->
                                <input type="password" name="confirm_motdepasse" >
                            
                            <div class="col-10">
                                <?php
                                    if(isset($wrongpwd2) && $wrongpwd2){
                                        echo $wrongpwd2;
                                    }
                                ?>
                            </div>
                        </div>
                        <div style="display:flex;margin-top:0em; margin-left:9em; padding-right:8em;padding-left:2em;">
                        <input type="submit" name="submit" value="S'inscrire"/>
                        </div>
                    </div>
                </div>
            </div>
            <div style="padding-left:2em;">
                <a href="https://bdw1.univ-lyon1.fr/p1905392/bdw1/connexion.php"> Déja Inscrit ? </a>
            </div>
        </form>
    </div>
</div>

<?php


/*Cette fonction doit être définie hors d'une condition (if/else), donc on la définie avant de l'utiliser dans une boucle*/
function tests($donnees){
    $donnees = trim($donnees); //trim supprime les espaces (ou d'autres caractères) en début et fin de chaîne
    $donnees = stripslashes($donnees); //stripslashes supprime les antislashs d'une chaîne
    $donnees = htmlspecialchars($donnees); //htmlspecialchars convertit les caractères spéciaux en entités HTML
    return $donnees;
}

if (isset($_POST['submit'])) {

    $pseudo = $_POST["pseudo"];
    $pwd = $_POST["motdepasse"];
    $confirm_pwd = $_POST["confirm_motdepasse"];

    if (empty($_POST["pseudo"])){
        $wrongpseudo = "Il faut choisir un pseudo";
    }
    else {
        $pseudo = tests($_POST["pseudo"]);
        $wrongpseudo = "";
    }
    if (empty($_POST["motdepasse"])) {
        $wrongpwd = "le mot de passe est requis";
    }
    else {
        $pwd = tests($_POST["motdepasse"]);
    }
    if (empty($_POST["confirm_motdepasse"])) {
        $wrongpwd2 = " Il faut confirmer le mot de passe";
    }
    else {
        $confirm_pwd = tests($_POST["confirm_motdepasse"]);
    }

    if ( isset($pwd) && $pwd != $confirm_pwd){
        $wrongpwd = "le mot de passe est différent";
        $wrongpwd2 = " la confirmation de mot de passe est différente";
    }
    if ( ! (empty($_POST["pseudo"]) || empty($_POST["motdepasse"]) || empty($_POST["confirm_motdepasse"])) ) {
        $link = getDB('localhost', "p1905392", "", "p1905392");
        if($_POST['dowpdown']==1){
            if(checkAvailabilityAdministrateur($pseudo, $link)==1){
                registerAdministrateur($pseudo, $pwd, $link);
                header('Location: https://bdw1.univ-lyon1.fr/p1926029/BDW1-ProjetFinale/bdw1_projet/connexion.php');
                exit();
            }
            else {
                $pseudoErr="Pseudo Administrateur déjà utilisé";
            }
        }
        else if($_POST['dowpdown']==0){
            if(checkAvailabilityUtilisateur($pseudo, $link)==1){
                registerUtilisateur($pseudo, $pwd, $link);
                header('Location: https://bdw1.univ-lyon1.fr/p1926029/BDW1-ProjetFinale/bdw1_projet/connexion.php');
                exit();
            }
            else {
                $wrongpseudo="Pseudo Utilisateur déjà utilisé";
            }
        }

    }
}


if (isset($_POST['accueil'])) {
    header('Location: https://bdw1.univ-lyon1.fr/p1926029/BDW1-ProjetFinale/bdw1_projet/accueil.php');
    exit();
}
?>


</body>
</html>
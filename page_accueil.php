<?php
  session_start();
  require_once('bd.php');
  $db=getDB();
  $repertoire="data/";

  $logged = "Connexion";

  var_dump($_SESSION["logged"]);

  if(isset($_SESSION["logged"])){
      $logged = $_SESSION["logged"];
  }else{
      session_unset();
      //header('Location: connexion.php');
  }


  $queryPhotosWhere = (isset($_GET['cat']) && $_GET['cat'] != "")
    ? " WHERE catId = ".$_GET['cat']
    : "";
  $queryPhotos = executeQuery($db, "SELECT * FROM photo".$queryPhotosWhere);
  $photos = $queryPhotos->fetch_all(MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="fr">
  <head>
      <meta charset="utf-8">
      <title>Application Mini-Pinterest</title>
      <link rel="stylesheet" href="style.css">
  </head>

  <body>
      <div class="div_gris">
        <?php echo count($photos); ?> photo(s) sélectionnées
        <div class="pos_right">
            <a href='connexion.php'> <?php echo $logged ?> </a>
            <a href='inscription.php'> Inscription </a>
        </div>
      </div>

      <div>
        <form action="page_accueil.php" method="get">
          <table class="choix_photo">
            <tr>
            <td>Quelles photos souhaitez-vous afficher?</td>
            <td>
              <?php
               // $categorie = executeQuery($GLOBALS['db'], "SELECT nomCat FROM categorie");
                $queryCategories = executeQuery($db, "SELECT * FROM categorie");
                $categories = $queryCategories->fetch_all(MYSQLI_ASSOC);
              ?>
              <select name="cat" >
                  <option value="">Toutes les photos</option>
                  <?php
                      foreach ($categories as $categorie) {
                          $selected = (isset($_GET['cat']) && $_GET['cat'] == $categorie['catId'])
                            ? " selected"
                            : "";
                          echo "<option value=".$categorie['catId'].$selected.">".$categorie['nomCat']."</option>";
                      }
                  ?>
              </select>
              <input type="submit" value="Valider" class="button"/>
            </td>
            </tr>
          </table>
        </form>
      </div>

    <?php
      if(isset($_GET['cat']) && $_GET['cat'] != "") {
        $queryCategorie = executeQuery($db, "SELECT * FROM categorie WHERE catId =".$_GET['cat']);
        $cat = $queryCategorie->fetch_assoc();
        $catName = $cat['nomCat'];
      } else {
        $catName = "Toutes les photos";
      }
    ?>

    <h1>
      <?php echo $catName; ?>
    </h1>

    <div class="allphotos">
      <?php

        foreach ($photos as $photo) {
            echo "<a href='affichage.php?photoId=" . $photo['photoId'] . "'>
                    <img src='" . $photo['nomFich'] . "' class = 'photo' alt='". $photo['description'] ."'/>
                  </a>";
        }
      ?>
    </div>
  </body>
</html>

<?php
  closeConnexion($db);
?>

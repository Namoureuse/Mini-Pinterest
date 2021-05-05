<?php
  require_once('bd.php');
  $db=getDB($dbHost,$dbUser,$dbPwd, $dbName);
  $repertoire="data/";
  $queryNbSelect = executeQuery($db, "SELECT COUNT(photoId) FROM photo");
  $nbSelect = $queryNbSelect->fetch_assoc();
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
        <?php echo $nbSelect['COUNT(photoId)']; //var_dump($nbSelect);?> photo(s) sélectionnées
        <div class="pos_right">
            <a href='connexion.php'> Connexion </a>
            <a href='inscription.php'> Inscription </a>
        </div>
      </div>



      <div>
        <form action="page_accueil.php" method="post">
          <table class="choix_photo">
          	<tr>
          	<td>Quelles photos souhaitez-vous afficher?</td>
          	<td>
              <?php
               // $categorie = executeQuery($GLOBALS['db'], "SELECT nomCat FROM categorie");
                $queryCategories = executeQuery($db, "SELECT * FROM categorie");
                $categories = $queryCategories->fetch_all(MYSQLI_ASSOC);
              ?>
              <select name="cat_id" >
                  <option value="">Toutes les photos</option>
                  <?php
                      foreach ($categories as $categorie) {
                          $selected = (isset($_POST['cat_id']) && $_POST['cat_id'] == $categorie['catId'])
                            ? " selected"
                            : "";
                          echo "<option value=".$categorie['catId'].$selected.">".$categorie['nomCat']."</option>";
                      }
                  ?>
              </select>
              <input type="submit" name="valider" value="Valider" class="button"/>
          	</td>
          	</tr>
          </table>
        </form>
      </div>

    <?php
      if(isset($_POST['cat_id']) && $_POST['cat_id'] != "") {
        $queryCategorie = executeQuery($db, "SELECT * FROM categorie WHERE catId =".$_POST['cat_id']);
        $cat = $queryCategorie->fetch_assoc();
        $catName = $cat['nomCat'];
        /*$queryNbSelect = executeQuery($db, "SELECT COUNT(photoId) FROM photo WHERE catId =".$_POST['cat_id']);
        $nbSelect = $queryNbSelect->fetch_assoc();
        var_dump($nbSelect);*/
      } else {
        $catName = "Toutes les photos";
        /*$queryNbSelect = executeQuery($db, "SELECT COUNT(photoId) FROM photo");
        $nbSelect = $queryNbSelect->fetch_assoc();**/
      }
    ?>

    <h1>
      <?php echo $catName; ?>
    </h1>

    <div class="allphotos">
      <?php
        $queryPhotosWhere = (isset($_POST['cat_id']) && $_POST['cat_id'] != "")
          ? " WHERE catId = ".$_POST['cat_id']
          : "";
        $queryPhotos = executeQuery($db, "SELECT * FROM photo".$queryPhotosWhere);
        $photos = $queryPhotos->fetch_all(MYSQLI_ASSOC);

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

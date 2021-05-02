<?php
  require_once('bd.php');
  $db=getDB($dbHost,$dbUser,$dbPwd, $dbName);
  $repertoire="data/"
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Application Mini-Pinterest</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="page_acceuil.css">
</head>
<body>


    <div class="div_gris">
      x photo(s) sélectionnées
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
            <input type="submit" name="valider" value="Valider"/>
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
    } else {
      $catName = "Toutes les photos";
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
        echo "<a href='affichage.php?photoId=" . $photo['photoId'] . "'><img src='" . $photo['nomFich'] . "' class = 'photo'/></a>";
    }
    /*$photo_Id = executeQuery($GLOBALS['db'], "SELECT photoId FROM photo");
    while ($ligne_photoId = $photo_Id->fetch_assoc())
    {
      $nom_photo = executeQuery($GLOBALS['db'], "SELECT nomFich FROM photo WHERE photoId = " . $ligne_photoId["photoId"] );
      $ligne_nomphotoId = $nom_photo->fetch_assoc();
      $photos= opendir($repertoire);
      /*foreach ($photos as $photo):
          echo "<a href='affichage.php?photoId=" . $ligne_photoId["photoId"] . "'><img src='" . $photo . "' class = 'assets'/></a>";
  endforeach;*/
    //}
  ?>
  </div>
</body>
</html>

<?php
closeConnexion($db);
?>
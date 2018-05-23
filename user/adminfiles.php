<?php
session_start();
include 'a-connect.php';
  if (!empty($_SESSION['id'])) {
    if (!empty($_GET['id']) AND $_GET['id'] == $_SESSION['id']) {

// ZONE DE CODE --- FICHIERS (1)

      if (isset($_POST['envoyer']) AND isset($_FILES['fichier'])AND !empty($_FILES['fichier']['name'])) {
        $tailleMax = 10485760;
         $extensionValides = array('jpg', 'jpeg', 'gif', 'png', 'svg');

         if($_FILES['fichier']['size'] <= $tailleMax)
         {
            $extensionUpload = strtolower(substr(strrchr($_FILES['fichier']['name'] ,'.' ), 1));

            if(in_array($extensionUpload, $extensionValides))
            {
               $chemin = "../templates/img/". $_SESSION['id'].".".$extensionUpload;
               $resultat = move_uploaded_file($_FILES['fichier']['tmp_name'], $chemin);

               if($resultat)
               {
                  // $dernierImagesEntree = $bdd->prepare('SELECT max() FROM images WHERE id_proprio = ?');
                  // $dernierImagesEntree->execute(array($_SESSION['id']));
                  // $nbreDerniereImageEntree = $dernierImagesEntree->fetch();
                  // echo $nbreDerniereImageEntree['id_image'];
                  $insertImage = $bdd->prepare('UPDATE images SET nom = ? WHERE id_proprio = ?');
                  $insertImage->execute(array($_SESSION['id'] . "." . $extensionUpload, $_SESSION['id']));
                  echo "YEAHHH";
                     // header('Location: profil.php?id='.$_SESSION['id']);
               }
               else
               {
                  $erreur = "Erreur durant l'importation";
               }
            }
            else
            {
               $erreur = "Votre image doit être au format jpeg, jpg, png, gif ou svg";
            }
         }
         else
         {
            $erreur = "Votre photo ne doit pas dépasser 10Mo";
         }
      }

      else {
        $erreur = 'Vous n\'avez toujours pas compris qu\'il faut remplir l\'UNIQUE champ ?!?';
      }

// FIN ZONE DE CODE --- FICHIERS (1)


    }else{
      header('Location: admin.php?id=' . $_SESSION['id']);
    }
  }else{
    header('Location: connect.php');
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Page Administrateur</title>
  </head>
  <body>
    <?= 'Bienvenue Grand ' . ucfirst($_SESSION['nom']) ?>
    <p>Importer une image:</p>
    <form method="post" action="" enctype="multipart/form-data">
      <input type="file" name="fichier" /><br />
      <input type="submit" name="envoyer" value="Mettre cette image" />
    </form>
    <?php if (isset($erreur)) { ?>
        <strong style="color:red;"><?= $erreur?></strong>
    <?php } ?>
    <a href="logout.php">Se déconnecter</a>
  </body>
</html>

<?php
session_start();
include 'a-connect.php';
  if (!empty($_SESSION['id'])) {
    if (!empty($_GET['id']) AND $_GET['id'] == $_SESSION['id']) {
      $getid = $_GET['id'];
    // ZONE DE CODE ---- TEXTE (2)
    $reqMessages = $bdd->prepare('SELECT * FROM messages WHERE id_proprio = ? AND souvenir = 1 ORDER BY id DESC LIMIT 0,11');
    $reqMessages->execute(array($getid));

    if (isset($_POST['envoyer'])) {
      $message = htmlspecialchars($_POST['message']);
      if ($message != NULL || isset($_POST['choixradio'])) {
      if (isset($_POST['choixradio'])) {

        $message = $_POST['choixradio'];
        $reqInsertMessage = $bdd->prepare('SELECT * FROM messages WHERE id = ?');
        $reqInsertMessage->execute(array($_POST['choixradio']));
        $messageaCopier = $reqInsertMessage->fetch();
        $inserserCopie = $bdd->prepare('INSERT INTO messages(id_proprio, valeur, souvenir, couleur) VALUES (?,?,?,?)');
        $inserserCopie->execute(array($getid, $messageaCopier['valeur'], 0, $messageaCopier['couleur']));

      }else if(isset($_POST['couleur']) && isset($_POST['souvenir'])){
        $reqInsertMessage = $bdd->prepare('INSERT INTO messages(id_proprio, valeur, souvenir, couleur) VALUES (?,?,?,?)');
        $reqInsertMessage->execute(array($getid, $message, 1, $_POST['couleur']));
      }elseif (isset($_POST['couleur'])) {
        $reqInsertMessage = $bdd->prepare('INSERT INTO messages(id_proprio, valeur, souvenir, couleur) VALUES (?,?,?,?)');
        $reqInsertMessage->execute(array($getid, $message, 0, $_POST['couleur']));
      }else{
        if (isset($_POST['souvenir'])) {
          $reqInsertMessage = $bdd->prepare('INSERT INTO messages(id_proprio, valeur, souvenir) VALUES (?,?,?)');
          $reqInsertMessage->execute(array($getid, $message, 1));
        }else{
          $reqInsertMessage = $bdd->prepare('INSERT INTO messages(id_proprio, valeur, souvenir) VALUES (?,?,?)');
          $reqInsertMessage->execute(array($getid, $message, 0));
        }
      }
      }else{
        $erreur = "Il y'avait 1 paramètre à remplir... 1 !";
      }
    }
    // FIN DE ZONE DE CODE ---- TEXTE (2)


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
    <meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=0.8, user-scalable=no">
    <link rel="stylesheet" href="../templates/css/style.css">
    <title>Page Administrateur</title>
  </head>
  <body id="admin-menu">
    <?= '<p id="welcome">Bienvenue, Ô ' . ucfirst($_SESSION['nom'])  . '</p>' ?>
    <div id="admin-form">

    <p>Message à afficher:</p>
    <form method="post" action="" enctype="multipart/form-data">
      <?php
      while ($donnees = $reqMessages->fetch()) {
        ?>
        <label style="background-color:<?= $donnees['couleur']?>"><input type="radio" name="choixradio" value="<?= $donnees['id'] ?>"/>  <?= $donnees['valeur'] ?> </label><br />
        <?php
      }
      ?>
      <input type="text" name="message" placeholder="Autre chose" maxlength="30"/<br /><br />
      <label>Couleur:
        <input type="color" name="couleur" />
      </label>
      <label><br />
        <input type="checkbox" name="souvenir" />
        Ajouter à l'historique
      </label><br />
      <input type="submit" name="envoyer" value="Mettre ce message" />
    </form>
  </div>
    <?php if (isset($erreur)) { ?>
        <strong style="background-color:#e74c3c;"><?= $erreur?></strong><br />
        <img src="../templates/.ressources/clap.gif"  /><br />
    <?php } ?>
    <a href="logout.php">Se déconnecter</a>
    <!-- <div id="unpb">
      <p>Si vous avez un problème/bug dites le moi <a href="mailto:a.discepoli@student.arnivelles.be">par mail</a> ou comme vous voulez ;)</p>
    </div> -->
  </body>
</html>

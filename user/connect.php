<?php
session_start();
include 'a-connect.php';
if (isset($_POST['envoyer'])) {
  $nom = htmlspecialchars($_POST['name']);
  if (isset($nom)) {
    $reqUser = $bdd->prepare('SELECT * FROM membre WHERE nom = ?');
    $reqUser->execute(array($nom));
    $userExist = $reqUser->rowCount();
    if ($userExist == 1) {
      $userInfo = $reqUser->fetch();
      $_SESSION['id'] = $userInfo['id'];
      $_SESSION['nom'] = $userInfo['nom'];
      header('Location: admin.php?id=' . $userInfo['id']);
    }
  }else{
    $erreur = "Bon, il n'y a qu'un champ, remplissez le quand même s'il vous plaît...";
  }
}
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Connexion - ScreenDisplay</title>
  </head>
  <body>
    <form method="post" action="">
      <input type="text" name="name" placeholder="Nom">
      <input type="submit" name="envoyer" value="Se connecter" />
    </form>
    <?php if (isset($erreur)) { ?>
        <strong style="color:red;"><?= $erreur?></strong>
    <?php } ?>
  </body>
</html>

<?php
include 'user/a-connect.php';
$reqUserDispo = $bdd->prepare('SELECT * FROM membre');
$reqUserDispo->execute();
// $userDispo = $reqUserDispo->fetch();
  if (!empty($_GET['id'])) {
    $getid = $_GET['id'];
    $reqImage = $bdd->prepare('SELECT * FROM images WHERE id_proprio = ?'); // SI ERREUR REGARER LE LIMIT 0
    $reqImage->execute(array($getid));
    $Image = $reqImage->fetch();
  }else{
    echo "Veuillez choisir la personnes dont les images devront êtres affichées<br />";
    while ($donnees = $reqUserDispo->fetch()) {
      echo "<a href='index.php?id=" . $donnees['id'] . "'>" . $donnees['nom'] . "</a><br />";
    }
  }
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Screen Display</title>
  </head>
  <body>
    <?php if (!empty($_GET['id'])) { ?>
      <img src="templates/img/<?php echo $Image['nom'] ?>" />
    <?php } ?>
  </body>
</html>

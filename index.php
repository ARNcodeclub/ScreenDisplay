<?php
session_start();
include 'user/a-connect.php';
$reqUserDispo = $bdd->prepare('SELECT * FROM membre');
$reqUserDispo->execute();
// $userDispo = $reqUserDispo->fetch();
  if (!empty($_GET['id'])) {
    $getid = $_GET['id'];
    // $reqImage = $bdd->prepare('SELECT * FROM images WHERE id_proprio = ?');
    $reqImage = $bdd->prepare('SELECT * FROM messages WHERE id_proprio = ? ORDER BY id DESC LIMIT 1');
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
    <!-- <meta http-equiv="refresh" content="5"> -->
    <meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=0.8, user-scalable=no">
    <meta charset="utf-8">
    <link rel="apple-touch-icon" href="templates/.ressources/logoapple.jpg">
    <link rel="apple-touch-icon" sizes="76x76" href="templates/.ressources/logoapple.jpg">
    <link rel="apple-touch-icon" sizes="152x152" href="templates/.ressources/logoapple.jpg">
    <title>Screen Display</title>
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <script type="text/javascript" src="templates/js/jquery.js"></script>
    <?php if (!empty($_GET['id'])) { ?>
    <script type="text/javascript">
      var refreshId = setInterval(function()
      {
        $('#banner-title').load('user/derniermot.php?id=<?= $getid ?>');
      }, 900);
    </script>
    <?php } ?>
    <link rel="stylesheet" href="templates/css/style.css">
  </head>
  <body>
    <?php if (!empty($_GET['id'])) {
          // $bg_color = "413939";
          // $txt_shadow_color = "262121";
          if ($getid == 1) {
            $bg_color = "3498db";
            $txt_shadow_color = "2980b9";
          }else if ($getid == 2) {
            $bg_color = "2ecc71";
            $txt_shadow_color = "27ae60";
          }
      ?>
      <div id="banner-article" style="background-color: #<?= $bg_color ?>;">
          <!-- <img id="image" src="templates/img/<?php // echo $Image['nom'] ?>" /> -->
          <p id="banner-title" style="text-shadow: -4px 4px #<?= $txt_shadow_color ?>;"><?= $Image['valeur'] ?></p>
      </div>
    <?php } ?>
    <p id="cestquandmememoiquiaittoutfaitxD">Développé par @ilio Discepoli - 5F - 2018 - ARNCodeClub &copy; - T'as de bons yeux tu sais ?</p>
  </body>
</html>

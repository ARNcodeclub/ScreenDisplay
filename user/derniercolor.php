<?php
include 'a-connect.php';

if (isset($_GET['id'])) {
  $getid = $_GET['id'];
  $reqMot = $bdd->prepare('SELECT * FROM messages WHERE id_proprio = ? ORDER BY id DESC LIMIT 1');
  $reqMot->execute(array($getid));
  $dernierMot = $reqMot->fetch();
}
?>

<div id="banner-article" style="background-color: <?= $dernierMot['couleur'] ?>;">
    <p id="banner-title"><?= $dernierMot['valeur'] ?></p>
</div>

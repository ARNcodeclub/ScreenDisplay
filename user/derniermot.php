<?php
include 'a-connect.php';

if (isset($_GET['id'])) {
  $getid = $_GET['id'];
  $reqMot = $bdd->prepare('SELECT * FROM messages WHERE id_proprio = ? ORDER BY id DESC LIMIT 1');
  $reqMot->execute(array($getid));
  $dernierMot = $reqMot->fetch();
}
?>

<?= $dernierMot['valeur'] ?>

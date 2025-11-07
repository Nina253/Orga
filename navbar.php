<?php
session_start();
$base = '/Orga'; // ton dossier racine
?>

<nav class="navbar">
  <div class="nav-left">
    <a href="home.php"><img class="logo" src="images/logo.png" alt="logo" ></a>
  </div>

  <div class="nav-mid"> 
      <span class="brand"></span>

  </div>

  <div class="nav-right">
    <a href="<?= $base ?>/forum.php">Forum</a>

    <?php if (isset($_SESSION['client'])): ?>
      <a href="profil.php">Profil</a>
      <a href="<?= $base ?>/compte.php" class="btn btn-green">Mon compte</a>
      <a href="<?= $base ?>/logout.php" class="btn btn-red">Déconnexion</a>
    <?php else: ?>
      <a class="bouton_noir" href="<?= $base ?>/connecter.php">Se connecter</a>
    <?php endif; ?>
  </div>
</nav>
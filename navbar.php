<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base = '/Orga';
?>

<nav class="navbar">
  <div class="nav-left">
    <a href="home.php"><img class="logo" src="images/logo.png" alt="logo" ></a>
  </div>

  <div class="nav-mid"> 
      <span class="brand"></span>

  </div>

  <div class="nav-droite">
    <?php if (isset($_SESSION['client'])){ ?>
      <a href="tableau_bord.php">Tableau de Bord</a>
      <?php
    };
    ?>
    <a href="forum.php">Forum</a>

    <?php if (isset($_SESSION['client'])): ?>
      <a href="compte.php" class="btn btn-green">Mon compte</a>
	  <a href="deconnexion.php" class="btn btn-green">Se déconnecter</a>
    <?php else: ?>

      <a class="bloc connexion" href="connecter.php">Se connecter</a>
    <?php endif; ?>
  </div>
</nav>

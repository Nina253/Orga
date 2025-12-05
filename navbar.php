<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base = '/Orga';
?>

<nav class="navbar">
  <div class="nav-left">
    <a href="/Orga/home.php"><img class="logo" src="/Orga/images/logo.png" alt="logo" ></a>
  </div>

  <div class="nav-mid"> 
      <span class="brand"></span>

  </div>

  <div class="nav-droite">
    <?php if (isset($_SESSION['client'])){ ?>
      <a href="/Orga/tableau_de_bord/tableau_bord.php" style='font-family: "Silk Serif";font-size: 18px;color:black;'>Tableau de Bord</a>
      <?php
    };
    ?>
    <a href="/Orga/forum/forum.php" style='font-family: "Silk Serif";font-size: 18px;color:black;'>Forum</a>

    <?php if (isset($_SESSION['client'])): ?>
      <a href="/Orga/compte.php" class="btn btn-green" style='font-family: "Silk Serif";font-size: 18px;color:black;'>Mon compte</a>
	    <a class="bouton_noir" href="/Orga/utilisateur/deconnexion.php" style='font-family: "Silk Serif"; font-size: 17px; background-color:#006FFF'>Se déconnecter</a>
    <?php else: ?>

      <a class="bloc connexion" href="/Orga/utilisateur/connecter.php" style='font-family: "Silk Serif";font-size: 17px;'>Se connecter</a>
    <?php endif; ?>
  </div>
</nav>

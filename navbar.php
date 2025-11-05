<?php
session_start();
$base = '/Orga'; // ton dossier racine
?>

<nav class="navbar">
  <div class="nav-left">
    <a href="<?= $base ?>/index.php" class="brand-link">
      <img src="<?= $base ?>/images/logo.png" alt="Logo" class="logo">
      
    </a>
  </div>

  <div class="nav-mid"> 
      <span class="brand">Orga+</span>

  </div>

  <div class="nav-right">
    <a href="<?= $base ?>/forum.php" class="nav-link">Forum</a>

    <?php if (isset($_SESSION['client'])): ?>
      <a href="<?= $base ?>/compte.php" class="btn btn-green">Mon compte</a>
      <a href="<?= $base ?>/logout.php" class="btn btn-red">Déconnexion</a>
    <?php else: ?>
      <a href="<?= $base ?>/login.php" class="btn btn-black">Se connecter</a>
    <?php endif; ?>
  </div>
</nav>
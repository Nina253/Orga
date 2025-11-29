<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base = '/Orga';
?>
<nav class="navbarBas" role="navigation" aria-label="Barre du bas">
  <div class="nav-left">
    <a href="/Orga/home.php"><img class="logo-bas" src="/Orga/images/logo.png" alt="logo" ></a>
  </div>

  <div class="nav-mid">
    <span class="brand"></span>
  </div>

  <div class="nav-right">
    <a href="/Orga/nous.php" class="nav-link">Qui sommes-nous ?</a>
  </div>
</nav>

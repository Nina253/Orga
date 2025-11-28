<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base = '/Orga';
?>

<nav class="navbarBas">
  <div>
    <a href="/Orga/home.php"><img class="logo" src="/Orga/images/logo.png" alt="logo" ></a>
  </div>

  <div class="nav-mid"> 
      <span class="brand"></span>
  </div>

  <div>
    <a href="/Orga/nous.php" style='font-family: "Silk Serif";font-size: 18px;'>Qui sommes-nous ?</a>
  </div>
</nav>

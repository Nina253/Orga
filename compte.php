<?php 
	session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/styles.css" type="text/css" media="screen" > 

    <title>Mon compte</title>
</head>
<body>
     <?php include 'navbar.php' ;?>
     <div class='haut'>
        <img class="perso" src="images/perso.jpg" alt="perso">

     </div>
     <div class='bas'>
        <div class='g'>
                 <div class='bloc'> <a href="deconnexion.php">Deconnexion</a> </div>
                <div class='bloc'> <a href="profil.php">Profil</a> </div>


        </div>
        <div class='d'>


        </div>




     </div>



           

     <?php echo $_SESSION['client']['id'];?>


</body>
</html>
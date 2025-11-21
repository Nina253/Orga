<?php
require_once 'bd.php';
$bdd = getBD();

if (isset($_POST['mail'])) {
    $mail = trim($_POST['mail']);
    $stmt = $bdd->prepare("SELECT COUNT(*) FROM etudiant WHERE mail = ?");
    $stmt->execute([$mail]);
    $existe = $stmt->fetchColumn() > 0;

    echo $existe ? "true" : "false";
} else {
    echo "false";
}
?>

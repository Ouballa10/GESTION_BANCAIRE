<?php
include_once("modeles.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id_compte"])) {
    $id = intval($_POST["id_compte"]);

    // Supprimer le compte
    mysqli_query($conn, "DELETE FROM comptes WHERE id_compte = $id");

    echo "✅ Le compte a été supprimé.";
}

header("Location: comptes.php");
exit;

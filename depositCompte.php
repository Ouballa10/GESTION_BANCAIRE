<?php
include_once("modeles.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id_compte"]) && isset($_POST["montant"])) {
    $id = intval($_POST["id_compte"]);
    $montant = floatval($_POST["montant"]);

    // Assurer que le montant est positif
    if ($montant > 0) {
        // Mettre à jour le solde
        mysqli_query($conn, "UPDATE comptes SET solde = solde + $montant WHERE id_compte = $id");
        echo "✅ Le montant a été ajouté avec succès.";
    } else {
        echo "⚠️ Le montant doit être positif.";
    }
}

header("Location: comptes.php");
exit;

<?php
include("modeles.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $compte1 = $_POST["compte_source"];
    $compte2 = $_POST["compte_dest"];
    $montant = $_POST["montant"];
    $description = $_POST["description"];
    
    if (!empty($compte1) && !empty($compte2) && !empty($montant)) {
        addTransaction($compte1, $compte2, $montant, $description);
        echo "Transaction ajoutée avec succès!";
    } else {
        echo "Tous les champs obligatoires doivent être remplis.";
    }
}
?>

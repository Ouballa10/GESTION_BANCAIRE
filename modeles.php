<?php
// Connexion à la base de données
$conn = mysqli_connect("localhost", "root", "", "banquedb");

if (!$conn) {
    die("Connexion échouée : " . mysqli_connect_error());
}

// Récupère toutes les lignes d'une table
function getLignes($table) {
    global $conn;
    $query = "SELECT * FROM $table";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);


}
// Ajouter un compte
function addCompte($nom, $solde) {
    global $conn;
    $query = "INSERT INTO comptes (nom, solde) VALUES ('$nom', '$solde')";
    return mysqli_query($conn, $query);
}
// Récupérer tous les comptes
function getComptes() {
    global $conn;
    $query = "SELECT * FROM comptes";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}


// Ajoute une transaction
function addTransaction($source, $dest, $montant, $description) {
    global $conn;

    // Commence une transaction SQL
    mysqli_begin_transaction($conn);

    try {
        // Insert la transaction
        $query = "INSERT INTO transactions (compte_source, compte_dest, montant, description, date_transaction)
                  VALUES ('$source', '$dest', '$montant', '$description', NOW())";
        mysqli_query($conn, $query);

        // Update source: soustraction
        mysqli_query($conn, "UPDATE comptes SET solde = solde - $montant WHERE id_compte = $source");

        // Update destination: addition
        mysqli_query($conn, "UPDATE comptes SET solde = solde + $montant WHERE id_compte = $dest");

        // Commit si tout est bon
        mysqli_commit($conn);
    } catch (Exception $e) {
        mysqli_rollback($conn);
        die("Erreur transaction: " . $e->getMessage());
    }
}

function getSoldeCompte($id_compte) {
    global $conn;

    $stmt = $conn->prepare("SELECT solde FROM comptes WHERE id_compte = ?");
    $stmt->bind_param("i", $id_compte);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return $row['solde'];
    }
    return 0;
}
function updateSolde($id_compte, $montant) {
    global $conn;

    // mise à jour du solde (ajouter أو soustraire)
    $stmt = $conn->prepare("UPDATE comptes SET solde = solde + ? WHERE id_compte = ?");
    $stmt->bind_param("di", $montant, $id_compte);
    $stmt->execute();
}

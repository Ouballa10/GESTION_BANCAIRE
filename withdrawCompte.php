<?php
include_once("modeles.php");

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_compte = $_POST['id_compte'];
    $montant_retrait = $_POST['montant_retrait'];

    // Check if the amount is positive
    if ($montant_retrait > 0) {
        // Connect to the database
        $conn = mysqli_connect("localhost", "root", "", "banquedb"); // Replace with your credentials
        
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Check if the account exists and the balance is sufficient
        $query = "SELECT * FROM comptes WHERE id_compte = '$id_compte'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $compte = mysqli_fetch_assoc($result);

            // Check if the balance is sufficient for the withdrawal
            if ($compte['solde'] >= $montant_retrait) {
                // Perform the withdrawal by updating the balance
                $nouveau_solde = $compte['solde'] - $montant_retrait;
                $update_query = "UPDATE comptes SET solde = '$nouveau_solde' WHERE id_compte = '$id_compte'";
                mysqli_query($conn, $update_query);
            }
        }

        // Close the connection
        mysqli_close($conn);

        // Redirect back to the list of accounts without showing a message
        header("Location: comptes.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Retrait du Compte</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f4f4f4;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="number"], input[type="text"] {
            padding: 10px;
            width: 300px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #009879;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>
<body>

    <h2>Retrait du Compte</h2>

    <form method="POST">
        <label for="id_compte">Numéro de Compte :</label>
        <input type="text" name="id_compte" required>

        <label for="montant_retrait">Montant à Retirer (€) :</label>
        <input type="number" name="montant_retrait" step="0.01" required>

        <input type="submit" value="Retirer">
    </form>

</body>
</html>

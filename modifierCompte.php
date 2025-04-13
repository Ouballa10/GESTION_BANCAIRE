<?php
include_once("modeles.php");

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id_compte"])) {
    $id = intval($_GET["id_compte"]);
    $compte = mysqli_query($conn, "SELECT * FROM comptes WHERE id_compte = $id");
    $compteData = mysqli_fetch_assoc($compte);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id_compte"])) {
    $id = intval($_POST["id_compte"]);
    $nom = mysqli_real_escape_string($conn, $_POST["nom"]);
    $solde = floatval($_POST["solde"]);

    mysqli_query($conn, "UPDATE comptes SET nom = '$nom', solde = $solde WHERE id_compte = $id");

    header("Location: comptes.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Compte</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        h2 {
            color: #2f3640;
        }

        form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 350px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #353b48;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #dcdde1;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #44bd32;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-weight: bold;
        }

        input[type="submit"]:hover {
            background-color: #4cd137;
        }

        a {
            margin-top: 20px;
            display: inline-block;
            text-decoration: none;
            color: #273c75;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
        .nav-top {
    position: fixed;
    top: 20px;
    left: 20px;
    background-color: #2c3e50;
    color: white;
    padding: 10px 18px;
    border-radius: 30px;
    text-decoration: none;
    font-size: 15px;
    font-weight: bold;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    z-index: 1000;
    transition: background-color 0.3s ease;
}

.nav-top:hover {
    background-color: #34495e;
}

    </style>
</head>
<body>
<a href="index.php" class="nav-top">⬅ Retour au menu</a>

    <h2>Modifier le Compte</h2>
    <form method="POST">
        <input type="hidden" name="id_compte" value="<?= $compteData['id_compte'] ?>">
        
        <label>Nom:</label>
        <input type="text" name="nom" value="<?= htmlspecialchars($compteData['nom']) ?>" required>
        
        <label>Solde (€):</label>
        <input type="number" step="0.01" name="solde" value="<?= htmlspecialchars($compteData['solde']) ?>" required>
        
        <input type="submit" value="Enregistrer les modifications">
    </form>

    <a href="comptes.php">⬅ Retour à la liste des comptes</a>
</body>
</html>

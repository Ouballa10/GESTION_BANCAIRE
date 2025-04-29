<?php
include_once("modeles.php");
$message = "";
$classe_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num_compte = $_POST["num_compte"];
    $nom = $_POST["nom"];
    $solde = !empty($_POST["solde"]) ? $_POST["solde"] : 0;

    if (!empty($num_compte) && !empty($nom)) {
        if (is_numeric($num_compte) && strlen($num_compte) >= 16) {
            mysqli_query($conn, "INSERT INTO comptes (num_compte, nom, solde) VALUES ('$num_compte', '$nom', '$solde')");
            $message = "✅ Compte ajouté avec succès !";
            $classe_message = "success";
        } else {
            $message = "⚠️ Le Numéro du Compte doit contenir uniquement des chiffres et être d'au moins 16 chiffres.";
            $classe_message = "error";
        }
    } else {
        $message = "⚠️ Numéro du compte et Nom sont obligatoires.";
        $classe_message = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Compte</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f1f4f9, #dff1ff);
            padding: 50px;
            margin: 0;
        }

        .container {
            width: 100%;
            max-width: 450px;
            margin: auto;
            background: #ffffff;
            padding: 30px 25px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.6s ease;
            position: relative;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
            color: #444;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            margin-top: 8px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 15px;
            transition: border-color 0.3s;
        }

        input:focus {
            border-color: #009879;
            outline: none;
        }

        input[type="submit"] {
            background: #009879;
            color: white;
            border: none;
            margin-top: 25px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            border-radius: 12px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background: #007d68;
        }

        .message {
            text-align: center;
            margin-bottom: 20px;
            font-size: 17px;
            font-weight: bold;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #009879;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .nav-top {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: #009879;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .nav-top:hover {
            background-color: #007d68;
        }
    </style>
</head>
<body>

<a href="index.php" class="nav-top">⬅ Retour au menu</a>

<div class="container">

    <?php if (!empty($message)): ?>
        <div class="message <?= $classe_message ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <h2>Ajouter un Compte</h2>

    <form method="POST">
        <label>Numéro du Compte *</label>
        <input type="text" name="num_compte" required pattern="\d{16,}" title="Le numéro de compte doit contenir uniquement des chiffres et au moins 16 chiffres." minlength="16">

        <label>Nom *</label>
        <input type="text" name="nom" required>

        <label>Solde Initial (MAD)</label>
        <input type="number" step="0.01" name="solde" placeholder="0.00">

        <input type="submit" value="Créer le Compte">
    </form>

    <a href="index.php">⬅ Retour au menu</a>

</div>

</body>
</html>

<?php
include_once("modeles.php");

$message = "";

// جلب الحسابات من قاعدة البيانات
$comptes = getComptes();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $compte1 = $_POST["compte_source"];
    $compte2 = $_POST["compte_dest"];
    $montant = $_POST["montant"];
    $description = $_POST["description"];

    if (!empty($compte1) && !empty($compte2) && !empty($montant)) {
        if ($compte1 == $compte2) {
            $message = "⚠️ Le compte source et le compte destination doivent être différents.";
        } else {
            $solde_source = getSoldeCompte($compte1);

            if ($solde_source >= $montant) {
                updateSolde($compte1, -$montant);
                updateSolde($compte2, $montant);
                addTransaction($compte1, $compte2, $montant, $description);

                $message = "✅ Virement effectué avec succès.";
            } else {
                $message = "❌ Solde insuffisant dans le compte source.";
            }
        }
    } else {
        $message = "⚠️ Tous les champs obligatoires doivent être remplis.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Virement</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #a1c4fd, #c2e9fb);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h2 {
            text-align: center;
            color: #2f3640;
            margin-bottom: 25px;
        }

        label {
            font-weight: bold;
            color: #34495e;
        }

        select, input[type="number"], textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 15px;
        }

        input[type="submit"] {
            background-color: #009879;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #007f67;
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
            background-color: #34495e;
        }
    </style>
</head>
<body>
<a href="index.php" class="nav-top">⬅ Retour au menu</a>

<div class="container">

    <?php if (!empty($message)): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; font-size: 18px; font-weight: bold; text-align: center; box-shadow: 0px 4px 10px rgba(0,0,0,0.1);">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <h2>Ajouter un Virement</h2>
    <form method="POST">
        <label>Compte Source *</label>
        <select name="compte_source" required>
            <option value="">-- Choisir un compte --</option>
            <?php foreach ($comptes as $compte): ?>
                <option value="<?= $compte['id_compte'] ?>">
                    <?= $compte['id_compte'] ?> - <?= htmlspecialchars($compte['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Compte Destination *</label>
        <select name="compte_dest" required>
            <option value="">-- Choisir un compte --</option>
            <?php foreach ($comptes as $compte): ?>
                <option value="<?= $compte['id_compte'] ?>">
                    <?= $compte['id_compte'] ?> - <?= htmlspecialchars($compte['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Montant *</label>
        <input type="number" name="montant" step="0.01" required>

        <label>Description</label>
        <textarea name="description" rows="4" placeholder="Ex: Paiement de facture, transfert entre comptes..."></textarea>

        <input type="submit" value="Valider">
    </form>



</div>

</body>
</html>

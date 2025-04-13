<?php
include_once("modeles.php");

// Recherche par nom ou numéro de compte
$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchNumCompte = isset($_GET['search_num']) ? $_GET['search_num'] : '';

if (!empty($search)) {
    $search = mysqli_real_escape_string($conn, $search);
    $query = "SELECT * FROM comptes WHERE nom LIKE '%$search%'";
    $comptes = mysqli_query($conn, $query);
} elseif (!empty($searchNumCompte)) {
    $searchNumCompte = mysqli_real_escape_string($conn, $searchNumCompte);
    $query = "SELECT * FROM comptes WHERE num_compte LIKE '%$searchNumCompte%'";
    $comptes = mysqli_query($conn, $query);
} else {
    $comptes = getLignes("comptes");
}
?>

<!-- ... tout le code PHP au-dessus reste inchangé ... -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Comptes</title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        function resetSearch() {
            document.querySelector('input[name="search"]').value = '';
            document.querySelector('input[name="search_num"]').value = '';
            window.location.href = window.location.pathname;
        }
    </script>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #dfe6e9, #aab7b8);
            margin: 0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
        }

        .content-wrapper {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1200px;
        }

        h2 {
            text-align: center;
            color: #34495e;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 30px;
        }

        input[type="text"], input[type="number"] {
            padding: 12px;
            width: 250px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        input[type="text"]:focus, input[type="number"]:focus {
            border-color: #2980b9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #f5f5f5;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #2980b9;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #ecf0f1;
        }

        tr:hover {
            background-color: #dfe6e9;
        }

        /* Boutons généraux */
        button, .btn-deposer, .btn-modifier, .btn-supprimer, .btn-retirer {
            padding: 10px 18px;
            font-size: 14px;
            border: none;
            border-radius: 12px;
            color: white;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.2s;
        }

        /* Couleurs par type */
        input[type="submit"][value="Rechercher"], .btn-modifier {
            background-color: #2980b9;
        }

        button, .btn-deposer {
            background-color: #27ae60;
        }

        .btn-supprimer {
            background-color: #e74c3c;
        }

        .btn-retirer {
            background-color: #c0392b;
        }

        button:hover,
        .btn-deposer:hover,
        .btn-modifier:hover,
        .btn-supprimer:hover,
        .btn-retirer:hover,
        input[type="submit"]:hover {
            transform: scale(1.05);
            opacity: 0.9;
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

        @media screen and (max-width: 768px) {
            table {
                font-size: 13px;
            }
            td input[type="number"] {
                width: 100px;
            }
            input[type="text"] {
                width: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <a href="index.php" class="nav-top">⬅ Retour au menu</a>
        <h2>Liste des Comptes</h2>

        <form method="GET">
            <input type="text" name="search" placeholder="🔍 Rechercher par nom" value="<?= htmlspecialchars($search) ?>">
            <input type="text" name="search_num" placeholder="🔍 Rechercher par numéro de compte" value="<?= htmlspecialchars($searchNumCompte) ?>">
            <input type="submit" value="Rechercher">
            <button type="button" onclick="resetSearch()">Afficher tous les comptes</button>
        </form>

        <table>
            <tr>
                <th>Numéro de Compte</th>
                <th>Nom</th>
                <th>Solde (€)</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($comptes as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['num_compte'] ?? '') ?></td>
                <td><?= htmlspecialchars($c['nom']) ?></td>
                <td><?= htmlspecialchars(number_format($c['solde'], 2)) ?></td>
                <td>
                    <form method="POST" action="depositCompte.php">
                        <input type="hidden" name="id_compte" value="<?= $c['id_compte'] ?>">
                        <input type="number" step="0.01" name="montant" placeholder="Déposer" required>
                        <button type="submit" class="btn-deposer">Déposer</button>
                    </form>

                    <form method="GET" action="modifierCompte.php">
                        <input type="hidden" name="id_compte" value="<?= $c['id_compte'] ?>">
                        <button type="submit" class="btn-modifier">Modifier</button>
                    </form>

                    <form method="POST" action="deleteCompte.php" onsubmit="return confirm('هل أنت متأكد من حذف هذا الحساب؟');">
                        <input type="hidden" name="id_compte" value="<?= $c['id_compte'] ?>">
                        <button type="submit" class="btn-supprimer">🗑 Supprimer</button>
                    </form>

                    <form method="POST" action="withdrawCompte.php">
                        <input type="hidden" name="id_compte" value="<?= $c['id_compte'] ?>">
                        <input type="number" step="0.01" name="montant_retrait" placeholder="Retirer" required>
                        <button type="submit" class="btn-retirer">Retirer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $("input[name='search']").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "autocomplete.php",
                        method: "GET",
                        data: { search: request.term },
                        dataType: "json",
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                minLength: 2
            });

            $("input[name='search_num']").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "autocomplete.php",
                        method: "GET",
                        data: { search_num: request.term },
                        dataType: "json",
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                minLength: 2
            });
        });
    </script>
    
</body>
</html>


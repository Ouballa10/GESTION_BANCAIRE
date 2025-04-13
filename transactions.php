<?php 
include_once("modeles.php");

$query = "
    SELECT t.id_transaction, t.date_transaction, 
           cs.nom AS nom_source, 
           cd.nom AS nom_dest, 
           t.montant, t.description
    FROM transactions t
    LEFT JOIN comptes cs ON t.compte_source = cs.id_compte
    LEFT JOIN comptes cd ON t.compte_dest = cd.id_compte
    ORDER BY t.id_transaction DESC
";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Transactions</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
     body {
    background-color: #f4f6f7; /* خلفية بيج فاتح */
    color: #34495e; /* نصوص رمادي داكن */
    font-family: 'Arial', sans-serif;
}

header {
    background-color: #2c3e50; /* أزرق غامق */
    color: white; /* نصوص بيضاء */
    padding: 20px 0;
    text-align: center;
    font-size: 24px;
}

button {
    background-color: #27ae60; /* أخضر متوسط */
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #2ecc71; /* أخضر فاتح عند المرور */
}

h1 {
    text-align: center;
    font-size: 32px;
    color: #2c3e50;
    margin-bottom: 40px;
    text-shadow: 1px 1px 2px #ccc;
    animation: fadeIn 1s ease-out;
}

table {
    width: 90%;
    margin: auto;
    border-collapse: collapse;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    border-radius: 10px;
    overflow: hidden;
}

th, td {
    padding: 12px;
    border: 1px solid #ccc;
    text-align: center;
    transition: transform 0.3s ease;
}

th {
    background-color: #009879;
    color: white;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #d1f0e1;
    cursor: pointer;
    transform: scale(1.05);
}

a {
    display: block;
    text-align: center;
    margin-top: 30px;
    text-decoration: none;
    color: purple;
    font-weight: bold;
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

.return-link {
    background-color: #2c3e50;
    color: white;
    padding: 10px 20px;
    border-radius: 25px;
    width: fit-content;
    margin: 40px auto;
    text-decoration: none;
    font-weight: bold;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    transition: background-color 0.3s ease;
}

.return-link:hover {
    background-color: #34495e;
}

.delete-btn {
    background-color: #e74c3c;
    color: white;
    padding: 5px 15px;
    border-radius: 15px;
    cursor: pointer;
    border: none;
}

.delete-btn:hover {
    background-color: #c0392b;
}

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    animation: fadeInModal 0.5s;
}

.modal-content {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    text-align: center;
}

.modal-btn {
    background-color:rgb(248, 72, 52);
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    margin: 10px;
    cursor: pointer;
}

.modal-btn:hover {
    background-color:rgb(43, 192, 63);
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes fadeInModal {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

    </style>
</head>
<body>

<a href="index.php" class="nav-top">⬅ Retour au menu</a>

<h1>Liste des Transactions</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Source</th>
        <th>Destination</th>
        <th>Montant</th>
        <th>Description</th>
        <th>Action</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['id_transaction'] ?></td>
            <td><?= $row['date_transaction'] ?></td>
            <td><?= htmlspecialchars($row['nom_source'] ?? 'Inconnu') ?></td>
            <td><?= htmlspecialchars($row['nom_dest'] ?? 'Inconnu') ?></td>
            <td><?= number_format($row['montant'], 2) ?> €</td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><button class="delete-btn" onclick="openModal(<?= $row['id_transaction'] ?>)">Supprimer</button></td>
        </tr>
    <?php endwhile; ?>
</table>

<a href="index.php" class="return-link">⬅ Retour au menu</a>

<!-- Modal de confirmation -->
<div id="modal" class="modal">
    <div class="modal-content">
        <h3>Êtes-vous sûr de vouloir supprimer cette transaction ?</h3>
        <button class="modal-btn" id="confirmDelete">Oui</button>
        <button class="modal-btn" id="cancelDelete">Non</button>
    </div>
</div>

<script>
    function openModal(transactionId) {
        const modal = document.getElementById('modal');
        modal.style.display = 'flex';

        document.getElementById('confirmDelete').onclick = function() {
            $.ajax({
                url: 'delete_transaction.php',
                type: 'POST',
                data: { id_transaction: transactionId },
                success: function(response) {
                    if (response === 'success') {
                        alert('Transaction supprimée avec succès.');
                        location.reload();  // Recharger la page après la suppression
                    } else {
                        alert('Une erreur est survenue lors de la suppression.');
                    }
                }
            });
            modal.style.display = 'none';
        };

        document.getElementById('cancelDelete').onclick = function() {
            modal.style.display = 'none';
        };
    }
</script>

</body>
</html>

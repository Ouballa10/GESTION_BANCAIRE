<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Menu Principal</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #74ebd5, #acb6e5);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        h1 {
            color: #2f3640;
            margin-bottom: 40px;
        }

        ul {
            list-style: none;
            padding: 0;
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        li {
            display: flex;
            justify-content: center;
        }

        a {
            background-color: white;
            color: #009879;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            font-size: 18px;
            font-weight: 600;
            width: 250px;
            text-align: center;
        }

        a:hover {
            background-color: #009879;
            color: white;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <h1>Menu Principal</h1>
    <ul>
        <li><a href="addVirement.php">Ajouter un virement</a></li>
        <li><a href="transactions.php">Voir les virements</a></li>
        <li><a href="addCompte.php">Ajouter un compte</a></li>
        <li><a href="comptes.php">Liste des Comptes</a></li>
    </ul>
</body>
</html>

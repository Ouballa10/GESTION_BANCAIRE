<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "banquedb");

if (!$conn) {
    die("Connexion échouée : " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    // Préparation de la requête pour chercher l'utilisateur par email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Vérification du mot de passe
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirection vers index.php après connexion réussie
            header("Location: index.php");
            exit;
        } else {
            $error = "Mot de passe incorrect.";
        }
    } else {
        $error = "Aucun compte trouvé avec cet email.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #43cea2, #185a9d);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            width: 350px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #185a9d;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
        }

        button:hover {
            background: #2c82c9;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        p {
            text-align: center;
        }

        a {
            color: #185a9d;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Connexion</h2>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <label>Email :</label><br>
        <input type="email" name="email" required><br>

        <label>Mot de passe :</label><br>
        <input type="password" name="password" required><br>
   


        <button type="submit">Se connecter</button>
        <p>Mot de passe oublié ? <a href="forgot_password.php">Réinitialiser</a></p>
    </form>
    <p>Pas encore de compte ? <a href="register.php">S'inscrire</a></p>
</div>
</body>
</html>

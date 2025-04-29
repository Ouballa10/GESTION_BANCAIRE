<?php  
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ici, si l'utilisateur est connecté, la page continue et le HTML s'affiche normalement
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Menu Principal</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
      color: #1f2937;
      min-height: 100vh;
    }

    header {
      background: white;
      padding: 1.5rem 2rem;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    header h1 {
      font-size: 1.8rem;
      color: #4f46e5;
    }

    header .logout-btn {
      background: #f44336;
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 0.5rem;
      text-decoration: none;
      font-weight: 600;
    }

    header .logout-btn:hover {
      background: #d32f2f;
    }

    .container {
      max-width: 1100px;
      margin: 0 auto;
      padding: 3rem 1.5rem;
      text-align: center;
    }

    .container h2 {
      font-size: 2.5rem;
      margin-bottom: 1rem;
      font-weight: 700;
      color: #111827;
    }

    .container p {
      color: #6b7280;
      font-size: 1.1rem;
      margin-bottom: 3rem;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 1.5rem;
    }

    .card {
      background: white;
      padding: 1.5rem;
      border-radius: 1rem;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.07);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      text-decoration: none;
      color: inherit;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
    }

    .card svg {
      width: 40px;
      height: 40px;
      color: #4f46e5;
      margin-bottom: 1rem;
    }

    .card h3 {
      font-size: 1.2rem;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <header>
    <h1>💳 Gestion Bancaire</h1>
    <a class="logout-btn" href="logout.php">Se déconnecter</a>
  </header>

  <div class="container">
    <h2>Bienvenue dans le tableau de bord</h2>
    <p>Choisissez une action à effectuer ci-dessous :</p>

    <div class="grid">
      <a class="card" href="addVirement.php">
        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M12 4.5v15m7.5-7.5h-15"></path>
        </svg>
        <h3>Ajouter un virement</h3>
      </a>

      <a class="card" href="transactions.php">
        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M3 10h18M3 14h18"></path>
        </svg>
        <h3>Voir les virements</h3>
      </a>

      <a class="card" href="addCompte.php">
        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M12 4.5v15m7.5-7.5h-15"></path>
        </svg>
        <h3>Ajouter un compte</h3>
      </a>

      <a class="card" href="comptes.php">
        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M4.5 6h15M4.5 12h15M4.5 18h15"></path>
        </svg>
        <h3>Liste des comptes</h3>
      </a>
    </div>
  </div>
</body>
</html>

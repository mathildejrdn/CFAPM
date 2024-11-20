<?php
session_start(); // Démarre la session

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    echo "Vous devez être connecté pour voir vos chats.";
    exit; // Empêche l'accès à la page si l'utilisateur n'est pas connecté
}

// Connexion à la base de données
require_once 'open_bdd.php'; // Ton fichier de connexion à la base de données

try {
    // Connexion à la base de données avec les paramètres définis dans open_bdd.php
    $db = new PDO("mysql:host=$server_name;dbname=$db_name;charset=utf8mb4", $user_name, $db_password);
    // Définir les attributs pour les erreurs PDO
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Affiche les erreurs sous forme d'exception
} catch (PDOException $e) {
    // Gestion d'erreur en cas d'échec de connexion
    die("Échec de la connexion à la base de données : " . $e->getMessage());
}

// Récupérer l'ID de l'utilisateur connecté
$user_id = $_SESSION['user']['user_id']; // Récupère l'ID de l'utilisateur connecté

// Récupérer les chats de l'utilisateur connecté
$query = "SELECT * FROM Cat WHERE user_id = :user_id";
$stmt = $db->prepare($query);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT); // Utilisation de l'ID utilisateur
$stmt->execute();
$chats = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Suppression d'un chat si la demande est effectuée
if (isset($_GET['delete'])) {
    $cat_id = $_GET['delete'];
    
    // Requête SQL pour supprimer le chat
    $deleteQuery = "DELETE FROM Cat WHERE cat_id = :cat_id";
    $deleteStmt = $db->prepare($deleteQuery);
    $deleteStmt->bindValue(':cat_id', $cat_id, PDO::PARAM_INT);
    if ($deleteStmt->execute()) {
        echo "Le chat a été supprimé avec succès.";
        header('Location: cats.php'); // Rediriger pour éviter une nouvelle soumission
        exit;
    } else {
        echo "Erreur lors de la suppression du chat.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Chats</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        .container {
            width: 90%;
            margin: 0 auto;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        td {
            background-color: #f9f9f9;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .actions a {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .actions a.delete {
            background-color: red;
        }
        .actions a:hover {
            background-color: #45a049;
        }
        .actions a.delete:hover {
            background-color: #d9534f;
        }
        /* Responsive Design */
        @media screen and (max-width: 768px) {
            table, th, td {
                font-size: 14px;
            }
            .actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<h1>Vos Chats</h1>
<a href="add_cat.php">
    <button>Ajouter un Chat</button>
</a>


<div class="container">
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Date de Naissance</th>
                <th>Sexe</th>
                <th>Race</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($chats as $chat): ?>
            <tr>
                <td><?php echo htmlspecialchars($chat['name']); ?></td>
                <td><?php echo htmlspecialchars($chat['birthdate']); ?></td>
                <td><?php echo htmlspecialchars($chat['sex']); ?></td>
                <td><?php echo htmlspecialchars($chat['breed']); ?></td>
                <td class="actions">
                    <a href="edit_cat.php?cat_id=<?php echo $chat['cat_id']; ?>">Modifier</a>
                    <a href="?delete=<?php echo $chat['cat_id']; ?>" class="delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce chat ?');">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
session_start();
require_once("open_bdd.php");

// Vérifier si l'utilisateur est connecté et a le rôle d'admin
if (!isset($_SESSION["user"]) || !isset($_SESSION["user"]["role"]) || $_SESSION["user"]["role"] !== 'admin') {
    // Si l'utilisateur n'est pas connecté ou n'est pas admin, redirige vers la page de connexion
    header("Location: login.php");
    exit();
}

// Code pour récupérer les utilisateurs et afficher le back office
$sql = "SELECT u.user_id, u.email, u.name, u.surname, a.role FROM User u LEFT JOIN admin a ON u.user_id = a.user_id";
$query = $db->prepare($sql);
$query->execute();
$users = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back Office - Gestion des utilisateurs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Gestion des utilisateurs</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Nom</th>
                <th>Surnom</th>
                <th>Rôle</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['surname']); ?></td>
                    <td><?php echo isset($user['role']) && $user['role'] ? htmlspecialchars($user['role']) : 'Utilisateur'; ?></td>
                    <td>
                        <!-- Formulaire pour attribuer le rôle admin -->
                        <?php if (empty($user['role']) || $user['role'] != 'admin'): ?>
                            <form action="update_role.php" method="POST">
                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                <button type="submit" name="set_admin">Donner le rôle admin</button>
                            </form>
                        <?php else: ?>
                            <span>Déjà Admin</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>

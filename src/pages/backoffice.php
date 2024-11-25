<?php
session_start();
require_once("open_bdd.php");

// Vérifier le chemin absolu pour TCPDF
$filePath = $_SERVER['DOCUMENT_ROOT'] . '/tcpdf/tcpdf.php';

if (file_exists($filePath)) {
    require_once($filePath);
} else {
    echo "Le fichier TCPDF n'a pas été trouvé à l'emplacement suivant : $filePath";
}

// Vérifier si l'utilisateur est connecté et a le rôle d'admin
if (!isset($_SESSION["user"]) || !isset($_SESSION["user"]["role"]) || $_SESSION["user"]["role"] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Récupérer les utilisateurs
$sql = "SELECT u.user_id, u.email, u.name, u.surname, a.role FROM User u LEFT JOIN admin a ON u.user_id = a.user_id";
$query = $db->prepare($sql);
$query->execute();
$users = $query->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les expositions disponibles (table renommée en Cat_show)
$sql_show = "SELECT * FROM `Cat_show`";  // Utilisation du bon nom de table
$query_show = $db->prepare($sql_show);
$query_show->execute();
$shows = $query_show->fetchAll(PDO::FETCH_ASSOC);
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

    <h2>Gestion des expositions</h2>
<?php if ($_SESSION["user"]["role"] === 'admin'): ?>
    <h3>Ajouter une nouvelle exposition</h3>
    <form action="add_exposition.php" method="POST">
        <label for="date_show">Date de l'exposition:</label>
        <input type="date" name="date_show" required><br>

        <label for="show_adress">Adresse:</label>
        <input type="text" name="show_adress" required><br>

        <label for="show_city">Ville:</label>
        <input type="text" name="show_city" required><br>

        <label for="number_show">Numéro de l'exposition:</label>
        <input type="text" name="number_show" required><br>

        <button type="submit">Ajouter</button>
    </form>

    <h3>Liste des expositions</h3>
    <table>
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Date</th>
                <th>Adresse</th>
                <th>Ville</th>
                <th>Numéro d'exposition</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shows as $show): ?>
                <tr>
                    <td><?php echo htmlspecialchars($show['show_id']); ?></td>
                    <td><?php echo htmlspecialchars($show['date_show']); ?></td>
                    <td><?php echo htmlspecialchars($show['show_adress']); ?></td>
                    <td><?php echo htmlspecialchars($show['show_city']); ?></td>
                    <td><?php echo htmlspecialchars($show['number_show']); ?></td>
                    <td>
                        <!-- Lien pour voir le PDF -->
                        <a href="view_pdf.php?id=<?php echo $show['show_id']; ?>" target="_blank">Voir le PDF</a>
 |
                        <!-- Actions pour modifier ou supprimer l'exposition -->
                        <a href="edit_exposition.php?id=<?php echo $show['show_id']; ?>">Modifier</a> | 
                        <a href="delete_exposition.php?id=<?php echo $show['show_id']; ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Accès interdit. Vous devez être administrateur pour voir cette section.</p>
<?php endif; ?>




</body>
</html>

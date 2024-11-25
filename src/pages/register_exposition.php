<?php
session_start();
require_once("open_bdd.php"); // Connexion à la base de données

// Vérifier que l'utilisateur est bien connecté
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// Récupérer tous les chats de l'utilisateur
$user_id = $_SESSION['user']['user_id'];
$sql_cats = "SELECT * FROM `Cat` WHERE `user_id` = :user_id"; // Récupérer tous les chats de l'utilisateur
$query_cats = $db->prepare($sql_cats);
$query_cats->execute([':user_id' => $user_id]);
$cats = $query_cats->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les expositions disponibles (Cat_show)
$sql_show = "SELECT * FROM `Cat_show`";
$query_show = $db->prepare($sql_show);
$query_show->execute();
$shows = $query_show->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les informations de l'utilisateur
    $user_id = $_SESSION['user']['user_id'];
    $show_id = $_POST['show_id'];

    // Vérifier que l'ID de l'exposition est bien passé
    if (!isset($show_id)) {
        echo "L'ID de l'exposition est manquant.";
        exit();
    }

    // Récupérer les informations de l'exposition sélectionnée
    $sql_show_details = "SELECT * FROM `Cat_show` WHERE show_id = :show_id";
    $query_show_details = $db->prepare($sql_show_details);
    $query_show_details->execute([':show_id' => $show_id]);
    $show = $query_show_details->fetch(PDO::FETCH_ASSOC);

    if ($show) {
        // Enregistrer l'inscription dans la table Registrations
        $price = 1; // Prix par défaut de 1€
        $pdf_path = "uploads/{$show['show_id']}_bulletin.pdf"; // Chemin vers le PDF
        
        // Préparer la requête d'insertion dans la table Registrations
        $sql = "INSERT INTO `Registrations` (user_id, show_id, price, pdf_path) 
                VALUES (:user_id, :show_id, :price, :pdf_path)";
        $query = $db->prepare($sql);
        $query->execute([ 
            ':user_id' => $user_id,
            ':show_id' => $show_id,
            ':price' => $price,
            ':pdf_path' => $pdf_path
        ]);

        // Si des chats ont été sélectionnés, enregistrer chaque chat dans la table Cat_registration
        if (isset($_POST['cats']) && !empty($_POST['cats'])) {
            foreach ($_POST['cats'] as $cat_id) {
                // Insérer chaque chat dans la table `Cat_registration`
                $sql_cat_registration = "INSERT INTO `Cat_registration` (user_id, cat_id, show_id) 
                                         VALUES (:user_id, :cat_id, :show_id)";
                $query_cat_registration = $db->prepare($sql_cat_registration);
                $query_cat_registration->execute([ 
                    ':user_id' => $user_id,
                    ':cat_id' => $cat_id,
                    ':show_id' => $show_id
                ]);
            }
        }

        // Afficher le message avec le lien vers le PDF généré
        echo "Inscription réussie ! Vous pouvez consulter votre PDF <a href='view_pdf.php?id={$show['show_id']}' target='_blank'>ici</a>.";

        exit();
    } else {
        echo "L'exposition n'existe pas.";
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'inscrire à une Exposition</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>S'inscrire à une Exposition</h1>

<!-- Formulaire d'inscription -->
<form action="register_exposition.php" method="POST">
    <label for="show_id">Choisir une exposition :</label>
    <select name="show_id" id="show_id" required>
        <option value="">-- Sélectionnez une exposition --</option>
        <?php foreach ($shows as $show): ?>
            <option value="<?php echo $show['show_id']; ?>">
                Exposition N°: <?php echo $show['number_show']; ?> - Date: <?php echo $show['date_show']; ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <!-- Sélection des chats -->
    <label for="cats">Sélectionner vos chats (vous pouvez en ajouter plusieurs) :</label><br>
    <div id="cats_container">
        <?php foreach ($cats as $cat): ?>
            <input type="checkbox" name="cats[]" value="<?php echo $cat['cat_id']; ?>">
            <label>
                <?php echo $cat['name'] . ' - ' . $cat['breed']; ?> 
                (Sexe: <?php echo $cat['sex']; ?>, Yeux: <?php echo $cat['eyes']; ?>, Couleur: <?php echo $cat['color']; ?>)
            </label><br>
        <?php endforeach; ?>
    </div><br>

    <button type="submit">S'inscrire</button>
</form>

</body>
</html>

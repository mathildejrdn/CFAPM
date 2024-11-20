<?php
// Démarre la session
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
require_once('open_bdd.php');

// Récupérer l'ID de l'utilisateur connecté
$user_id = $_SESSION['user']['user_id'];

// Prépare la requête pour récupérer les informations de l'utilisateur
$sql = "SELECT * FROM User WHERE user_id = :user_id";
$query = $db->prepare($sql);
$query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$query->execute();

// Récupérer les données utilisateur
$user = $query->fetch(PDO::FETCH_ASSOC);

// Si l'utilisateur n'existe pas dans la base de données
if (!$user) {
    echo "Utilisateur introuvable.";
    exit();
}

// Pour le débogage, afficher les données récupérées
// var_dump($user);

// Récupérer les informations pour afficher dans le formulaire
$name = htmlspecialchars($user['name']);
$surname = htmlspecialchars($user['surname']);
$email = htmlspecialchars($user['email']);
$phone = htmlspecialchars($user['phone']);
$adress = htmlspecialchars($user['adress']);

// Si le formulaire est soumis, mettre à jour les informations de l'utilisateur
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérification des champs non vides
    if (isset($_POST['name'], $_POST['surname'], $_POST['email'], $_POST['phone'], $_POST['adress']) &&
        !empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['email']) && !empty($_POST['phone']) && !empty($_POST['adress'])) {

        // Récupérer les données du formulaire
        $new_name = strip_tags($_POST['name']);
        $new_surname = strip_tags($_POST['surname']);
        $new_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? $_POST['email'] : $email;
        $new_phone = strip_tags($_POST['phone']);
        $new_adress = strip_tags($_POST['adress']);

        // Préparer la requête de mise à jour
        $update_sql = "UPDATE User SET name = :name, surname = :surname, email = :email, phone = :phone, adress = :adress WHERE user_id = :user_id";
        $update_query = $db->prepare($update_sql);

        // Lier les valeurs des champs du formulaire
        $update_query->bindValue(':name', $new_name);
        $update_query->bindValue(':surname', $new_surname);
        $update_query->bindValue(':email', $new_email);
        $update_query->bindValue(':phone', $new_phone);
        $update_query->bindValue(':adress', $new_adress);
        $update_query->bindValue(':user_id', $user_id, PDO::PARAM_INT);

        // Exécuter la requête de mise à jour
        $update_query->execute();

        // Mettre à jour les informations de la session
        $_SESSION['user']['name'] = $new_name;
        $_SESSION['user']['surname'] = $new_surname;
        $_SESSION['user']['email'] = $new_email;
        $_SESSION['user']['phone'] = $new_phone;
        $_SESSION['user']['adress'] = $new_adress;

        // Message de succès
        $_SESSION['message'] = 'Les informations ont été mises à jour avec succès.';

        // Redirection vers la page du profil après la mise à jour
        header('Location: profile.php');
        exit();
    } else {
        // Message d'erreur si le formulaire est incomplet
        $_SESSION['message'] = 'Veuillez remplir tous les champs.';
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 100%;
            max-width: 400px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .alert_message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        .success_message {
            color: green;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Mon Profil</h1>

        <!-- Affichage des messages d'erreur ou de succès -->
        <?php
        if (isset($_SESSION['message'])) {
            echo '<div class="' . (strpos($_SESSION['message'], 'Erreur') !== false ? 'alert_message' : 'success_message') . '">' . $_SESSION['message'] . '</div>';
            unset($_SESSION['message']);
        }
        ?>

        <!-- Formulaire de mise à jour du profil -->
        <form action="" method="POST">
            <label for="name">Nom</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>

            <label for="surname">Prénom</label>
            <input type="text" id="surname" name="surname" value="<?php echo $surname; ?>" required>

            <label for="email">Adresse Email</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>

            <label for="phone">Téléphone</label>
            <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>" required>

            <label for="adress">Adresse</label>
            <input type="text" id="adress" name="adress" value="<?php echo $adress; ?>" required>

            <button type="submit">Mettre à jour</button>
        </form>

        <!-- Lien de déconnexion -->
        <p style="text-align: center; margin-top: 15px;">Pas encore inscrit ? <a href="inscription.php">Inscrivez-vous ici</a>.</p>
    </div>
</body>

</html>


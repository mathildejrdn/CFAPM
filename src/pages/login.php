<?php
session_start();
require_once("open_bdd.php");

// Fonction pour valider les emails
function ValidateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Traitement du formulaire
if (!empty($_POST)) {
    if (
        isset($_POST["email"], $_POST["password"]) &&
        !empty(trim($_POST["email"])) &&
        !empty(trim($_POST["password"]))
    ) {

        // Vérification de l'email valide
        if (!ValidateEmail($_POST["email"])) {
            // $_SESSION['message'] = "Adresse email invalide.";
            header("Location: login.php");
            exit();
        }

        require_once("open_bdd.php");

        // Préparation de la requête SQL
        $sql = "SELECT u.*, a.role FROM User u LEFT JOIN admin a ON u.user_id = a.user_id WHERE u.email = :email";
        $query = $db->prepare($sql);
        $query->bindValue(':email', $_POST["email"]);
        $query->execute();

        // Vérification si un utilisateur correspond
        $user = $query->fetch(PDO::FETCH_ASSOC);

        // Validation de l'utilisateur et du mot de passe
        if (!$user || !password_verify($_POST["password"], $user["password"])) {
            header("Location: login.php");
            exit();
        }

        // Utilisateur et MDP corrects, on continue pour se connecter en stockant dans la session les infos utilisateur
        $_SESSION["user"] = [
            "user_id" => $user["user_id"],
            "name" => $user["name"],
            "surname" => $user["surname"],
            "email" => $user["email"],
            "phone" => $user["phone"],
            "adress" => $user["adress"],
            "role" => $user["role"] // Le rôle est récupéré ici
        ];

        // Redirection après connexion
        header("Location: index.php");
        exit();
    }

    header("Location: login.php");
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
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

        input[type="email"],
        input[type="password"] {
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
    </style>
</head>

<body>
    <div class="container">
        <h1>Connexion</h1>

        <!-- Message d'erreur ou de succès -->
        <?php
        if (isset($_SESSION['message'])) {
            echo '<div class="alert_message">' . $_SESSION['message'] . '</div>';
            unset($_SESSION['message']);
        }
        ?>

        <!-- Formulaire de connexion -->
        <form action="" method="POST">
            <label for="email">Adresse Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Se connecter</button>
        </form>

        <!-- Lien vers la page d'inscription -->
        <p style="text-align: center; margin-top: 15px;">Pas encore inscrit ? <a href="inscription.php">Inscrivez-vous ici</a>.</p>
    </div>
</body>

</html>


<?php
function ValidateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Traitement du formulaire
if (!empty($_POST)) {
    if (
        isset($_POST["name"], $_POST["surname"], $_POST["email"], $_POST["password"], $_POST["adress"], $_POST["phone"]) &&
        !empty($_POST["name"]) &&
        !empty($_POST["surname"]) &&
        !empty($_POST["email"]) &&
        !empty($_POST["password"]) &&
        !empty($_POST["adress"]) &&
        !empty($_POST["phone"])
    ) {
        // Nettoyage des champs
        $name = strip_tags($_POST["name"]);
        $surname = strip_tags($_POST["surname"]);
        $adress = strip_tags($_POST["adress"]);
        $phone = strip_tags($_POST["phone"]);


        // Validation de l'email
        if (!ValidateEmail($_POST["email"])) {
            die("Ce n'est pas une adresse email valide.");
        }

        // Hash du mot de passe
        $password = password_hash($_POST["password"], PASSWORD_ARGON2ID);



        require_once("./open_bdd.php");

        // Requête SQL avec placeholders
        $sql = "INSERT INTO User (name, surname, email, password, adress, phone) 
                VALUES (:name, :surname, :email, :password, :adress, :phone )";

        $query = $db->prepare($sql);

        // Assignation des valeurs
        $query->bindValue(':name', $name);
        $query->bindValue(':surname', $surname);
        $query->bindValue(':email', $_POST['email']);
        $query->bindValue(':password', $password);
        $query->bindValue(':adress', $adress);
        $query->bindValue(':phone', $phone);

        // Exécution de la requête
        $query->execute();


        header("Location: index.php");
        exit();
    }
    die('Formulaire incomplet.');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
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
        input[type="text"], input[type="email"], input[type="password"], input[type="tel"] {
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
        <h1>Inscription</h1>

        <!-- Affichage d'un message si une erreur ou succès est enregistré -->
        <?php
        if (isset($_SESSION['message'])) {
            echo '<div class="alert_message">' . $_SESSION['message'] . '</div>';
            unset($_SESSION['message']);
        }
        ?>

        <!-- Formulaire d'inscription -->
        <form action="" method="POST">
            <label for="name">Nom</label>
            <input type="text" id="name" name="name" value="<?php echo $_SESSION['name'] ?? ''; ?>" required>

            <label for="surname">Prénom</label>
            <input type="text" id="surname" name="surname" value="<?php echo $_SESSION['surname'] ?? ''; ?>" required>

            <label for="email">Adresse Email</label>
            <input type="email" id="email" name="email" value="<?php echo $_SESSION['email'] ?? ''; ?>" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>

            <label for="adress">Adresse</label>
            <input type="text" id="adress" name="adress" required>

            <label for="phone">Téléphone</label>
            <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required>

            

            <button type="submit">S'inscrire</button>
        </form>

        <!-- Lien vers la page de connexion -->
        <p style="text-align: center; margin-top: 15px;">Déjà inscrit ? <a href="login.php">Connectez-vous ici</a>.</p>
    </div>
</body>
</html>

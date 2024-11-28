<?php
session_start(); // Démarre la session

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    echo "Vous devez être connecté pour modifier un chat.";
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

// Vérifier si un cat_id est passé dans l'URL
if (isset($_GET['cat_id'])) {
    $cat_id = $_GET['cat_id'];

    // Récupérer les informations du chat depuis la base de données
    $query = "SELECT * FROM Cat WHERE cat_id = :cat_id";
    $Catbdd = $db->prepare($query);
    $Catbdd->bindValue(':cat_id', $cat_id, PDO::PARAM_INT);
    $Catbdd->execute();
    $chat = $Catbdd->fetch(PDO::FETCH_ASSOC);

    // Vérifier si le chat appartient à l'utilisateur connecté
    if ((int)$chat['user_id'] !== (int)$_SESSION['user']['user_id']) {
        echo "Vous ne pouvez pas modifier ce chat.";
        exit;
    }
} else {
    echo "Aucun chat sélectionné.";
    exit;
}

// Mise à jour des informations du chat après soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $name = $_POST['name'];
    $birthdate = $_POST['birthdate'];
    $sex = $_POST['sex'];
    $breed = $_POST['breed'];
    $color = $_POST['color'];
    $eyes = $_POST['eyes'];
    $pedigree = $_POST['pedigree'];
    $chip = $_POST['chip'];
    $breeder = $_POST['breeder'];
    $father = $_POST['father'];
    $mother = $_POST['mother'];

    // Requête SQL pour mettre à jour le chat dans la table 'Cat'
    $query = "UPDATE Cat SET name = :name, birthdate = :birthdate, sex = :sex, breed = :breed, color = :color, 
              eyes = :eyes, pedigree = :pedigree, chip = :chip, breeder = :breeder, father = :father, mother = :mother 
              WHERE cat_id = :cat_id";
    
    $Catbdd = $db->prepare($query);
    $Catbdd->bindValue(':name', $name, PDO::PARAM_STR);
    $Catbdd->bindValue(':birthdate', $birthdate, PDO::PARAM_STR);
    $Catbdd->bindValue(':sex', $sex, PDO::PARAM_STR);
    $Catbdd->bindValue(':breed', $breed, PDO::PARAM_STR);
    $Catbdd->bindValue(':color', $color, PDO::PARAM_STR);
    $Catbdd->bindValue(':eyes', $eyes, PDO::PARAM_STR);
    $Catbdd->bindValue(':pedigree', $pedigree, PDO::PARAM_STR);
    $Catbdd->bindValue(':chip', $chip, PDO::PARAM_INT);
    $Catbdd->bindValue(':breeder', $breeder, PDO::PARAM_STR);
    $Catbdd->bindValue(':father', $father, PDO::PARAM_STR);
    $Catbdd->bindValue(':mother', $mother, PDO::PARAM_STR);
    $Catbdd->bindValue(':cat_id', $cat_id, PDO::PARAM_INT);

    // Exécuter la mise à jour
    if ($Catbdd->execute()) {
        // Redirection après mise à jour
        header('Location: cats.php'); 
        exit; // On termine l'exécution du script après la redirection
    } else {
        echo "Erreur lors de la mise à jour du chat.";
    }
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Chat</title>
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
        .form-container {
            width: 90%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input, select {
            margin-bottom: 10px;
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .form-container input[type="submit"] {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h1>Modifier les informations du chat</h1>

<div class="form-container">
    <form action="edit_cat.php?cat_id=<?php echo $cat_id; ?>" method="POST">
        <label for="name">Nom du chat :</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($chat['name']); ?>" required><br>

        <label for="birthdate">Date de naissance :</label>
        <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($chat['birthdate']); ?>" required><br>

        <label for="sex">Sexe :</label>
        <input type="text" id="sex" name="sex" value="<?php echo htmlspecialchars($chat['sex']); ?>" required><br>

        <label for="breed">Race :</label>
        <input type="text" id="breed" name="breed" value="<?php echo htmlspecialchars($chat['breed']); ?>" required><br>

        <label for="color">Couleur :</label>
        <input type="text" id="color" name="color" value="<?php echo htmlspecialchars($chat['color']); ?>" required><br>

        <label for="eyes">Yeux :</label>
        <input type="text" id="eyes" name="eyes" value="<?php echo htmlspecialchars($chat['eyes']); ?>" required><br>

        <label for="pedigree">Pédigrée :</label>
        <input type="text" id="pedigree" name="pedigree" value="<?php echo htmlspecialchars($chat['pedigree']); ?>" required><br>

        <label for="chip">Numéro de puce :</label>
        <input type="number" id="chip" name="chip" value="<?php echo htmlspecialchars($chat['chip']); ?>" required><br>

        <label for="breeder">Éleveur :</label>
        <input type="text" id="breeder" name="breeder" value="<?php echo htmlspecialchars($chat['breeder']); ?>" required><br>

        <label for="father">Père :</label>
        <input type="text" id="father" name="father" value="<?php echo htmlspecialchars($chat['father']); ?>"><br>

        <label for="mother">Mère :</label>
        <input type="text" id="mother" name="mother" value="<?php echo htmlspecialchars($chat['mother']); ?>"><br>

        <input type="submit" value="Mettre à jour">
    </form>
</div>

</body>
</html>

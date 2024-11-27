<?php
session_start(); // Démarre la session

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    echo "Vous devez être connecté pour ajouter un chat.";
    exit; // Empêche l'accès à la page si l'utilisateur n'est pas connecté
}

// // Accéder à l'ID de l'utilisateur connecté
// $user_id = $_SESSION['user']['user_id']; // Récupère l'ID de l'utilisateur connecté
// echo "L'utilisateur connecté a l'ID : " . $user_id . "<br>"; // Affichage pour vérification

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

// Vérifie si le formulaire a été soumis
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

    // Requête SQL pour insérer le chat dans la table 'Cat'
    $query = "INSERT INTO Cat (name, birthdate, sex, breed, color, eyes, pedigree, chip, breeder, father, mother, user_id) 
              VALUES (:name, :birthdate, :sex, :breed, :color, :eyes, :pedigree, :chip, :breeder, :father, :mother, :user_id)";
    
    try {
        // Préparer et exécuter la requête
        $stmt = $db->prepare($query);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':birthdate', $birthdate, PDO::PARAM_STR);
        $stmt->bindValue(':sex', $sex, PDO::PARAM_STR);
        $stmt->bindValue(':breed', $breed, PDO::PARAM_STR);
        $stmt->bindValue(':color', $color, PDO::PARAM_STR);
        $stmt->bindValue(':eyes', $eyes, PDO::PARAM_STR);
        $stmt->bindValue(':pedigree', $pedigree, PDO::PARAM_STR);
        $stmt->bindValue(':chip', $chip, PDO::PARAM_INT);
        $stmt->bindValue(':breeder', $breeder, PDO::PARAM_STR);
        $stmt->bindValue(':father', $father, PDO::PARAM_STR);
        $stmt->bindValue(':mother', $mother, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT); // Utilisation de l'ID utilisateur

        // Exécution de la requête
        if ($stmt->execute()) {
            echo "Chat ajouté avec succès.";
        } else {
            // Récupère l'erreur SQL et l'affiche pour faciliter le débogage
            $errorInfo = $stmt->errorInfo();
            echo "Erreur lors de l'ajout du chat : " . $errorInfo[2];
        }
    } catch (PDOException $e) {
        // Si une erreur se produit lors de l'exécution de la requête
        echo "Erreur SQL : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un chat</title>
    <style>
        label {
            font-weight: bold;
        }
        input, select {
            margin-bottom: 10px;
            padding: 8px;
            width: 100%;
            max-width: 400px;
        }
        form {
            max-width: 600px;
            margin: 20px auto;
            border: 1px solid #ccc;
            padding: 20px;
            background-color: #f9f9f9;
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
    </style>
</head>
<body>

<form action="add_cat.php" method="POST">
    <label for="name">Nom du chat :</label>
    <input type="text" id="name" name="name" required><br>

    <label for="birthdate">Date de naissance :</label>
    <input type="date" id="birthdate" name="birthdate" required><br>

    <label for="sex">Sexe :</label>
    <input type="text" id="sex" name="sex" required><br>

    <label for="breed">Race :</label>
    <input type="text" id="breed" name="breed" required><br>

    <label for="color">Couleur :</label>
    <input type="text" id="color" name="color" required><br>

    <label for="eyes">Yeux :</label>
    <input type="text" id="eyes" name="eyes" required><br>

    <label for="pedigree">Pédigrée :</label>
    <input type="text" id="pedigree" name="pedigree" required><br>

    <label for="chip">Numéro de puce :</label>
    <input type="number" id="chip" name="chip" required><br>

    <label for="breeder">Éleveur :</label>
    <input type="text" id="breeder" name="breeder" required><br>

    <label for="father">Père :</label>
    <input type="text" id="father" name="father" required><br>

    <label for="mother">Mère :</label>
    <input type="text" id="mother" name="mother" required><br>

    <input type="submit" value="Ajouter le chat">
</form>

</body>
</html>

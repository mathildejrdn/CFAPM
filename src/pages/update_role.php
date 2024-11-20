<?php
session_start();
require_once("open_bdd.php");

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["user"])) {
    // Si l'utilisateur n'est pas connecté, redirige vers la page de connexion
    header("Location: login.php");
    exit();
}

// Vérifier si l'action est bien pour attribuer le rôle admin
if (isset($_POST['set_admin']) && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Vérifier si l'utilisateur existe dans la table User
    $sql = "SELECT * FROM User WHERE user_id = :user_id";
    $query = $db->prepare($sql);
    $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Vérifier si l'utilisateur est déjà admin
        $sql_role = "SELECT * FROM admin WHERE user_id = :user_id";
        $query_role = $db->prepare($sql_role);
        $query_role->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query_role->execute();
        $role = $query_role->fetch(PDO::FETCH_ASSOC);

        // Si l'utilisateur n'a pas encore de rôle admin, on l'ajoute
        if (!$role) {
            // Insérer l'utilisateur comme admin dans la table admin
            // Maintenant, on inclut 'email' dans l'insertion
            $sql_insert = "INSERT INTO admin (user_id, role, member, email) VALUES (:user_id, 'admin', 0, :email)";
            $query_insert = $db->prepare($sql_insert);
            $query_insert->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $query_insert->bindParam(':email', $user['email'], PDO::PARAM_STR);
            $query_insert->execute();
        }

        // Rediriger vers le backoffice après la mise à jour
        header("Location: backoffice.php");
        exit();
    } else {
        echo "Utilisateur introuvable.";
    }
} else {
    echo "Erreur : Identifiant utilisateur manquant.";
}
?>

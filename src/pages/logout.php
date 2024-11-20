<?php
session_start(); // Démarre la session

// Détruire toutes les variables de session
$_SESSION = array();

// Si vous voulez détruire complètement la session, vous pouvez aussi supprimer le cookie de session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, 
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]
    );
}

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion ou vers l'index
header("Location: login.php");
exit();
?>

<?php
session_start();
require_once("open_bdd.php");

// Vérifier le chemin absolu pour TCPDF
$filePath = $_SERVER['DOCUMENT_ROOT'] . '/tcpdf/tcpdf.php';

if (file_exists($filePath)) {
    require_once($filePath);
} else {
    echo "Le fichier TCPDF n'a pas été trouvé à l'emplacement suivant : $filePath";
    exit();
}

// Vérifier si l'utilisateur est connecté et a le rôle d'admin
if (!isset($_SESSION["user"]) || !isset($_SESSION["user"]["role"]) || $_SESSION["user"]["role"] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Récupérer l'ID de l'exposition depuis l'URL
$show_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($show_id === null) {
    echo "Aucune exposition spécifiée.";
    exit();
}

// Récupérer les données de l'exposition à partir de la base de données
$sql_show = "SELECT * FROM `Cat_show` WHERE show_id = :show_id";  // Utilisation de l'ID de l'exposition
$query_show = $db->prepare($sql_show);
$query_show->bindParam(':show_id', $show_id, PDO::PARAM_INT);
$query_show->execute();
$show = $query_show->fetch(PDO::FETCH_ASSOC);

if (!$show) {
    echo "Exposition non trouvée.";
    exit();
}

// Récupérer les informations de l'utilisateur inscrit
$sql_user_info = "SELECT u.name, u.email, r.price, r.pdf_path 
                  FROM `Registrations` r
                  JOIN `User` u ON u.user_id = r.user_id
                  WHERE r.show_id = :show_id";
$query_user_info = $db->prepare($sql_user_info);
$query_user_info->bindParam(':show_id', $show_id, PDO::PARAM_INT);
$query_user_info->execute();
$user_info = $query_user_info->fetch(PDO::FETCH_ASSOC);

if (!$user_info) {
    echo "Aucun utilisateur inscrit à cette exposition.";
    exit();
}

// Créer le PDF avec TCPDF
$pdf = new TCPDF();
$pdf->AddPage();

// Ajouter le contenu de l'exposition (exemple)
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, 'Exposition N°: ' . $show['number_show'], 0, 1, 'C');
$pdf->Cell(0, 10, 'Date: ' . $show['date_show'], 0, 1, 'C');
$pdf->Cell(0, 10, 'Adresse: ' . $show['show_adress'], 0, 1, 'C');
$pdf->Cell(0, 10, 'Ville: ' . $show['show_city'], 0, 1, 'C');

// Ajouter les informations de l'utilisateur
$pdf->Ln(10); // Saut de ligne
$pdf->Cell(0, 10, 'Nom de l\'utilisateur: ' . $user_info['name'], 0, 1, 'L');
$pdf->Cell(0, 10, 'Email: ' . $user_info['email'], 0, 1, 'L');
$pdf->Cell(0, 10, 'Prix payé: ' . $user_info['price'] . '€', 0, 1, 'L');


// Générer le PDF et l'afficher dans le navigateur
$pdf->Output('exposition_' . $show_id . '_bulletin.pdf', 'I');  // 'I' pour afficher dans le navigateur
?>

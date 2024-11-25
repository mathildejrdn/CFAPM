<?php
session_start();
require_once("open_bdd.php");

// Désactiver l'affichage des erreurs pour éviter les problèmes avec TCPDF
error_reporting(0); // Désactive tous les rapports d'erreur
ini_set('display_errors', '0'); // Désactive l'affichage des erreurs à l'écran

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
$sql_user_info = "SELECT u.name, u.surname, u.email, u.phone, u.adress, r.price, r.pdf_path, r.user_id
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

// Récupérer les chats inscrits à l'exposition (via la table Cat_registration)
$sql_cats = "SELECT c.cat_id, c.name, c.breed, c.sex, c.color, c.birthdate, c.pedigree, c.chip, c.breeder, c.father, c.mother, c.eyes
             FROM `Cat` c
             JOIN `Cat_registration` cr ON c.cat_id = cr.cat_id
             WHERE cr.show_id = :show_id AND cr.user_id = :user_id"; // On fait la jointure et on filtre par show_id et user_id
$query_cats = $db->prepare($sql_cats);
$query_cats->bindParam(':show_id', $show_id, PDO::PARAM_INT);
$query_cats->bindParam(':user_id', $user_info['user_id'], PDO::PARAM_INT);
$query_cats->execute();
$cats = $query_cats->fetchAll(PDO::FETCH_ASSOC);

// Si aucun chat n'est trouvé, afficher un message
if (empty($cats)) {
    echo "Aucun chat inscrit à cette exposition.";
    exit();
}

// Créer le PDF avec TCPDF
$pdf = new TCPDF();
$pdf->AddPage();

// Ajouter le contenu de l'exposition
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, 'Exposition N°: ' . $show['number_show'], 0, 1, 'C');
$pdf->Cell(0, 10, 'Date: ' . $show['date_show'], 0, 1, 'C');
$pdf->Cell(0, 10, 'Adresse: ' . $show['show_adress'], 0, 1, 'C');
$pdf->Cell(0, 10, 'Ville: ' . $show['show_city'], 0, 1, 'C');

// Ajouter les informations de l'utilisateur
$pdf->Ln(10); // Saut de ligne
$pdf->Cell(0, 10, 'Nom de l\'utilisateur: ' . $user_info['surname'] . ' ' . $user_info['name'], 0, 1, 'L');
$pdf->Cell(0, 10, 'Email: ' . $user_info['email'], 0, 1, 'L');
$pdf->Cell(0, 10, 'Adresse: ' . $user_info['adress'], 0, 1, 'L');
$pdf->Cell(0, 10, 'N° de téléphone: ' . $user_info['phone'], 0, 1, 'L');
$pdf->Cell(0, 10, 'Prix payé: ' . $user_info['price'] . '€', 0, 1, 'L');

// Afficher les chats inscrits à l'exposition
$pdf->Ln(10); // Saut de ligne
$pdf->Cell(0, 10, 'Chats inscrits à l\'exposition:', 0, 1, 'L');
foreach ($cats as $cat) {
    $pdf->Cell(0, 10, 'Nom: ' . $cat['name'], 0, 1, 'L');
    $pdf->Cell(0, 10, 'Race: ' . $cat['breed'], 0, 1, 'L');
    $pdf->Cell(0, 10, 'Sexe: ' . $cat['sex'], 0, 1, 'L');
    $pdf->Cell(0, 10, 'Couleur: ' . $cat['color'], 0, 1, 'L');
    $pdf->Cell(0, 10, 'Date de naissance: ' . $cat['birthdate'], 0, 1, 'L');
    $pdf->Cell(0, 10, 'Pédigrée: ' . $cat['pedigree'], 0, 1, 'L');
    $pdf->Cell(0, 10, 'Chip: ' . $cat['chip'], 0, 1, 'L');
    $pdf->Cell(0, 10, 'Éleveur: ' . $cat['breeder'], 0, 1, 'L');
    $pdf->Cell(0, 10, 'Père: ' . $cat['father'], 0, 1, 'L');
    $pdf->Cell(0, 10, 'Mère: ' . $cat['mother'], 0, 1, 'L');
    $pdf->Cell(0, 10, 'Yeux: ' . $cat['eyes'], 0, 1, 'L');  // Affichage de la couleur des yeux
    $pdf->Ln(5); // Saut de ligne entre chaque chat
}

// Générer le PDF et l'afficher dans le navigateur
$pdf->Output('exposition_' . $show_id . '_bulletin.pdf', 'I');  // 'I' pour afficher dans le navigateur
?>

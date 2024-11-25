<?php
session_start();

// Vérifier si open_bdd.php est accessible
if (!file_exists('./open_bdd.php')) {
    die('Le fichier open_bdd.php est introuvable');
}

require_once('./open_bdd.php');
require_once("../tcpdf/tcpdf.php");

// Vérification de l'accès administrateur
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données envoyées par le formulaire
    $date_show = $_POST['date_show'];
    $show_adress = $_POST['show_adress'];
    $show_city = $_POST['show_city'];
    $number_show = $_POST['number_show'];

    // Valeur par défaut pour pdf_path (vide au départ)
    $pdf_path = ''; // Vous pouvez mettre NULL si vous préférez

    // Insérer l'exposition dans la base de données
    $sql = "INSERT INTO `Cat_show` (date_show, show_adress, show_city, number_show, pdf_path) VALUES (?, ?, ?, ?, ?)";
    $query = $db->prepare($sql);
    $query->execute([$date_show, $show_adress, $show_city, $number_show, $pdf_path]);

    // Récupérer l'ID de l'exposition nouvellement insérée
    $show_id = $db->lastInsertId();

    // Générer le PDF pour cette exposition
    generatePDF($show_id, $date_show, $show_adress, $show_city, $number_show);

    // Rediriger vers la page de gestion après l'ajout
    header("Location: back_office.php");
    exit();
}

// Fonction pour générer le PDF
function generatePDF($show_id, $date_show, $show_adress, $show_city, $number_show) {
    // Création du PDF
    $pdf = new TCPDF();
    $pdf->AddPage();

    // Entête du PDF
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'Bulletin d\'inscription - Exposition #' . $show_id, 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10, 'Date: ' . $date_show, 0, 1);
    $pdf->Cell(0, 10, 'Adresse: ' . $show_adress, 0, 1);
    $pdf->Cell(0, 10, 'Ville: ' . $show_city, 0, 1);
    $pdf->Cell(0, 10, 'Numéro d\'exposition: ' . $number_show, 0, 1);

    // Afficher le PDF dans le navigateur (pas besoin de sauvegarder sur le serveur)
    $pdf->Output('exposition_' . $show_id . '_bulletin.pdf', 'I');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Exposition</title>
</head>
<body>
    <h1>Ajouter une nouvelle exposition</h1>
    <form action="add_exposition.php" method="POST">
        <label for="date_show">Date de l'exposition:</label>
        <input type="date" name="date_show" required><br>

        <label for="show_adress">Adresse:</label>
        <input type="text" name="show_adress" required><br>

        <label for="show_city">Ville:</label>
        <input type="text" name="show_city" required><br>

        <label for="number_show">Numéro de l'exposition:</label>
        <input type="text" name="number_show" required><br>

        <button type="submit">Ajouter l'exposition</button>
    </form>
</body>
</html>

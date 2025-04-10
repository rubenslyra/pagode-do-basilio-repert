<?php
require '../vendor/autoload.php';
require '../config/db.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$logo = '<img src="logo.png" style="height:80px;">';

$stmt = $pdo->query("SELECT * FROM cancoes ORDER BY titulo");
$musicas = $stmt->fetchAll();

$html = "<html><body>$logo<h2>Repertório - Pagode do Basílio</h2><table border='1' width='100%' style='border-collapse: collapse; font-size: 12px'>";
$html .= "<tr><th>Título</th><th>Intérprete</th><th>Gênero / BPM</th><th>Trecho</th></tr>";
foreach ($musicas as $m) {
    $html .= "<tr>
        <td>{$m['titulo']}</td>
        <td>{$m['interprete']}</td>
        <td>{$m['genero_bpm']}</td>
        <td>{$m['trecho']}</td>
    </tr>";
}
$html .= "</table></body></html>";

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("repertorio_pagode_basílio.pdf", ["Attachment" => false]);
exit;

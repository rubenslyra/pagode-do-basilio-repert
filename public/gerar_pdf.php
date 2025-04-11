<?php
require_once 'auth.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/db.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Configurações Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('chroot', realpath(__DIR__));
$dompdf = new Dompdf($options);

// Caminho da logo (de preferência numa URL acessível publicamente)
$logo = '<img src="./pagodedobasilio.png" style="height:80px;"><br><br>';

// Cabeçalho HTML
$html = $logo;
$html .= '<h2>Repertório - Pagode do Basílio</h2>';


// MÚSICAS AGRUPADAS POR BLOCO
$musicas = $pdo->query("SELECT * FROM cancoes WHERE bloco IS NOT NULL AND bloco != '' ORDER BY bloco, ordem ASC")->fetchAll();
$bloco_atual = '';

foreach ($musicas as $m) {
    if ($m['bloco'] !== $bloco_atual) {
        if ($bloco_atual !== '') $html .= '</tbody></table><br>';
        $bloco_atual = $m['bloco'];

        $nomeBloco = mb_convert_encoding($bloco_atual, 'UTF-8', 'auto');
        $html .= "<h3> Bloco " . htmlspecialchars($nomeBloco) . "</h3>";

        $html .= '<table border="1" cellspacing="0" cellpadding="5" width="100%">
                    <thead>
                        <tr>                            
                            <th>Título</th>
                            <th>Intérprete</th>
                            <th>Tom</th>
                            <th>Gênero / BPM</th>
                        </tr>
                    </thead>
                    <tbody>';
    }

    $html .= '<tr>
        <td>' . htmlspecialchars($m['titulo'] ?? '') . '</td>
        <td>' . htmlspecialchars($m['interprete'] ?? '') . '</td>
        <td>' . htmlspecialchars($m['tom'] ?? '') . '</td>
        <td>' . htmlspecialchars($m['genero_bpm'] ?? '') . '</td>
    </tr>';
}

if ($bloco_atual !== '') {
    $html .= '</tbody></table>';
}


// MÚSICOS DO DIA (última data registrada no banco)
$musicos = $pdo->query("
    SELECT nome, instrumento 
    FROM musicos 
    WHERE dia = (SELECT MAX(dia) FROM musicos)
")->fetchAll();

if ($musicos) {
    $html .= '<strong>Músicos do Dia:</strong><ul>';
    foreach ($musicos as $m) {
        $nome = htmlspecialchars($m['nome'] ?? '');
        $inst = htmlspecialchars($m['instrumento'] ?? '');
        $html .= "<li>{$nome}" . ($inst ? " - {$inst}" : "") . "</li>";
    }
    $html .= '</ul><hr>';
} else {
    $html .= '<p><em>Nenhum músico cadastrado.</em></p><hr>';
}

// Finaliza HTML com estilos
$html = "<html><head><style>
  body { font-family: Arial, sans-serif; font-size: 12px; }
  h3 { margin-top: 20px; }
  table { border-collapse: collapse; margin-bottom: 20px; width: 100%; }
  th, td { border: 1px solid #000; padding: 6px; text-align: left; }
  ul { margin: 0 0 15px 0; padding-left: 20px; }
</style></head><body>$html</body></html>";

// Geração e exibição do PDF
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("repertorio_pagodedobasilio.pdf", ["Attachment" => false]);
exit;

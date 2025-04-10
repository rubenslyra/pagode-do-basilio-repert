<?php
require_once '../config/db.php';

if (isset($_POST['ordem']) && isset($_POST['bloco'])) {
    $ordem = json_decode($_POST['ordem'], true);
    $bloco = $_POST['bloco'];

    foreach ($ordem as $i => $id) {
        $stmt = $pdo->prepare("UPDATE cancoes SET ordem = ?, bloco = ? WHERE id = ?");
        $stmt->execute([$i + 1, $bloco, $id]);
    }
    echo json_encode(['status' => 'ok']);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Dados inválidos']);
}
?>
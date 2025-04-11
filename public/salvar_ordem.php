<?php
require_once 'auth.php';
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bloco = $_POST['bloco'] ?? null;
    $ordem = json_decode($_POST['ordem'] ?? '[]', true);

    if (is_array($ordem)) {
        foreach ($ordem as $index => $id) {
            $stmt = $pdo->prepare("UPDATE cancoes SET bloco = ?, ordem = ? WHERE id = ?");
            $stmt->execute([$bloco, $index, $id]);
        }
        echo json_encode(["status" => "ok"]);
    } else {
        http_response_code(400);
        echo json_encode(["status" => "erro", "mensagem" => "Ordem inválida"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["status" => "erro", "mensagem" => "Método não permitido"]);
}

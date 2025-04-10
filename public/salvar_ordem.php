<?php
require_once '../config/db.php';
$data = json_decode(file_get_contents("php://input"), true);

if (!empty($_POST['ordem']) && !empty($_POST['bloco'])) {
    $ordens = json_decode($_POST['ordem']);
    foreach ($ordens as $i => $id) {
        $stmt = $pdo->prepare("UPDATE cancoes SET ordem=?, bloco=? WHERE id=?");
        $stmt->execute([$i + 1, $_POST['bloco'], $id]);
    }
}

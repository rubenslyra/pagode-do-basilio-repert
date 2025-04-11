<?php
require_once 'auth.php';
require_once '../config/db.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM cancoes WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: index.php?msg=del_ok");
exit;

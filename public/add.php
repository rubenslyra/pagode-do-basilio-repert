<?php
require_once '../config/db.php';

$sucesso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = mb_strtoupper(trim($_POST['titulo']), 'UTF-8');
    $trecho = trim($_POST['trecho']);
    $interprete = mb_strtoupper(trim($_POST['interprete']), 'UTF-8');
    $genero_bpm = strtoupper(trim($_POST['genero_bpm']));
    $link = trim($_POST['link_referencia']);

    $stmt = $pdo->prepare("INSERT INTO cancoes (titulo, trecho, interprete, genero_bpm, link_referencia) VALUES (?, ?, ?, ?, ?)");
    $sucesso = $stmt->execute([$titulo, $trecho, $interprete, $genero_bpm, $link]);

    if ($sucesso) {
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Nova Canção</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="mb-4">🎵 Adicionar Nova Canção</h2>

  <?php if (!$sucesso && $_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <div class="alert alert-danger">Erro ao cadastrar. Tente novamente.</div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <label class="form-label">Título</label>
      <input type="text" name="titulo" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Trecho</label>
      <textarea name="trecho" class="form-control" rows="2"></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Intérprete</label>
      <input type="text" name="interprete" class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">Gênero / BPM</label>
      <input type="text" name="genero_bpm" class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">Link de Referência</label>
      <input type="url" name="link_referencia" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">💾 Salvar</button>
    <a href="index.php" class="btn btn-secondary">← Voltar</a>
  </form>
</div>
</body>
</html>

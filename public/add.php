<?php
require_once 'auth.php';
require_once '../config/db.php';

$sucesso = false;
$erro = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bloco = mb_strtoupper(trim($_POST['bloco']), 'UTF-8');
    $titulo = mb_strtoupper(trim($_POST['titulo']), 'UTF-8');
    $trecho = trim($_POST['trecho']);
    $interprete = mb_strtoupper(trim($_POST['interprete']), 'UTF-8');
    $tom = mb_strtoupper(trim($_POST['tom']), 'UTF-8');
    $genero_bpm = strtoupper(trim($_POST['genero_bpm']));
    $link = trim($_POST['link_referencia']);

    try {
        $stmt = $pdo->prepare("INSERT INTO cancoes (titulo, trecho, interprete, tom, genero_bpm, link_referencia) VALUES (?, ?, ?, ?, ?, ?)");
        $sucesso = $stmt->execute([$titulo, $trecho, $interprete, $tom, $genero_bpm, $link]);
    } catch (PDOException $e) {
        $erro = true;
    }

    if ($sucesso) {
        header('Location: index.php?msg=add_ok');
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

  <?php if ($erro): ?>
    <div class="alert alert-danger">❌ Erro ao cadastrar. Verifique os dados e tente novamente.</div>
  <?php endif; ?>

  <form method="post">
    <!-- bloco -->
    <div class="mb-3">
     <label class="form-label">Bloco</label>
     <input type="text" name="bloco" class="form-control">
    </form>

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
      <label class="form-label">Tom</label>
      <input type="text" name="tom" class="form-control" placeholder="Ex: Dm, C, F...">
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

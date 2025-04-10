<?php require_once '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "INSERT INTO cancoes (titulo, trecho, interprete, genero_bpm, link_referencia)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['titulo'],
        $_POST['trecho'],
        $_POST['interprete'],
        $_POST['genero_bpm'],
        $_POST['link_referencia']
    ]);
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Adicionar Canção</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <h2>➕ Nova Canção</h2>
  <form method="POST" class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Título</label>
      <input type="text" name="titulo" required class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Intérprete</label>
      <input type="text" name="interprete" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Gênero / BPM</label>
      <input type="text" name="genero_bpm" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Link de Referência</label>
      <input type="url" name="link_referencia" class="form-control">
    </div>
    <div class="col-12">
      <label class="form-label">Trecho da Música</label>
      <textarea name="trecho" rows="3" class="form-control"></textarea>
    </div>
    <div class="col-12">
      <button class="btn btn-primary">Salvar</button>
      <a href="index.php" class="btn btn-secondary">Voltar</a>
    </div>
  </form>
</div>
</body>
</html>

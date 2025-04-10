<?php
require_once '../config/db.php';

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: index.php"); exit; }

$stmt = $pdo->prepare("SELECT * FROM cancoes WHERE id = ?");
$stmt->execute([$id]);
$musica = $stmt->fetch();

if (!$musica) { echo "Canção não encontrada."; exit; }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "UPDATE cancoes SET titulo=?, trecho=?, interprete=?, genero_bpm=?, link_referencia=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['titulo'],
        $_POST['trecho'],
        $_POST['interprete'],
        $_POST['genero_bpm'],
        $_POST['link_referencia'],
        $id
    ]);
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Editar Canção</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <h2>✏️ Editar Canção</h2>
  <form method="POST" class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Título</label>
      <input type="text" name="titulo" value="<?= $musica['titulo'] ?>" required class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Intérprete</label>
      <input type="text" name="interprete" value="<?= $musica['interprete'] ?>" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Gênero / BPM</label>
      <input type="text" name="genero_bpm" value="<?= $musica['genero_bpm'] ?>" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Link de Referência</label>
      <input type="url" name="link_referencia" value="<?= $musica['link_referencia'] ?>" class="form-control">
    </div>
    <div class="col-12">
      <label class="form-label">Trecho</label>
      <textarea name="trecho" rows="3" class="form-control"><?= $musica['trecho'] ?></textarea>
    </div>
    <div class="col-12">
      <button class="btn btn-primary">Atualizar</button>
      <a href="index.php" class="btn btn-secondary">Voltar</a>
    </div>
  </form>
</div>
</body>
</html>

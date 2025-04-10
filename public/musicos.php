<?php
require_once '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $pdo->prepare("INSERT INTO musicos (nome, instrumento, dia) VALUES (?, ?, ?)");
    $stmt->execute([
        $_POST['nome'],
        $_POST['instrumento'],
        $_POST['dia']
    ]);
}

$lista = $pdo->query("SELECT * FROM musicos ORDER BY dia DESC")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Músicos do Dia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
  <h2>👤 Músicos do Dia</h2>
  <form method="POST" class="row g-3 mb-4">
    <div class="col-md-4">
      <input type="text" name="nome" class="form-control" placeholder="Nome" required>
    </div>
    <div class="col-md-4">
      <input type="text" name="instrumento" class="form-control" placeholder="Instrumento">
    </div>
    <div class="col-md-4">
      <input type="date" name="dia" class="form-control" required>
    </div>
    <div class="col-12">
      <button class="btn btn-success">Salvar</button>
    </div>
  </form>
  <table class="table table-bordered table-hover">
    <thead>
      <tr><th>Nome</th><th>Instrumento</th><th>Dia</th></tr>
    </thead>
    <tbody>
      <?php foreach ($lista as $m): ?>
        <tr>
          <td><?= $m['nome'] ?></td>
          <td><?= $m['instrumento'] ?></td>
          <td><?= date("d/m/Y", strtotime($m['dia'])) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body>
</html>

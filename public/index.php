<?php
require_once '../config/db.php';
$stmt = $pdo->query("SELECT * FROM cancoes ORDER BY titulo ASC");
$musicas = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Repertório - Pagode do Basílio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

</head>
<body class="bg-light">
<div class="container py-4">
  <h2 class="mb-4">🎶 Repertório do Pagode do Basílio</h2>
  <a href="add.php" class="btn btn-success mb-3">+ Adicionar Canção</a>
  <table class="table table-bordered table-hover bg-white">
    <thead class="table-dark">
      <tr>
        <th>Título</th>
        <th>Trecho</th>
        <th>Intérprete</th>
        <th>Gênero / BPM</th>
        <th>Link</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($musicas as $musica): ?>
        <tr>
          <td><?= htmlspecialchars($musica['titulo']) ?></td>
          <td>
            <span 
              tabindex="0"
              data-bs-toggle="tooltip"
              data-bs-trigger="hover focus"
              title="<?= htmlspecialchars($musica['trecho']) ?>">
              📝 Trecho
            </span>
          </td>
          <td><?= htmlspecialchars($musica['interprete']) ?></td>
          <td><?= htmlspecialchars($musica['genero_bpm']) ?></td>
          <td>
            <?php if ($musica['link_referencia']): ?>
              <a href="<?= htmlspecialchars($musica['link_referencia']) ?>" target="_blank">
                🔗
              </a>
            <?php endif; ?>
          </td>
          <td>
            <a href="edit.php?id=<?= $musica['id'] ?>" class="btn btn-warning btn-sm">✏️</a>
            <a href="delete.php?id=<?= $musica['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">🗑️</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script>
  $(function () {
    $('[data-bs-toggle="tooltip"]').tooltip();
  });

  document.querySelectorAll('.sortable').forEach(el => {
  Sortable.create(el, {
    animation: 150,
    onEnd: function (evt) {
      const bloco = evt.to.getAttribute("data-bloco");
      const ordem = [...evt.to.children].map(el => el.dataset.id);
      $.post("salvar_ordem.php", { bloco, ordem: JSON.stringify(ordem) });
    }
  });
});
</script>
</body>
</html>

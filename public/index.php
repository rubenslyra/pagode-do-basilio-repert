<?php
require_once 'auth.php';
require_once '../config/db.php';

// Todas as músicas (para tabela principal)
$musicas = $pdo->query("SELECT * FROM cancoes ORDER BY titulo ASC")->fetchAll();

// Blocos distintos com músicas
$blocos = $pdo->query("SELECT DISTINCT bloco FROM cancoes WHERE bloco IS NOT NULL AND bloco != '' ORDER BY bloco ASC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="/assets/favicon.ico" type="image/x-icon">
  <title>Repertório - Pagode do Basílio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
</head>
<body class="bg-light">
<div class="container-fluid">
  <div class="row">

    <!-- Sidebar esquerda com blocos -->
    <div class="col-md-3 bg-white border-end vh-100 p-3 overflow-auto">
      <h5>📦 Organização dos Blocos</h5>

      <!-- Sem bloco -->
      <div class="mb-4">
        <strong>🎶 Sem Bloco</strong>
        <ul class="list-group sortable" data-bloco="">
          <?php
          $stmt = $pdo->query("SELECT * FROM cancoes WHERE bloco IS NULL OR bloco = '' ORDER BY titulo ASC");
          foreach ($stmt as $m): ?>
            <li class="list-group-item py-2 px-3" data-id="<?= $m['id'] ?>">
              <?= htmlspecialchars($m['titulo']) ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <!-- Blocos existentes -->
      <?php foreach ($blocos as $b): ?>
        <div class="mb-4">
          <strong>🔐 <?= htmlspecialchars($b['bloco']) ?></strong>
          <ul class="list-group sortable" data-bloco="<?= htmlspecialchars($b['bloco']) ?>">
            <?php
            $stmt = $pdo->prepare("SELECT * FROM cancoes WHERE bloco = ? ORDER BY ordem ASC");
            $stmt->execute([$b['bloco']]);
            foreach ($stmt as $m): ?>
              <li class="list-group-item py-2 px-3" data-id="<?= $m['id'] ?>">
                <?= htmlspecialchars($m['titulo']) ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Conteúdo principal à direita -->
    <div class="col-md-9 p-4">
      <h2 class="mb-4">🎶 Repertório do Pagode do Basílio</h2>
      <a href="add.php" class="btn btn-success mb-3">+ Adicionar Canção</a>
      <a href="gerar_pdf.php" class="btn btn-outline-primary mb-3">🖨️ Imprimir Repertório (PDF)</a>

      <table class="table table-bordered table-hover bg-white">
        <thead class="table-dark">
          <tr>
            <th>Título</th>
            <th>Trecho</th>
            <th>Intérprete</th>
            <th>Tom</th>
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
              <td><?= htmlspecialchars($musica['tom']) ?></td>
              <td><?= htmlspecialchars($musica['genero_bpm']) ?></td>
              <td>
                <?php if (!empty($musica['link_referencia'])): ?>
                  <a href="<?= htmlspecialchars($musica['link_referencia']) ?>" target="_blank">🔗</a>
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

  </div>
</div>

<script>
  // Ativa tooltips Bootstrap
  $(function () {
    $('[data-bs-toggle="tooltip"]').tooltip();
  });

  // Ativa drag and drop com Sortable.js em todas as listas
  document.querySelectorAll('.sortable').forEach(function (el) {
    Sortable.create(el, {
      group: 'blocos',
      animation: 150,
      onEnd: function (evt) {
        const bloco = evt.to.getAttribute('data-bloco');
        const ordem = Array.from(evt.to.children).map(el => el.getAttribute('data-id'));

        $.post('salvar_ordem.php', {
          bloco: bloco,
          ordem: JSON.stringify(ordem)
        }, function (res) {
          console.log('Ordem salva', res);
        });
      }
    });
  });
</script>
</body>
</html>

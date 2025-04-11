<?php
require_once '../config/db.php';

$mensagem = '';
$criarUsuario = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmado'])) {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $email, $senha]);
        $mensagem = "Usuário criado com sucesso!";
    } catch (PDOException $e) {
        $mensagem = "Erro ao criar usuário: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Criar Usuário Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
  <div class="card shadow p-4" style="width: 100%; max-width: 500px;">
    <h4 class="mb-3 text-center">🔐 Criar Usuário Admin</h4>

    <?php if ($mensagem): ?>
      <div class="alert alert-info"><?= $mensagem ?></div>
    <?php endif; ?>

    <form id="formCriar" method="post">
      <div class="mb-3">
        <label class="form-label">Nome</label>
        <input type="text" name="nome" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Senha</label>
        <input type="password" name="senha" class="form-control" required>
      </div>
      <input type="hidden" name="confirmado" value="1">
      <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#confirmModal">Criar Usuário</button>
    </form>
  </div>

  <!-- Modal de confirmação -->
  <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmModalLabel">Confirmar criação</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          Tem certeza que deseja criar este usuário?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" onclick="document.getElementById('formCriar').submit();">Confirmar</button>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

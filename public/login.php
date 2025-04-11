<?php
session_start();
require_once '../config/db.php';

$erro = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        header('Location: index.php');
        exit;
    } else {
        $erro = true;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login - Pagode do Basílio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
  <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
    <h4 class="mb-3 text-center">🎶 Login - Pagode do Basílio</h4>
    <?php if ($erro): ?>
      <div class="alert alert-danger">E-mail ou senha incorretos.</div>
    <?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control" required autofocus>
      </div>
      <div class="mb-3">
        <label class="form-label">Senha</label>
        <input type="password" name="senha" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Entrar</button>
    </form>
  </div>
</body>
</html>

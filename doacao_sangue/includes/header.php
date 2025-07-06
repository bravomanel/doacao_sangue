<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSS – Clínica de Sangue Solidária</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/custom.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-danger shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><i class="bi bi-heart-pulse-fill"></i>CSS – Clínica de Sangue Solidária</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cadastrar_doador.php">Seja um Doador</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="quem_somos.php">Quem Somos</a>
        </li>

        <?php if (isset($_SESSION['admin_id'])): ?>
            <!-- Bloco que só aparece se o administrador estiver logado -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle fw-bold" href="#" id="navbarAdminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Administração
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarAdminDropdown">
                    <li><a class="dropdown-item" href="painel_adm.php">Painel</a></li>
                    <li><a class="dropdown-item" href="gerenciar_doadores.php">Gerenciar Doadores</a></li>
                    <li><a class="dropdown-item" href="gerenciar_locais.php">Gerenciar Locais</a></li>
                </ul>
            </li>
        <?php endif; ?>

      </ul>
      <div class="d-flex">
          <?php if (isset($_SESSION['admin_id'])): ?>
              <span class="navbar-text me-3">
                  Olá, <?php echo htmlspecialchars($_SESSION['admin_usuario']); ?>!
              </span>
              <a href="logout.php" class="btn btn-outline-light">Sair <i class="bi bi-box-arrow-right"></i></a>
          <?php else: ?>
              <a href="login.php" class="btn btn-light">Login <i class="bi bi-box-arrow-in-right"></i></a>
          <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<main class="container mt-4">
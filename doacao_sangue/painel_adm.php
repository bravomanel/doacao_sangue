<?php
$tipo_usuario = 'admin';
include 'includes/verifica_login.php';
include 'includes/header.php';
?>

<div class="p-5 mb-4 bg-light rounded-3 text-center">
    <div class="container-fluid py-5">
        <h1 class="display-4 fw-bold">Painel do Administrador 🩸</h1>
        <p class="fs-4">Bem-vindo, <?php echo htmlspecialchars($_SESSION['admin_usuario']); ?>! Gerencie doadores, estoques e campanhas de doação.</p>
        <a href="cadastrar_doador.php" class="btn btn-danger btn-lg mt-3" role="button">Cadastrar Novo Doador</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card text-center h-100 shadow">
            <div class="card-body">
                <i class="bi bi-people-fill fs-1 text-danger"></i>
                <h5 class="card-title mt-3">Gerenciar Doadores</h5>
                <p class="card-text">Visualize, cadastre e atualize informações dos doadores cadastrados em nossa clínica.</p>
                <a href="gerenciar_doadores.php" class="btn btn-outline-danger mt-2">Acessar</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center h-100 shadow">
            <div class="card-body">
                <i class="bi bi-droplet-fill fs-1 text-danger"></i>
                <h5 class="card-title mt-3">Controle de Estoque</h5>
                <p class="card-text">Monitore os estoques de sangue disponíveis por tipo sanguíneo e gerencie as entradas e saídas.</p>
                <a href="estoque_sangue.php" class="btn btn-outline-danger mt-2">Acessar</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center h-100 shadow">
            <div class="card-body">
                <i class="bi bi-calendar-event-fill fs-1 text-danger"></i>
                <h5 class="card-title mt-3">Campanhas</h5>
                <p class="card-text">Crie e gerencie campanhas de doação de sangue para incentivar a participação da comunidade.</p>
                <a href="campanhas.php" class="btn btn-outline-danger mt-2">Acessar</a>
            </div>
        </div>
    </div>
</div>

<div class="text-center mt-5">
    <a href="logout.php" class="btn btn-secondary">Sair do Painel</a>
</div>

<?php include 'includes/footer.php'; ?>

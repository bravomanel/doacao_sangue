<?php
include 'includes/header.php';
include 'includes/verifica_login.php';

// Verifica se adm está logado
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../logout.php");
    exit();
}

?>

<div class="p-5 mb-4 bg-light rounded-3 text-center">
    <div class="container-fluid py-5">
        <h1 class="display-4 fw-bold">Painel do Administrador 🩸</h1>
        <p class="fs-4">Bem-vindo, <?php echo htmlspecialchars($_SESSION['admin_usuario']); ?>! Utilize este painel para gerenciar doadores, locais de doação e o controle de doações.</p>
    </div>
</div>

<div class="row g-4">
    <!-- Gerenciar Doadores -->
    <div class="col-md-4">
        <div class="card text-center h-100 shadow">
            <div class="card-body">
                <i class="bi bi-people-fill fs-1 text-danger"></i>
                <h5 class="card-title mt-3">Gerenciar Doadores</h5>
                <p class="card-text">Visualize, cadastre, edite ou exclua registros de doadores de forma rápida e eficiente.</p>
                <a href="gerenciar_doadores.php" class="btn btn-outline-danger mt-2">Acessar</a>
            </div>
        </div>
    </div>

    <!-- Controle de Doações -->
    <div class="col-md-4">
        <div class="card text-center h-100 shadow">
            <div class="card-body">
                <i class="bi bi-droplet-half fs-1 text-danger"></i>
                <h5 class="card-title mt-3">Controle de Doações</h5>
                <p class="card-text">Gerencie o histórico de doações de cada doador e registre novas doações realizadas na clínica.</p>
                <a href="controle_doacoes.php" class="btn btn-outline-danger mt-2">Acessar</a>
            </div>
        </div>
    </div>

    <!-- Gerenciar Locais de Doação -->
    <div class="col-md-4">
        <div class="card text-center h-100 shadow">
            <div class="card-body">
                <i class="bi bi-geo-alt-fill fs-1 text-danger"></i>
                <h5 class="card-title mt-3">Locais de Doação</h5>
                <p class="card-text">Cadastre, edite ou remova locais de coleta de doações disponíveis para os doadores.</p>
                <a href="gerenciar_locais.php" class="btn btn-outline-danger mt-2">Acessar</a>
            </div>
        </div>
    </div>
</div>

<div class="text-center mt-5">
    <a href="logout.php" class="btn btn-secondary">Sair do Painel</a>
</div>

<?php include 'includes/footer.php'; ?>

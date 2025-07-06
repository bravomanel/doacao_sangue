<?php 
include 'includes/header.php'; 
if (isset($_SESSION['admin_id'])) {
    header("Location: painel_admin.php");
    exit();
}
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow-lg">
            <div class="card-body p-5">
                <h2 class="card-title text-center mb-4">Login</h2>
                <p class="card-text text-center mb-4">Por favor, insira seu usuário de administrador, ou CPF caso seja um doador.</p>
                
                <?php if (isset($_GET['mensagem']) && isset($_GET['tipo'])): ?>
                    <div class="container mt-3">
                        <div class="alert alert-<?php echo htmlspecialchars($_GET['tipo']); ?> text-center">
                            <?php echo htmlspecialchars($_GET['mensagem']); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <form action="backend/processa_login.php" method="POST">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuário</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                    </div>
                    <div class="d-grid">
                         <button type="submit" class="btn btn-danger btn-block">Entrar</button>
                    </div>
                </form>
            </

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
                
                <?php
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == '1') {
                        echo '<div class="alert alert-danger text-center">Usuário inválido.</div>';
                    } elseif (
                        $_GET['error'] == 'acesso_negado' || 
                        $_GET['error'] == 'acesso_negado_admin' || 
                        $_GET['error'] == 'acesso_negado_doador'
                    ) {
                        echo '<div class="alert alert-warning text-center">Acesso negado. Faça login novamente.</div>';
                    }
                }
                ?>

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

<?php
$mensagem = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    require 'includes/conexao.php';

    $usuario = $_POST['usuario'];

    if (empty($usuario)) {
        $mensagem = '<div class="alert alert-danger">Usuário é obrigatório.</div>';
    } else {

        $sql = "INSERT INTO administradores (usuario) VALUES (?)";
        $stmt = mysqli_prepare($conexao, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $usuario);
            
            if (mysqli_stmt_execute($stmt)) {
                $mensagem = '<div class="alert alert-success">Administrador cadastrado com sucesso!</div>';
            } else {
                $mensagem = '<div class="alert alert-danger">Erro ao cadastrar: ' . mysqli_error($conexao) . '</div>';
            }
            mysqli_stmt_close($stmt);
        } else {
            $mensagem = '<div class="alert alert-danger">Erro na preparação da query.</div>';
        }
        mysqli_close($conexao);
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>Cadastro de Novo Administrador</h3>
            </div>
            <div class="card-body">
                <p>Cadastro SUPER SECRETO de um novo administrador.</p>
                
                <?php echo $mensagem; ?>

                <form action="cadastrar_administrador.php" method="POST">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Nome de Usuário</label>
                        <input type="text" class="form-control" name="usuario" id="usuario" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Cadastrar Admin</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
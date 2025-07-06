<?php
include 'includes/header.php';
include 'includes/verifica_login.php';
require 'includes/conexao.php';

// Verifica se adm está logado
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../logout.php");
    exit();
}

// Se for edição
$local = null;
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Validação adicional para garantir que é um inteiro
    if (!filter_var($id, FILTER_VALIDATE_INT)) {
        header("Location: gerenciar_locais.php?mensagem=" . urlencode("ID inválido.") . "&tipo=danger");
        exit();
    }

    $sql = "SELECT * FROM locais_doacao WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result && mysqli_num_rows($result) > 0) {
            $local = mysqli_fetch_assoc($result);
        } else {
            header("Location: gerenciar_locais.php?mensagem=" . urlencode("Local não encontrado.") . "&tipo=warning");
            exit();
        }
        mysqli_stmt_close($stmt);
    } else {
        header("Location: gerenciar_locais.php?mensagem=" . urlencode("Erro ao preparar consulta.") . "&tipo=danger");
        exit();
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h3 class="mb-0"><?php echo $local ? "Editar Local de Doação" : "Cadastrar Novo Local de Doação"; ?></h3>
            </div>
            <div class="card-body">
                <p class="card-text">Preencha os campos abaixo para <?php echo $local ? "atualizar o local" : "cadastrar um novo local de doação"; ?>.</p>

                <form action="backend/processa_local.php" method="POST">
                    <?php if ($local): ?>
                        <input type="hidden" name="id" value="<?php echo $local['id']; ?>">
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="nome_local" class="form-label">Nome do Local</label>
                        <input type="text" class="form-control" id="nome_local" name="nome_local" required value="<?php echo $local ? htmlspecialchars($local['nome_local']) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="cep" class="form-label">CEP</label>
                        <input type="text" class="form-control" id="cep" name="cep" placeholder="00000-000" required value="<?php echo $local ? htmlspecialchars($local['cep']) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="endereco" class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="endereco" name="endereco" required value="<?php echo $local ? htmlspecialchars($local['endereco']) : ''; ?>">
                    </div>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" required value="<?php echo $local ? htmlspecialchars($local['cidade']) : ''; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="estado" class="form-label">Estado (UF)</label>
                            <input type="text" class="form-control" id="estado" name="estado" maxlength="2" required value="<?php echo $local ? htmlspecialchars($local['estado']) : ''; ?>">
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-danger btn-lg"><?php echo $local ? "Atualizar Local" : "Cadastrar Local"; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

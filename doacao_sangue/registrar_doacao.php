<?php
include 'includes/header.php';
include 'includes/verifica_login.php';
require 'includes/conexao.php';

// Buscar locais de doação
$locais_result = mysqli_query($conexao, "SELECT id, nome_local FROM locais_doacao ORDER BY nome_local");

// Buscar doadores (se admin)
if ($tipo_usuario === 'admin') {
    $doadores_result = mysqli_query($conexao, "SELECT id, nome_completo FROM doadores ORDER BY nome_completo");
}

// Verificar se está em modo de edição
$modo_edicao = false;
if (isset($_GET['id']) && $tipo_usuario === 'admin') {
    $modo_edicao = true;
    $id_editar = intval($_GET['id']);
    $sql = "SELECT * FROM doacoes WHERE id = $id_editar";
    $result = mysqli_query($conexao, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $doacao = mysqli_fetch_assoc($result);
    } else {
        echo "<div class='alert alert-danger text-center'>Doação não encontrada para edição.</div>";
        include 'includes/footer.php';
        exit();
    }
}
?>

<div class="p-5 mb-4 bg-light rounded-3 text-center">
    <div class="container-fluid py-5">
        <h1 class="display-4 fw-bold">
            <?php echo $modo_edicao ? 'Editar Doação 🩸' : 'Registrar Nova Doação 🩸'; ?>
        </h1>
        <p class="fs-4">
            <?php echo $modo_edicao ? 'Atualize as informações da doação selecionada abaixo.' : 'Preencha os dados abaixo para registrar uma nova doação de sangue no sistema.'; ?>
        </p>
    </div>
</div>

<div class="container mb-5">
    <form action="backend/processa_doacao.php" method="POST" class="card p-4 shadow-lg mx-auto" style="max-width: 600px;">
        <?php if ($modo_edicao): ?>
            <input type="hidden" name="id" value="<?php echo $doacao['id']; ?>">
        <?php endif; ?>

        <?php if ($tipo_usuario === 'admin'): ?>
            <?php
            // Recarregar o result para evitar ponteiro no final caso tenha sido usado acima
            $doadores_result = mysqli_query($conexao, "SELECT id, nome_completo FROM doadores ORDER BY nome_completo");
            ?>
            <div class="mb-3">
                <label for="doador_id" class="form-label">Selecione o Doador</label>
                <select class="form-select" id="doador_id" name="doador_id" required>
                    <option value="">Selecione</option>
                    <?php while ($doador = mysqli_fetch_assoc($doadores_result)): ?>
                        <option value="<?php echo $doador['id']; ?>" <?php echo ($modo_edicao && $doacao['doador_id'] == $doador['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($doador['nome_completo']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        <?php endif; ?>

        <?php
        // Recarregar locais caso tenha sido usado antes
        $locais_result = mysqli_query($conexao, "SELECT id, nome_local FROM locais_doacao ORDER BY nome_local");
        ?>
        <div class="mb-3">
            <label for="local_id" class="form-label">Local de Doação</label>
            <select class="form-select" id="local_id" name="local_id" required>
                <option value="">Selecione</option>
                <?php while ($local = mysqli_fetch_assoc($locais_result)): ?>
                    <option value="<?php echo $local['id']; ?>" <?php echo ($modo_edicao && $doacao['local_id'] == $local['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($local['nome_local']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="data_doacao" class="form-label">Data da Doação</label>
            <input type="date" class="form-control" id="data_doacao" name="data_doacao"
                   value="<?php echo $modo_edicao ? $doacao['data_doacao'] : ''; ?>" required>
        </div>

        <div class="mb-3">
            <label for="volume_ml" class="form-label">Volume (ml)</label>
            <input type="number" class="form-control" id="volume_ml" name="volume_ml"
                   value="<?php echo $modo_edicao ? $doacao['volume_ml'] : '450'; ?>" required>
        </div>

        <div class="mb-3">
            <label for="observacoes" class="form-label">Observações (opcional)</label>
            <textarea class="form-control" id="observacoes" name="observacoes" rows="3"><?php echo $modo_edicao ? htmlspecialchars($doacao['observacoes']) : ''; ?></textarea>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-<?php echo $modo_edicao ? 'warning' : 'danger'; ?> btn-lg">
                <?php echo $modo_edicao ? 'Atualizar Doação' : 'Registrar Doação'; ?>
            </button>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>

<?php
include 'includes/header.php';
include 'includes/verifica_login.php';
require 'includes/conexao.php';

// Verifica se está logado (admin ou doador)
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['doador_id'])) {
    header("Location: ../logout.php");
    exit();
}

$tipo_usuario = isset($_SESSION['admin_id']) ? 'admin' : 'doador';

// Buscar locais de doação
$locais_result = mysqli_query($conexao, "SELECT id, nome_local FROM locais_doacao ORDER BY nome_local");

// Buscar doadores (se admin)
if ($tipo_usuario === 'admin') {
    $doadores_result = mysqli_query($conexao, "SELECT id, nome_completo FROM doadores ORDER BY nome_completo");
}

// Verificar se está em modo de edição
$modo_edicao = false;
if (isset($_GET['id'])) {
    $modo_edicao = true;
    $id_editar = intval($_GET['id']);

    // Se for doador, verificar se a doação pertence a ele
    if ($tipo_usuario === 'doador') {
        $doador_id = $_SESSION['doador_id'];

        $check_sql = "SELECT id FROM doacoes WHERE id = ? AND doador_id = ?";
        $stmt = mysqli_prepare($conexao, $check_sql);
        mysqli_stmt_bind_param($stmt, "ii", $id_editar, $doador_id);
        mysqli_stmt_execute($stmt);
        $check_result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($check_result) === 0) {
            header("Location: ../controle_doacoes.php?mensagem=" . urlencode("Você não tem permissão para editar esta doação.") . "&tipo=danger");
            exit();
        }
    }

    // Buscar dados da doação
    $sql = "SELECT * FROM doacoes WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_editar);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

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

        <?php
        if ($tipo_usuario === 'admin') {
            // Recarregar doadores para o select
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
        <?php 
            // Se for edição, carregar dados de triagem do doador
            if ($modo_edicao) {
                $doador_id_triagem = $doacao['doador_id'];
                $sql_triagem = "SELECT pesa_mais_50kg, teve_febre_7dias, fez_tatuagem_12meses FROM doadores WHERE id = $doador_id_triagem";
                $result_triagem = mysqli_query($conexao, $sql_triagem);
                $triagem = mysqli_fetch_assoc($result_triagem);
            } else {
                $triagem = ['pesa_mais_50kg' => '', 'teve_febre_7dias' => '', 'fez_tatuagem_12meses' => ''];
            }
        ?>
        <?php } ?>

        <div class="mb-3">
            <label for="local_id" class="form-label">Local de Doação</label>
            <select class="form-select" id="local_id" name="local_id" required>
                <option value="">Selecione</option>
                <?php
                $locais_result = mysqli_query($conexao, "SELECT id, nome_local FROM locais_doacao ORDER BY nome_local");
                while ($local = mysqli_fetch_assoc($locais_result)): ?>
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

        <h5 class="mt-4">Triagem do Doador</h5>
        <hr>
        <fieldset class="mb-3">
            <legend class="form-label fs-6">1. Pesa mais de 50kg?</legend>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="pesa_mais_50kg" id="peso_sim" value="1" required>
                <label class="form-check-label" for="peso_sim">Sim</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="pesa_mais_50kg" id="peso_nao" value="0">
                <label class="form-check-label" for="peso_nao">Não</label>
            </div>
        </fieldset>

        <fieldset class="mb-3">
            <legend class="form-label fs-6">2. Teve febre nos últimos 7 dias?</legend>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="teve_febre_7dias" id="febre_sim" value="1" required>
                <label class="form-check-label" for="febre_sim">Sim</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="teve_febre_7dias" id="febre_nao" value="0">
                <label class="form-check-label" for="febre_nao">Não</label>
            </div>
        </fieldset>

        <fieldset class="mb-3">
            <legend class="form-label fs-6">3. Fez tatuagem ou piercing nos últimos 12 meses?</legend>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="fez_tatuagem_12meses" id="tatuagem_sim" value="1" required>
                <label class="form-check-label" for="tatuagem_sim">Sim</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="fez_tatuagem_12meses" id="tatuagem_nao" value="0">
                <label class="form-check-label" for="tatuagem_nao">Não</label>
            </div>
        </fieldset>

        <div class="d-grid">
            <button type="submit" class="btn btn-<?php echo $modo_edicao ? 'warning' : 'danger'; ?> btn-lg">
                <?php echo $modo_edicao ? 'Atualizar Doação' : 'Registrar Doação'; ?>
            </button>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>

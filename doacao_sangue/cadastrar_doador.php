<?php 
include 'includes/header.php'; 
require 'includes/conexao.php';

$modo_edicao = false;
$doador = [
    'id' => '',
    'nome_completo' => '',
    'cpf' => '',
    'data_nascimento' => '',
    'cep' => '',
    'tipo_sanguineo' => '',
    'email' => '',
    'pesa_mais_50kg' => '',
    'teve_febre_7dias' => '',
    'fez_tatuagem_12meses' => ''
];

if (isset($_GET['id'])) {
    if (isset($_SESSION['admin_id']) || $_GET['id'] == $_SESSION['doador_id']) {
        $id = $_GET['id'];

        // Valida se é um inteiro
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            echo "<div class='alert alert-danger text-center'>ID inválido.</div>";
        } else {
            $sql = "SELECT * FROM doadores WHERE id = ?";
            $stmt = mysqli_prepare($conexao, $sql);
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                $doador = mysqli_fetch_assoc($result);
                $modo_edicao = true;
            } else {
                echo "<div class='alert alert-danger text-center'>Doador não encontrado.</div>";
            }
        }
    } else {
        header("Location: ../controle_doacoes.php?mensagem=" . urlencode("Você não tem permissão para editar este doador.") . "&tipo=danger");
        exit();
    }
}
?>


<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h3 class="mb-0"><?php echo $modo_edicao ? 'Editar Doador' : 'Formulário de Cadastro de Doador'; ?></h3>
            </div>
            <div class="card-body">
                <p class="card-text">
                    <?php echo $modo_edicao ? 'Altere os dados desejados e salve as alterações.' : 'Preencha os campos abaixo para se juntar à nossa causa. Todos os campos são obrigatórios.'; ?>
                </p>

                <form action="backend/processa_cadastro.php" method="POST">
                    <?php if ($modo_edicao): ?>
                        <input type="hidden" name="id" value="<?php echo $doador['id']; ?>">
                    <?php endif; ?>

                    <h5 class="mt-4">Informações Pessoais</h5>
                    <hr>
                    <div class="mb-3">
                        <label for="nome_completo" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome_completo" name="nome_completo" required value="<?php echo htmlspecialchars($doador['nome_completo']); ?>">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" placeholder="000.000.000-00" required value="<?php echo htmlspecialchars($doador['cpf']); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required value="<?php echo htmlspecialchars($doador['data_nascimento']); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" class="form-control" id="cep" name="cep" placeholder="00000-000" required value="<?php echo htmlspecialchars($doador['cep']); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tipo_sanguineo" class="form-label">Tipo Sanguíneo</label>
                            <select class="form-select" id="tipo_sanguineo" name="tipo_sanguineo" required>
                                <option value="" disabled <?php echo empty($doador['tipo_sanguineo']) ? 'selected' : ''; ?>>Selecione...</option>
                                <?php 
                                $tipos = ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"];
                                foreach ($tipos as $tipo) {
                                    echo "<option value='$tipo' " . ($doador['tipo_sanguineo'] == $tipo ? 'selected' : '') . ">$tipo</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="seuemail@exemplo.com" required value="<?php echo htmlspecialchars($doador['email']); ?>">
                    </div>

                    <h5 class="mt-4">Questionário de Triagem</h5>
                    <hr>
                    <fieldset class="mb-3">
                        <legend class="form-label fs-6">1. Você pesa mais de 50kg?</legend>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pesa_mais_50kg" id="peso_sim" value="1" required <?php echo $doador['pesa_mais_50kg'] == 1 ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="peso_sim">Sim</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pesa_mais_50kg" id="peso_nao" value="0" <?php echo $doador['pesa_mais_50kg'] === 0 ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="peso_nao">Não</label>
                        </div>
                    </fieldset>

                    <fieldset class="mb-3">
                        <legend class="form-label fs-6">2. Teve febre nos últimos 7 dias?</legend>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="teve_febre_7dias" id="febre_sim" value="1" required <?php echo $doador['teve_febre_7dias'] == 1 ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="febre_sim">Sim</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="teve_febre_7dias" id="febre_nao" value="0" <?php echo $doador['teve_febre_7dias'] === 0 ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="febre_nao">Não</label>
                        </div>
                    </fieldset>

                    <fieldset class="mb-3">
                        <legend class="form-label fs-6">3. Fez tatuagem ou piercing nos últimos 12 meses?</legend>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="fez_tatuagem_12meses" id="tatuagem_sim" value="1" required <?php echo $doador['fez_tatuagem_12meses'] == 1 ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="tatuagem_sim">Sim</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="fez_tatuagem_12meses" id="tatuagem_nao" value="0" <?php echo $doador['fez_tatuagem_12meses'] === 0 ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="tatuagem_nao">Não</label>
                        </div>
                    </fieldset>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-danger btn-lg"><?php echo $modo_edicao ? 'Salvar Alterações' : 'Finalizar Cadastro'; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

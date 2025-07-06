<?php
include 'includes/header.php';
include 'includes/verifica_login.php';
require 'includes/conexao.php';

$result = mysqli_query($conexao, "SELECT * FROM doadores ORDER BY nome_completo");
?>

<div class="p-5 mb-4 bg-light rounded-3 text-center">
    <div class="container-fluid py-5">
        <h1 class="display-4 fw-bold">Gerenciar Doadores ❤️</h1>
        <p class="fs-4">Visualize, edite ou remova os doadores cadastrados no sistema.</p>
    </div>
</div>

<?php if (isset($_GET['mensagem']) && isset($_GET['tipo'])): ?>
    <div class="container mt-3">
        <div class="alert alert-<?php echo htmlspecialchars($_GET['tipo']); ?> text-center">
            <?php echo htmlspecialchars($_GET['mensagem']); ?>
        </div>
    </div>
<?php endif; ?>

<div class="container mb-5">
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-danger text-center">
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Tipo Sanguíneo</th>
                    <th>Data de Cadastro</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($doador = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td class="text-center"><?php echo htmlspecialchars($doador['nome_completo']); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($doador['cpf']); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($doador['tipo_sanguineo']); ?></td>
                            <td class="text-center"><?php echo date('d/m/Y', strtotime($doador['data_cadastro'])); ?></td>
                            <td class="text-center">
                                <a href="cadastrar_doador.php?id=<?php echo $doador['id']; ?>" class="btn btn-sm btn-primary me-1" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="backend/remover_doador.php?id=<?php echo $doador['id']; ?>" class="btn btn-sm btn-danger" title="Remover" onclick="return confirm('Tem certeza que deseja remover este doador?');">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Nenhum doador cadastrado até o momento.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

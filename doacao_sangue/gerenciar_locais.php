<?php
include 'includes/header.php';
include 'includes/verifica_login.php';
require 'includes/conexao.php';

$result = mysqli_query($conexao, "SELECT * FROM locais_doacao ORDER BY nome_local");
?>

<div class="p-5 mb-4 bg-light rounded-3 text-center">
    <div class="container-fluid py-5">
        <h1 class="display-4 fw-bold">Gerenciar Locais de Doação 🩸</h1>
        <p class="fs-4">Gerencie os locais de doação cadastrados no sistema.</p>
        <a href="cadastrar_local.php" class="btn btn-danger btn-lg mt-3">Cadastrar Novo Local</a>
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
                    <th>Endereço</th>
                    <th>Cidade/Estado</th>
                    <th>CEP</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($local = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($local['nome_local']); ?></td>
                            <td><?php echo htmlspecialchars($local['endereco']); ?></td>
                            <td><?php echo htmlspecialchars($local['cidade']) . '/' . htmlspecialchars($local['estado']); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($local['cep']); ?></td>
                            <td class="text-center">
                                <a href="cadastrar_local.php?id=<?php echo $local['id']; ?>" class="btn btn-sm btn-primary me-1" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="backend/remover_local.php?id=<?php echo $local['id']; ?>" class="btn btn-sm btn-danger" title="Remover" onclick="return confirm('Tem certeza que deseja remover este local?');">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Nenhum local cadastrado até o momento.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

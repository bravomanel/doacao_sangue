<?php
$tipo_usuario = isset($_SESSION['admin_id']) ? 'admin' : 'doador';
include 'includes/header.php';
include 'includes/verifica_login.php';
require 'includes/conexao.php';

// Busca dados necessários:
try {
    // Buscar doações:
    if ($tipo_usuario === 'admin') {
        $sql = "SELECT d.id, do.nome_completo, l.nome_local, d.data_doacao, d.volume_ml, d.observacoes
                FROM doacoes d
                JOIN doadores do ON d.doador_id = do.id
                JOIN locais_doacao l ON d.local_id = l.id
                ORDER BY d.data_doacao DESC";
        $stmt = mysqli_query($conexao, $sql);
    } else {
        $doador_id = $_SESSION['doador_id'];
        $sql = "SELECT d.id, do.nome_completo, l.nome_local, d.data_doacao, d.volume_ml, d.observacoes
                FROM doacoes d
                JOIN doadores do ON d.doador_id = do.id
                JOIN locais_doacao l ON d.local_id = l.id
                WHERE d.doador_id = $doador_id
                ORDER BY d.data_doacao DESC";
        $stmt = mysqli_query($conexao, $sql);
    }
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Erro ao buscar dados: " . $e->getMessage() . "</div>";
}
?>

<div class="p-5 mb-4 bg-light rounded-3 text-center">
    <div class="container-fluid py-5">
        <h1 class="display-4 fw-bold">Controle de Doações 🩸</h1>
        <?php if ($tipo_usuario === 'admin'): ?>
            <p class="fs-4">Gerencie todas as doações registradas e cadastre novas doações.</p>
        <?php else: ?>
            <p class="fs-4">Visualize o seu histórico de doações e acompanhe sua contribuição para salvar vidas.</p>
        <?php endif; ?>
        <a href="registrar_doacao.php" class="btn btn-danger btn-lg mt-3">Registrar Nova Doação</a>
    </div>
</div>

<div class="container mt-4 mb-5">
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-danger text-center">
                <tr>
                    <th>Nome do Doador</th>
                    <th>Local de Doação</th>
                    <th>Data da Doação</th>
                    <th>Volume (ml)</th>
                    <th>Observações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($stmt) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($stmt)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nome_completo']); ?></td>
                            <td><?php echo htmlspecialchars($row['nome_local']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row['data_doacao'])); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($row['volume_ml']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['observacoes'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Nenhuma doação registrada até o momento.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

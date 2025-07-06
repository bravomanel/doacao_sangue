<?php
require '../includes/conexao.php';

if (isset($_GET['doador_id'])) {
    $id = intval($_GET['doador_id']);
    $stmt = mysqli_prepare($conexao, "SELECT pesa_mais_50kg, teve_febre_7dias, fez_tatuagem_12meses FROM doadores WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result && mysqli_num_rows($result) > 0) {
        $dados = mysqli_fetch_assoc($result);
        echo json_encode($dados);
    } else {
        echo json_encode(['erro' => 'Doador não encontrado']);
    }
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['erro' => 'ID não fornecido']);
}
?>

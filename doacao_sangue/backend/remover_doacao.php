<?php
session_start();
require '../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verificação de permissão do doador
    if (isset($_SESSION['doador_id']) && !isset($_SESSION['admin_id'])) {
        $doador_id = $_SESSION['doador_id'];
        $check_sql = "SELECT id FROM doacoes WHERE id = ? AND doador_id = ?";
        $stmt_check = mysqli_prepare($conexao, $check_sql);
        mysqli_stmt_bind_param($stmt_check, 'ii', $id, $doador_id);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);

        if (mysqli_stmt_num_rows($stmt_check) === 0) {
            header("Location: ../controle_doacoes.php?mensagem=" . urlencode("Você não tem permissão para excluir esta doação.") . "&tipo=danger");
            exit();
        }
    }

    // Exclusão segura
    $sql = "DELETE FROM doacoes WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../controle_doacoes.php?mensagem=" . urlencode("Doação removida com sucesso!") . "&tipo=success");
        exit();
    } else {
        header("Location: ../controle_doacoes.php?mensagem=" . urlencode("Erro ao remover doação: " . mysqli_error($conexao)) . "&tipo=danger");
        exit();
    }
} else {
    header("Location: ../controle_doacoes.php?mensagem=" . urlencode("Requisição inválida.") . "&tipo=danger");
    exit();
}
?>

<?php
session_start();
require '../includes/conexao.php';

// Verifica se admin está logado
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../logout.php");
    exit();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Verificação de ID válido
    if (!filter_var($id, FILTER_VALIDATE_INT)) {
        header("Location: ../gerenciar_doadores.php?mensagem=" . urlencode("ID inválido.") . "&tipo=danger");
        exit();
    }

    // Exclusão segura com prepared statements
    $sql = "DELETE FROM doadores WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../gerenciar_doadores.php?mensagem=" . urlencode("Doador removido com sucesso.") . "&tipo=success");
        exit();
    } else {
        header("Location: ../gerenciar_doadores.php?mensagem=" . urlencode("Erro ao remover doador: " . mysqli_error($conexao)) . "&tipo=danger");
        exit();
    }
} else {
    header("Location: ../gerenciar_doadores.php?mensagem=" . urlencode("ID do doador não informado.") . "&tipo=warning");
    exit();
}
?>

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

    // Validação do ID como inteiro
    if (!filter_var($id, FILTER_VALIDATE_INT)) {
        header("Location: ../gerenciar_locais.php?mensagem=" . urlencode("ID inválido.") . "&tipo=danger");
        exit();
    }

    // Exclusão segura com prepared statement
    $sql = "DELETE FROM locais_doacao WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../gerenciar_locais.php?mensagem=" . urlencode("Local removido com sucesso.") . "&tipo=success");
        exit();
    } else {
        header("Location: ../gerenciar_locais.php?mensagem=" . urlencode("Erro ao remover local: " . mysqli_error($conexao)) . "&tipo=danger");
        exit();
    }
} else {
    header("Location: ../gerenciar_locais.php?mensagem=" . urlencode("ID do local não informado.") . "&tipo=warning");
    exit();
}
?>

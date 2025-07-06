<?php
session_start();
require '../includes/conexao.php';

// Verifica se está logado
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php?error=acesso_negado");
    exit();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($conexao, $_GET['id']);

    $sql = "DELETE FROM doadores WHERE id = '$id'";
    if (mysqli_query($conexao, $sql)) {
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

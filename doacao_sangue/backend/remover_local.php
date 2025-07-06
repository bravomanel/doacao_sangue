<?php
session_start();
require '../includes/conexao.php';

// Verifica se adm está logado
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../logout.php");
    exit();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($conexao, $_GET['id']);

    $sql = "DELETE FROM locais_doacao WHERE id = '$id'";
    if (mysqli_query($conexao, $sql)) {
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

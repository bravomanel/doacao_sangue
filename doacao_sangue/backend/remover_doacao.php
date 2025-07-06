<?php
session_start();
require '../includes/conexao.php';

// Verifica se está logado
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['doador_id'])) {
    header("Location: ../login.php?error=acesso_negado");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conexao, $_GET['id']);

    // Verificação de segurança para doador não remover doação de outro
    if (isset($_SESSION['doador_id']) && !isset($_SESSION['admin_id'])) {
        $doador_id = $_SESSION['doador_id'];
        $check_sql = "SELECT id FROM doacoes WHERE id = '$id' AND doador_id = '$doador_id'";
        $check_result = mysqli_query($conexao, $check_sql);

        if (mysqli_num_rows($check_result) === 0) {
            header("Location: ../controle_doacoes.php?mensagem=" . urlencode("Você não tem permissão para excluir esta doação.") . "&tipo=danger");
            exit();
        }
    }

    $sql = "DELETE FROM doacoes WHERE id = '$id'";
    if (mysqli_query($conexao, $sql)) {
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

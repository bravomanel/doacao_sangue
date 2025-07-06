<?php
session_start();
require '../includes/conexao.php';

// Verifica se adm está logado
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../logout.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_local = $_POST['nome_local'] ?? '';
    $cep = $_POST['cep'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $cidade = $_POST['cidade'] ?? '';
    $estado = strtoupper($_POST['estado'] ?? '');

    if (!empty($nome_local) && !empty($cep) && !empty($endereco) && !empty($cidade) && !empty($estado)) {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            // UPDATE
            $id = $_POST['id'];
            $sql = "UPDATE locais_doacao SET nome_local = ?, cep = ?, endereco = ?, cidade = ?, estado = ? WHERE id = ?";
            $stmt = mysqli_prepare($conexao, $sql);
            mysqli_stmt_bind_param($stmt, 'sssssi', $nome_local, $cep, $endereco, $cidade, $estado, $id);

            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../gerenciar_locais.php?mensagem=" . urlencode("Local atualizado com sucesso!") . "&tipo=success");
                exit();
            } else {
                header("Location: ../gerenciar_locais.php?mensagem=" . urlencode("Erro ao atualizar local.") . "&tipo=danger");
                exit();
            }
        } else {
            // INSERT
            $sql = "INSERT INTO locais_doacao (nome_local, cep, endereco, cidade, estado) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conexao, $sql);
            mysqli_stmt_bind_param($stmt, 'sssss', $nome_local, $cep, $endereco, $cidade, $estado);

            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../gerenciar_locais.php?mensagem=" . urlencode("Local cadastrado com sucesso!") . "&tipo=success");
                exit();
            } else {
                header("Location: ../gerenciar_locais.php?mensagem=" . urlencode("Erro ao cadastrar local.") . "&tipo=danger");
                exit();
            }
        }
    } else {
        header("Location: ../gerenciar_locais.php?mensagem=" . urlencode("Preencha todos os campos obrigatórios.") . "&tipo=warning");
        exit();
    }
} else {
    header("Location: ../gerenciar_locais.php");
    exit();
}
?>

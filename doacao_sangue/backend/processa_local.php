<?php
session_start();
require '../includes/conexao.php';

// Verifica se adm está logado
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php?mensagem=" . urlencode("Faça o login para continuar.") . "&tipo=danger");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_local = mysqli_real_escape_string($conexao, $_POST['nome_local']);
    $cep = mysqli_real_escape_string($conexao, $_POST['cep']);
    $endereco = mysqli_real_escape_string($conexao, $_POST['endereco']);
    $cidade = mysqli_real_escape_string($conexao, $_POST['cidade']);
    $estado = mysqli_real_escape_string($conexao, strtoupper($_POST['estado']));

    if (!empty($nome_local) && !empty($cep) && !empty($endereco) && !empty($cidade) && !empty($estado)) {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $id = mysqli_real_escape_string($conexao, $_POST['id']);
            $sql = "UPDATE locais_doacao SET 
                        nome_local = '$nome_local',
                        cep = '$cep',
                        endereco = '$endereco',
                        cidade = '$cidade',
                        estado = '$estado'
                    WHERE id = '$id'";
            if (mysqli_query($conexao, $sql)) {
                header("Location: ../gerenciar_locais.php?mensagem=" . urlencode("Local atualizado com sucesso!") . "&tipo=success");
                exit();
            } else {
                header("Location: ../gerenciar_locais.php?mensagem=" . urlencode("Erro ao atualizar local: " . mysqli_error($conexao)) . "&tipo=danger");
                exit();
            }
        } else {
            $sql = "INSERT INTO locais_doacao (nome_local, cep, endereco, cidade, estado)
                    VALUES ('$nome_local', '$cep', '$endereco', '$cidade', '$estado')";
            if (mysqli_query($conexao, $sql)) {
                header("Location: ../gerenciar_locais.php?mensagem=" . urlencode("Local cadastrado com sucesso!") . "&tipo=success");
                exit();
            } else {
                header("Location: ../gerenciar_locais.php?mensagem=" . urlencode("Erro ao cadastrar local: " . mysqli_error($conexao)) . "&tipo=danger");
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

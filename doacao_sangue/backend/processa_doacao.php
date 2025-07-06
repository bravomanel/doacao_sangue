<?php
session_start();
require '../includes/conexao.php';

$tipo_usuario = isset($_SESSION['admin_id']) ? 'admin' : 'doador';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $local_id = mysqli_real_escape_string($conexao, $_POST['local_id']);
    $data_doacao = mysqli_real_escape_string($conexao, $_POST['data_doacao']);
    $volume_ml = mysqli_real_escape_string($conexao, $_POST['volume_ml']);
    $observacoes = mysqli_real_escape_string($conexao, $_POST['observacoes']);

    if ($tipo_usuario === 'admin') {
        $doador_id = mysqli_real_escape_string($conexao, $_POST['doador_id']);
    } else {
        $doador_id = $_SESSION['doador_id'];
    }

    if (!empty($local_id) && !empty($data_doacao) && !empty($volume_ml) && !empty($doador_id)) {

        if (isset($_POST['id']) && !empty($_POST['id'])) {
            // MODO EDITAR
            $id = mysqli_real_escape_string($conexao, $_POST['id']);

            $sql = "UPDATE doacoes 
                    SET doador_id = '$doador_id',
                        local_id = '$local_id',
                        data_doacao = '$data_doacao',
                        volume_ml = '$volume_ml',
                        observacoes = '$observacoes'
                    WHERE id = '$id'";

            if (mysqli_query($conexao, $sql)) {
                header("Location: ../controle_doacoes.php?mensagem=" . urlencode("Doação atualizada com sucesso!") . "&tipo=success");
                exit();
            } else {
                header("Location: ../controle_doacoes.php?mensagem=" . urlencode("Erro ao atualizar doação: " . mysqli_error($conexao)) . "&tipo=danger");
                exit();
            }

        } else {
            // MODO INSERIR
            $sql = "INSERT INTO doacoes (doador_id, local_id, data_doacao, volume_ml, observacoes)
                    VALUES ('$doador_id', '$local_id', '$data_doacao', '$volume_ml', '$observacoes')";

            if (mysqli_query($conexao, $sql)) {
                header("Location: ../controle_doacoes.php?mensagem=" . urlencode("Doação registrada com sucesso!") . "&tipo=success");
                exit();
            } else {
                header("Location: ../controle_doacoes.php?mensagem=" . urlencode("Erro ao registrar doação: " . mysqli_error($conexao)) . "&tipo=danger");
                exit();
            }
        }

    } else {
        header("Location: ../controle_doacoes.php?mensagem=" . urlencode("Preencha todos os campos obrigatórios.") . "&tipo=warning");
        exit();
    }
} else {
    header("Location: ../controle_doacoes.php");
    exit();
}
?>

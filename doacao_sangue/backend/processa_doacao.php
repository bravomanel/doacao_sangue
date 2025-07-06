<?php
session_start();
require '../includes/conexao.php';

$tipo_usuario = isset($_SESSION['admin_id']) ? 'admin' : 'doador';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $local_id = $_POST['local_id'] ?? '';
    $data_doacao = $_POST['data_doacao'] ?? '';
    $volume_ml = $_POST['volume_ml'] ?? '';
    $observacoes = $_POST['observacoes'] ?? '';
    $pesa_mais_50kg = $_POST['pesa_mais_50kg'] ?? '';
    $teve_febre_7dias = $_POST['teve_febre_7dias'] ?? '';
    $fez_tatuagem_12meses = $_POST['fez_tatuagem_12meses'] ?? '';

    if ($tipo_usuario === 'admin') {
        $doador_id = $_POST['doador_id'] ?? '';
    } else {
        $doador_id = $_SESSION['doador_id'] ?? '';
    }

    if (!empty($local_id) && !empty($data_doacao) && !empty($volume_ml) && !empty($doador_id)) {
        // Atualiza a triagem de forma segura
        $sql_triagem_update = "UPDATE doadores SET pesa_mais_50kg = ?, teve_febre_7dias = ?, fez_tatuagem_12meses = ? WHERE id = ?";
        $stmt_triagem = mysqli_prepare($conexao, $sql_triagem_update);
        mysqli_stmt_bind_param($stmt_triagem, 'sssi', $pesa_mais_50kg, $teve_febre_7dias, $fez_tatuagem_12meses, $doador_id);
        $triagem_ok = mysqli_stmt_execute($stmt_triagem);

        if (isset($_POST['id']) && !empty($_POST['id'])) {
            // MODO EDITAR
            $id = $_POST['id'];
            $sql = "UPDATE doacoes SET doador_id = ?, local_id = ?, data_doacao = ?, volume_ml = ?, observacoes = ? WHERE id = ?";
            $stmt = mysqli_prepare($conexao, $sql);
            mysqli_stmt_bind_param($stmt, 'iisssi', $doador_id, $local_id, $data_doacao, $volume_ml, $observacoes, $id);

            if (mysqli_stmt_execute($stmt) && $triagem_ok) {
                header("Location: ../controle_doacoes.php?mensagem=" . urlencode("Doação atualizada com sucesso!") . "&tipo=success");
                exit();
            } else {
                header("Location: ../controle_doacoes.php?mensagem=" . urlencode("Erro ao atualizar doação.") . "&tipo=danger");
                exit();
            }
        } else {
            // MODO INSERIR
            $sql = "INSERT INTO doacoes (doador_id, local_id, data_doacao, volume_ml, observacoes) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conexao, $sql);
            mysqli_stmt_bind_param($stmt, 'iisss', $doador_id, $local_id, $data_doacao, $volume_ml, $observacoes);

            if (mysqli_stmt_execute($stmt) && $triagem_ok) {
                header("Location: ../controle_doacoes.php?mensagem=" . urlencode("Doação registrada com sucesso!") . "&tipo=success");
                exit();
            } else {
                header("Location: ../controle_doacoes.php?mensagem=" . urlencode("Erro ao registrar doação.") . "&tipo=danger");
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

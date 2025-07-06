<?php
session_start();
require '../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_completo = mysqli_real_escape_string($conexao, $_POST['nome_completo']);
    $cpf = mysqli_real_escape_string($conexao, $_POST['cpf']);
    $data_nascimento = mysqli_real_escape_string($conexao, $_POST['data_nascimento']);
    $cep = mysqli_real_escape_string($conexao, $_POST['cep']);
    $tipo_sanguineo = mysqli_real_escape_string($conexao, $_POST['tipo_sanguineo']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $pesa_mais_50kg = mysqli_real_escape_string($conexao, $_POST['pesa_mais_50kg']);
    $teve_febre_7dias = mysqli_real_escape_string($conexao, $_POST['teve_febre_7dias']);
    $fez_tatuagem_12meses = mysqli_real_escape_string($conexao, $_POST['fez_tatuagem_12meses']);

    if (!empty($nome_completo) && !empty($cpf) && !empty($data_nascimento) && !empty($cep) && !empty($tipo_sanguineo) && !empty($email)) {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            // Atualização
            $id = mysqli_real_escape_string($conexao, $_POST['id']);
            $sql = "UPDATE doadores SET
                        nome_completo = '$nome_completo',
                        data_nascimento = '$data_nascimento',
                        cep = '$cep',
                        cpf = '$cpf',
                        tipo_sanguineo = '$tipo_sanguineo',
                        email = '$email',
                        pesa_mais_50kg = '$pesa_mais_50kg',
                        teve_febre_7dias = '$teve_febre_7dias',
                        fez_tatuagem_12meses = '$fez_tatuagem_12meses'
                    WHERE id = '$id'";
            if (mysqli_query($conexao, $sql)) {
                header("Location: ../gerenciar_doadores.php?mensagem=" . urlencode("Doador atualizado com sucesso!") . "&tipo=success");
                exit();
            } else {
                header("Location: ../gerenciar_doadores.php?mensagem=" . urlencode("Erro ao atualizar doador: " . mysqli_error($conexao)) . "&tipo=danger");
                exit();
            }
        } else {
            // Cadastro
            $sql = "INSERT INTO doadores (nome_completo, cpf, data_nascimento, cep, tipo_sanguineo, email, pesa_mais_50kg, teve_febre_7dias, fez_tatuagem_12meses)
                    VALUES ('$nome_completo', '$cpf', '$data_nascimento', '$cep', '$tipo_sanguineo', '$email', '$pesa_mais_50kg', '$teve_febre_7dias', '$fez_tatuagem_12meses')";
            if (mysqli_query($conexao, $sql)) {
                header("Location: ../login.php?mensagem=" . urlencode("Cadastro realizado com sucesso! Agora você pode fazer login.") . "&tipo=success");
                exit();
            } else {
                header("Location: ../cadastrar_doador.php?mensagem=" . urlencode("Erro ao cadastrar doador: " . mysqli_error($conexao)) . "&tipo=danger");
                exit();
            }
        }
    } else {
        header("Location: ../cadastrar_doador.php?mensagem=" . urlencode("Preencha todos os campos obrigatórios.") . "&tipo=warning");
        exit();
    }
} else {
    header("Location: ../cadastrar_doador.php");
    exit();
}
?>

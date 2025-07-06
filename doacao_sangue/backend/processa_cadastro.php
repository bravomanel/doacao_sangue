<?php
session_start();
require '../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_completo = $_POST['nome_completo'];
    $cpf = $_POST['cpf'];
    $data_nascimento = $_POST['data_nascimento'];
    $cep = $_POST['cep'];
    $tipo_sanguineo = $_POST['tipo_sanguineo'];
    $email = $_POST['email'];
    $pesa_mais_50kg = $_POST['pesa_mais_50kg'];
    $teve_febre_7dias = $_POST['teve_febre_7dias'];
    $fez_tatuagem_12meses = $_POST['fez_tatuagem_12meses'];

    if (!empty($nome_completo) && !empty($cpf) && !empty($data_nascimento) && !empty($cep) && !empty($tipo_sanguineo) && !empty($email)) {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            // Atualização segura
            $id = $_POST['id'];
            $sql = "UPDATE doadores SET 
                        nome_completo = ?, 
                        data_nascimento = ?, 
                        cep = ?, 
                        cpf = ?, 
                        tipo_sanguineo = ?, 
                        email = ?, 
                        pesa_mais_50kg = ?, 
                        teve_febre_7dias = ?, 
                        fez_tatuagem_12meses = ? 
                    WHERE id = ?";
            $stmt = mysqli_prepare($conexao, $sql);
            mysqli_stmt_bind_param($stmt, 'sssssssssi',
                $nome_completo, $data_nascimento, $cep, $cpf,
                $tipo_sanguineo, $email, $pesa_mais_50kg,
                $teve_febre_7dias, $fez_tatuagem_12meses, $id
            );

            if (mysqli_stmt_execute($stmt)) {
                if (isset($_SESSION['admin_id']))
                    header("Location: ../gerenciar_doadores.php?mensagem=" . urlencode("Doador atualizado com sucesso!") . "&tipo=success");
                else
                    header("Location: ../controle_doacoes.php?mensagem=" . urlencode("Dados atualizados com sucesso!") . "&tipo=success");
                exit();
            } else {
                header("Location: ../gerenciar_doadores.php?mensagem=" . urlencode("Erro ao atualizar doador.") . "&tipo=danger");
                exit();
            }
        } else {
            // Cadastro seguro
            $sql = "INSERT INTO doadores 
                (nome_completo, cpf, data_nascimento, cep, tipo_sanguineo, email, pesa_mais_50kg, teve_febre_7dias, fez_tatuagem_12meses) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conexao, $sql);
            mysqli_stmt_bind_param($stmt, 'sssssssss',
                $nome_completo, $cpf, $data_nascimento, $cep,
                $tipo_sanguineo, $email, $pesa_mais_50kg,
                $teve_febre_7dias, $fez_tatuagem_12meses
            );

            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../login.php?mensagem=" . urlencode("Cadastro realizado com sucesso! Agora você pode fazer login.") . "&tipo=success");
                exit();
            } else {
                header("Location: ../cadastrar_doador.php?mensagem=" . urlencode("Erro ao cadastrar doador.") . "&tipo=danger");
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
<?php
session_start();
require '../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = trim($_POST['usuario']);

    if (empty($usuario)) {
        header("Location: ../login.php?error=1");
        exit();
    }

    // Protege contra SQL Injection usando prepared statements
    // Verifica se é admin
    $stmt = mysqli_prepare($conexao, "SELECT id, usuario as nome FROM administradores WHERE usuario = ?");
    mysqli_stmt_bind_param($stmt, "s", $usuario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $admin_id, $admin_nome);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_fetch($stmt);
        $_SESSION['admin_id'] = $admin_id;
        $_SESSION['admin_usuario'] = $admin_nome;
        header("Location: ../painel_adm.php");
        exit();
    }
    mysqli_stmt_close($stmt);

    // Se não for admin, verifica se é doador pelo CPF
    $stmt = mysqli_prepare($conexao, "SELECT id, nome_completo as nome FROM doadores WHERE cpf = ?");
    mysqli_stmt_bind_param($stmt, "s", $usuario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $doador_id, $doador_nome);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_fetch($stmt);
        $_SESSION['doador_id'] = $doador_id;
        $_SESSION['doador_nome'] = $doador_nome;
        header("Location: ../controle_doacoes.php");
        exit();
    }
    mysqli_stmt_close($stmt);

    // Se não encontrar, retorna com erro
    header("Location: ../login.php?error=1");
    exit();

} else {
    header("Location: ../login.php");
    exit();
}
?>

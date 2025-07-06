<?php
$servidor = "localhost:3308";
$usuario = "root";
$senha = "";
$banco = "doacao";

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}

mysqli_set_charset($conexao, "utf8");
?>
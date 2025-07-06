<?php
// Verifica se a variável de contexto foi passada
if (!isset($tipo_usuario)) {
    die("Erro de configuração: variável \$tipo_usuario não definida em " . basename(__FILE__));
}

// Verificação para admin
if ($tipo_usuario === 'admin') {
    if (!isset($_SESSION['admin_id'])) {
        header("Location: login.php?error=acesso_negado_admin");
        exit();
    }
}

// Verificação para doador
elseif ($tipo_usuario === 'doador') {
    if (!isset($_SESSION['doador_id'])) {
        header("Location: login.php?error=acesso_negado_doador");
        exit();
    }
}

// Caso variável inválida
else {
    die("Erro de configuração: valor inválido em \$tipo_usuario em " . basename(__FILE__));
}
?>


<?php
require_once 'config.php';

//verificar se o usuario esta logado
if(!isset($_SESSION['usuario_id'])) {
   header('location: login.php');
   exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Financeiro</title>
</head>
<body>
    <h1>Sistema Financeiro</h1>
</body>
</html>
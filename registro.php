<?php
require_once 'config.php';
require_once 'mensagens.php';

// Se já estiver logado, redireciona para o index
if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Sistema Financeiro</title>
</head>
<body>
    <h1>Sistema Financeiro Pessoal</h1>
    <h2>Cadastro de Usuário</h2>
    
    <?php exibir_mensagem(); ?>
    
    <form action="registrar.php" method="POST">
        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
        </div>
        
        <div>
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required minlength="6">
        </div>
        
        <div>
            <label for="confirmar_senha">Confirmar Senha:</label>
            <input type="password" id="confirmar_senha" name="confirmar_senha" required minlength="6">
        </div>
        
        <div>
            <button type="submit">Cadastrar</button>
        </div>
    </form>
    
    <p>Já tem conta? <a href="login.php">Faça login aqui</a></p>
</body>
</html>
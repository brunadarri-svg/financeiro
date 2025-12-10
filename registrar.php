<?php
require_once 'config.php';
require_once 'mensagens.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';
    
    // Validar campos
    if (empty($nome) || empty($email) || empty($senha) || empty($confirmar_senha)) {
        set_mensagem('Preencha todos os campos.', 'erro');
        header('Location: registro.php');
        exit;
    }
    
    // Validar se as senhas coincidem
    if ($senha !== $confirmar_senha) {
        set_mensagem('As senhas não coincidem.', 'erro');
        header('Location: registro.php');
        exit;
    }
    
    // Validar tamanho mínimo da senha
    if (strlen($senha) < 6) {
        set_mensagem('A senha deve ter no mínimo 6 caracteres.', 'erro');
        header('Location: registro.php');
        exit;
    }
    
    // Verificar se o e-mail já existe
    $sql = "SELECT id_usuario FROM usuario WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    if ($stmt->fetch()) {
        set_mensagem('Este e-mail já está cadastrado.', 'erro');
        header('Location: registro.php');
        exit;
    }
    
    // Criar hash da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    
    // Inserir novo usuário
    $sql = "INSERT INTO usuario (nome, email, senha) VALUES (:nome, :email, :senha)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha_hash);
    
    if ($stmt->execute()) {
        set_mensagem('Cadastro realizado com sucesso! Faça login para continuar.', 'sucesso');
        header('Location: login.php');
        exit;
    } else {
        set_mensagem('Erro ao realizar cadastro. Tente novamente.', 'erro');
        header('Location: registro.php');
        exit;
    }
} else {
    header('Location: registro.php');
    exit;
}
?>
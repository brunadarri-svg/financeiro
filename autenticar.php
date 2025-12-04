<?php
require_once 'config.php';
require_once 'mensagens.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email']?? '';
    $senha = $_POST['senha']?? '';
    // echo "Email:$email - Senha:$senha";

    //validar os campos
    if (empty($email)|| empty ($senha)){
        set_mensagem('Preencha todos os campos','erro');
        header ('location: login.php');
        exit;
    }

    //buscar usuario no banco de dados
    $sql= "SELECT * FROM usuario WHERE email = :email";
    $stmt = $conn->prepare ($sql);
    $stmt ->bindParam(':email', $email);
    $stmt ->execute();
    $usuario = $stmt->fetch();

    //verificar se  o usuario existe e se a senha está correta
    if ($usuario && password_verify($senha, $usuario['senha'])){
        //login bem-sucedido
        $_SESSION['usuario_id'] = $usuario['id_usuario'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_email'] = $usuario['email'];

        header('location: index.php');
        exit;
    } else{
        set_mensagem('E-mail ou senha incorretos','erro');
        header('location: login.php');
        exit;
    }
} else {
    header('location: login.php');
    exit;
}
?>

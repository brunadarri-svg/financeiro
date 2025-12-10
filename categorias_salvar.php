<?php
require_once 'config.php';
require_once 'mensagens.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_SESSION['usuario_id'];
    $id_categoria = $_POST['id_categoria'] ?? null;
    $nome = $_POST['nome'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    
    // Validar campos
    if (empty($nome) || empty($tipo)) {
        set_mensagem('Preencha todos os campos.', 'erro');
        header('Location: categorias_formulario.php' . ($id_categoria ? '?id=' . $id_categoria : ''));
        exit;
    }
    
    // Validar tipo
    if (!in_array($tipo, ['receita', 'despesa'])) {
        set_mensagem('Tipo inválido.', 'erro');
        header('Location: categorias_formulario.php' . ($id_categoria ? '?id=' . $id_categoria : ''));
        exit;
    }
    
    if ($id_categoria) {
        // Atualizar categoria existente
        $sql = "UPDATE categoria SET nome = :nome, tipo = :tipo 
                WHERE id_categoria = :id_categoria AND id_usuario = :usuario_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':usuario_id', $usuario_id);
        
        if ($stmt->execute()) {
            set_mensagem('Categoria atualizada com sucesso!', 'sucesso');
        } else {
            set_mensagem('Erro ao atualizar categoria.', 'erro');
        }
    } else {
        // Inserir nova categoria
        $sql = "INSERT INTO categoria (id_usuario, nome, tipo) VALUES (:usuario_id, :nome, :tipo)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':tipo', $tipo);
        
        if ($stmt->execute()) {
            set_mensagem('Categoria cadastrada com sucesso!', 'sucesso');
        } else {
            set_mensagem('Erro ao cadastrar categoria.', 'erro');
        }
    }
    
    header('Location: categorias_listar.php');
    exit;
} else {
    header('Location: categorias_listar.php');
    exit;
}
?>
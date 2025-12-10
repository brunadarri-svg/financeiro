<?php
require_once 'config.php';
require_once 'mensagens.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$id_categoria = $_GET['id'] ?? null;

if ($id_categoria) {
    // Verificar se a categoria pertence ao usuário
    $sql = "SELECT id_categoria FROM categoria WHERE id_categoria = :id_categoria AND id_usuario = :usuario_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_categoria', $id_categoria);
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->execute();
    
    if ($stmt->fetch()) {
        // Excluir categoria
        $sql = "DELETE FROM categoria WHERE id_categoria = :id_categoria AND id_usuario = :usuario_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':usuario_id', $usuario_id);
        
        if ($stmt->execute()) {
            set_mensagem('Categoria excluída com sucesso!', 'sucesso');
        } else {
            set_mensagem('Erro ao excluir categoria.', 'erro');
        }
    } else {
        set_mensagem('Categoria não encontrada.', 'erro');
    }
} else {
    set_mensagem('ID da categoria não informado.', 'erro');
}

header('Location: categorias_listar.php');
exit;
?>
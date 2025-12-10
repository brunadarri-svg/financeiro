<?php
require_once 'config.php';
require_once 'mensagens.php';

//verificar se o usuario esta logado
if (!isset($_SESSION['usuario_id'])) {
    header('location: login.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$usuario_nome = $_SESSION['usuario_nome'];

// verificar se esta editando 
$id_categoria = $_GET['id'] ?? null;
$categoria = null;

if ($id_categoria) {
    // Buscar categoria para editar
    $sql = "SELECT * FROM categoria WHERE id_categoria = :id_categoria AND id_usuario = :usuario_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_categoria', $id_categoria);
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->execute();
    $categoria = $stmt->fetch();

    // Se não encontrou ou não pertence ao usuário, redireciona
    if (!$categoria) {
        set_mensagem('Categorias não encontrada.', 'erro');
        header('Location: categorias_listar.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias - Sistemas Financeiro</title>
    <link rel="stylesheet" href="style.css">
</head>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Wepink</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="index.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="categorias_listar.php">Categorias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="transacoes_listar.php">Transações</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<body>
    </div>
    <p>Bem-vindo, <strong> <?php echo $usuario_nome ?> </strong></p>
    <a href="logout.php">Sair</a>
    </div>

    <?php exibir_mensagem(); ?>

    <nav>
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="categorias_listar.php">Categorias</a></li>
            <li><a href="transacoes_lista.php">transações</a></li>
        </ul>
    </nav>

    <h2><?php echo $categoria ? 'Editar' : 'Nova'; ?> Categoria</h2>

    <form action="categorias_salvar.php" method="POST">
        <?php if ($categoria): ?>
            <input type="hidden" name="id_categoria" value="<?php echo $categoria['id_categoria']; ?>">
        <?php endif; ?>

        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome"
                value="<?php echo $categoria ? htmlspecialchars($categoria['nome']) : ''; ?>"
                required>
        </div>

        <div>
            <label for="tipo">Tipo:</label>
            <select id="tipo" name="tipo" required>
                <option value="">Selecione...</option>
                <option value="receita" <?php echo ($categoria && $categoria['tipo'] === 'receita') ? 'selected' : ''; ?>>Receita</option>
                <option value="despesa" <?php echo ($categoria && $categoria['tipo'] === 'despesa') ? 'selected' : ''; ?>>Despesa</option>
            </select>
        </div>

        <div>
            <button type="submit">Salvar</button>
            <a href="categorias_listar.php">Cancelar</a>
        </div>
    </form>
</body>

</html>
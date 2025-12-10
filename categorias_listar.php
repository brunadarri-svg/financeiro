<?php
require_once 'config.php';
require_once 'mensagens.php';


// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$usuario_nome = $_SESSION['usuario_nome'];

// Buscar todas as categorias do usuário
$sql = "SELECT * FROM categoria WHERE id_usuario = :usuario_id ORDER BY tipo, nome";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':usuario_id', $usuario_id);
$stmt->execute();
$categorias = $stmt->fetchAll();



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias - Sistema Financeiro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Financeiro</a>
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
    <div class="container">
        <h1>Sistema Financeiro</h1>
        <div>
            <p>Bem-vindo, <strong> <?php echo $usuario_nome ?> </strong></p>
            <a href="logout.php">Sair</a>
        </div>

        <?php exibir_mensagem(); ?>

        <nav>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="categorias_listar.php">Categorias</a></li>
                <li><a href="tansacoes_listar.php">Transações</a></li>
            </ul>
        </nav>

        <h2>Categorias</h2>

        <div>
            <a class="btn btn-primary" href="categorias_formulario.php">Nova Categoria</a>
        </div>

        <?php if (count($categorias) > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categorias as $categoria): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($categoria['nome']); ?></td>
                            <td><?php echo ucfirst($categoria['tipo']); ?></td>
                            <td>
                                <a class="btn btn-success" href="categorias_formulario.php?id=<?php echo $categoria['id_categoria']; ?>">Editar</a>
                                <a class="btn btn-danger" href="categorias_excluir.php?id=<?php echo $categoria['id_categoria']; ?>"
                                    onclick="return confirm('Tem certeza que deseja excluir esta categoria?');">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhuma categoria cadastrada ainda.</p>
        <?php endif; ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>
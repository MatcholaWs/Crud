<?php
session_start();
require_once('../administrador/conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['update']) && $_GET['update'] === 'success') {
    echo "<div style='color: green;'>Categoria atualizada com sucesso!</div>";
}

try {
    $stmt = $pdo->prepare("SELECT 
        CATEGORIA_ID,
        CATEGORIA_NOME,
        CATEGORIA_DESC,
        CATEGORIA_ATIVO 
        FROM CATEGORIA
    ");
    $stmt->execute();
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $erro) {
    echo "<p style='color: red;'>Erro " . htmlspecialchars($erro->getMessage()) . "</p>";
}

try {
    $itens_por_pagina = 10;
    $pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 0;
    $offset = $pagina * $itens_por_pagina;

    $stmt = $pdo->prepare("SELECT PRODUTO.*, CATEGORIA.CATEGORIA_NOME, PRODUTO_IMAGEM.IMAGEM_URL, PRODUTO_ESTOQUE.PRODUTO_QTD
                           FROM PRODUTO 
                           JOIN CATEGORIA ON PRODUTO.CATEGORIA_ID = CATEGORIA.CATEGORIA_ID 
                           LEFT JOIN PRODUTO_IMAGEM ON PRODUTO.PRODUTO_ID = PRODUTO_IMAGEM.PRODUTO_ID
                           LEFT JOIN PRODUTO_ESTOQUE ON PRODUTO.PRODUTO_ID = PRODUTO_ESTOQUE.PRODUTO_ID
                           LIMIT :offset, :itens_por_pagina");
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':itens_por_pagina', $itens_por_pagina, PDO::PARAM_INT);
    $stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $num_total = $pdo->query("SELECT COUNT(*) FROM PRODUTO")->fetchColumn();
    $num_paginas = ceil($num_total / $itens_por_pagina);
} catch (PDOException $e) {
    echo "<p style='color: red;'>Erro ao listar produtos: " . htmlspecialchars($e->getMessage()) . "</p>";
}

$categoriasExistentes = !empty($categorias);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar categoria</title>
    <link rel="stylesheet" href="./estilo_listarcategoria.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

    <a href="painel_admin.php"><img src="../img/charlie-logo.png" class="imagem" alt=""></a>

    <h2>Listar Categoria</h2>

    <?php if ($categoriasExistentes) : ?>
        <table class="table table-hover">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Ativo</th>
                <th>Editar</th>
                <th>Opções</th>
            </tr>
            <?php foreach ($categorias as $categoria) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($categoria['CATEGORIA_ID']); ?></td>
                    <td><?php echo htmlspecialchars($categoria['CATEGORIA_NOME']); ?></td>
                    <td><?php echo htmlspecialchars($categoria['CATEGORIA_DESC']); ?></td>
                    <td>
                        <?php echo ($categoria['CATEGORIA_ATIVO'] == 0) ? 'Inativo' : 'Ativo'; ?>
                    </td>
                    <td>
                        <div class="alinha">
                                <a href="editar_categoria.php?CATEGORIA_ID=<?php echo $categoria['CATEGORIA_ID']; ?>" class="action-btn" data-toggle="tooltip" data-original-title="Edit user">
                                    Editar
                                </a>
                        </div>
                    </td>
                    <td>

                            <?php if ($categoria['CATEGORIA_ATIVO'] == 0): ?>

                                    <a href="ativar_categoria.php?id=<?php echo $categoria['CATEGORIA_ID']; ?>" class="action-btn">Ativar</a>

                            <?php endif; ?>


                            <?php if ($categoria['CATEGORIA_ATIVO'] == 1): ?>
                                    <a href="desativar_categoria.php?id=<?php echo $categoria['CATEGORIA_ID']; ?>" class="action-btn">Desativar</a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>

        </nav>
    <?php else : ?>
        <p>Nenhuma categoria encontrada.</p>
    <?php endif; ?>
    
    <button type="button" class="btn btn-danger">
        <a href="painel_admin.php">Voltar ao Painel do Administrador</a>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

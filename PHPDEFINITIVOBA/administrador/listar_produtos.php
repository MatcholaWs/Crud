<?php
session_start();
require_once('../administrador/conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location: login.php");
    exit();
}

try {
    $itens_por_pagina = 20;

    $pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 0;
    $offset = $pagina * $itens_por_pagina;

    $stmt = $pdo->prepare("SELECT PRODUTO.*, CATEGORIA.CATEGORIA_NOME, PRODUTO_IMAGEM.IMAGEM_URL, PRODUTO_ESTOQUE.PRODUTO_QTD
                           FROM PRODUTO 
                           JOIN CATEGORIA ON PRODUTO.CATEGORIA_ID = CATEGORIA.CATEGORIA_ID 
                           LEFT JOIN PRODUTO_IMAGEM ON PRODUTO.PRODUTO_ID = PRODUTO_IMAGEM.PRODUTO_ID
                           LEFT JOIN PRODUTO_ESTOQUE ON PRODUTO.PRODUTO_ID = PRODUTO_ESTOQUE.PRODUTO_ID
                           ORDER BY PRODUTO.PRODUTO_ID
                           LIMIT :offset, :itens_por_pagina");
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':itens_por_pagina', $itens_por_pagina, PDO::PARAM_INT);
    $stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $num_total = $pdo->query("SELECT COUNT(*) FROM PRODUTO")->fetchColumn();
    $num_paginas = ceil($num_total / $itens_por_pagina + 2);
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao listar produtos: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Listar Produtos</title>
    <link rel="stylesheet" href="./estilo_listar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <a href="painel_admin.php"><img src="../img/charlie-logo.png" class="imagem" alt=""></a>
    
    <h2>Produtos Cadastrados</h2>

    <?php if (!empty($produtos)) : ?>
        <table class="table table-hover">
            <!-- cabeçalho da tabela -->
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Categoria</th>
                <th>Ativo</th>
                <th>Desconto</th>
                <th>Estoque</th>
                <th>Imagem</th>
                <th>Ações</th>
            </tr>

            <!-- corpo da tabela -->
            <?php foreach ($produtos as $produto) : ?>
                <tr>
                    <td><?php echo $produto['PRODUTO_ID']; ?></td>
                    <td><?php echo $produto['PRODUTO_NOME']; ?></td>
                    <td><?php echo $produto['PRODUTO_DESC']; ?></td>
                    <td><?php echo $produto['PRODUTO_PRECO']; ?></td>
                    <td><?php echo $produto['CATEGORIA_NOME']; ?></td>
                    <td><?php echo ($produto['PRODUTO_ATIVO'] == 1 ? 'Sim' : 'Não'); ?></td>
                    <td><?php echo $produto['PRODUTO_DESCONTO']; ?></td>
                    <td><?php echo $produto['PRODUTO_QTD']; ?></td> 
                    <td><img src="<?php echo $produto['IMAGEM_URL']; ?>" alt="<?php echo $produto['PRODUTO_NOME']; ?>" width="50">
                    <td>
                    <div class="content">
                    <!-- Links para editar, desativar e ativar o produto -->
                    <a href="editar_produto.php?id=<?php echo $produto['PRODUTO_ID']; ?>" class="action-btn">Editar</a>
                    <?php if ($produto['PRODUTO_ATIVO'] == 1): ?>
                        <a href="desativar_produto.php?id=<?php echo $produto['PRODUTO_ID']; ?>" class="action-btn delete-btn">Desativar</a>
                    <?php endif; ?>
                    <?php if ($produto['PRODUTO_ATIVO'] == 0): ?>
                        <a href="ativar_produto.php?id=<?php echo $produto['PRODUTO_ID']; ?>" class="action-btn delete-btn">Ativar</a>
                    <?php endif; ?>
                </div>
                </td>
                </tr>

                
                
            <?php endforeach; ?>
        </table>

        <!-- paginação -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php for ($i = 0; $i < $num_paginas; $i++) : ?>
                    <li class="page-item <?php echo $pagina == $i ? 'active' : ''; ?>">
                        <a class="page-link" href="listar_produtos.php?pagina=<?php echo $i; ?>"><?php echo $i + 1; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php else : ?>
        <p>Nenhum produto encontrado.</p>
    <?php endif; ?>
    
        <button type="button" class="btn btn-danger">
            <a href="painel_admin.php">Voltar ao Painel do Administrador</a>
        </button>
  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>

<?php
// Inicia a sessão para gerenciar variáveis de sessão
session_start();
// Inclui o arquivo de conexão com o banco de dados
require_once('../administrador/conexao.php');

// Verifica se o administrador está logado
if (!isset($_SESSION['admin_logado'])) {
    // Se não estiver, redireciona para a página de login e encerra o script
    header("Location:login.php");
    exit();
}

try {
    // Prepara e executa uma consulta SQL para obter todos os dados da tabela ADMINISTRADOR
    $stmt = $pdo->prepare("SELECT ADMINISTRADOR.*, ADM_NOME, ADM_EMAIL, ADM_SENHA, ADM_ATIVO, ADM_IMAGEM 
                           FROM ADMINISTRADOR ");
    $stmt->execute();
    // Obtém todos os resultados da consulta como um array associativo
    $administrador = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Em caso de erro, exibe uma mensagem de erro em vermelho
    echo "<p style='color:red;'>Erro ao listar Administrador: " . $e->getMessage() . "</p>";
}
?>

<?php
$pagina_atual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$itens_por_pagina = 10;

try {
    // Obter o número total de administradores
    $num_total_administradores = $pdo->query("SELECT COUNT(*) FROM ADMINISTRADOR")->fetchColumn();

    // Calcular o número de páginas
    $num_paginas = ceil($num_total_administradores / $itens_por_pagina);

    // Calcular o deslocamento
    $offset = ($pagina_atual - 1) * $itens_por_pagina;

    // Consulta SQL com o deslocamento correto
    $stmt = $pdo->prepare("SELECT ADMINISTRADOR.*, ADM_NOME, ADM_EMAIL, ADM_SENHA, ADM_ATIVO, ADM_IMAGEM 
                           FROM ADMINISTRADOR LIMIT :offset, :itens_por_pagina");
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':itens_por_pagina', $itens_por_pagina, PDO::PARAM_INT);
    $stmt->execute();
    $administrador = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Tratamento de erros
    echo "<p style='color:red;'>Erro ao listar Administrador: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Listar Administradores</title>
    <link rel="stylesheet" href="./estilo_listaradm.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

<a href="painel_admin.php"><img src="../img/charlie-logo.png" class="imagem" alt=""></a>
    <h2>Listar Administradores</h2>

    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Senha</th>
            <th>Ativo</th>
            <th>Avatar</th>
            <th>Ações</th>
        </tr>
        <?php foreach($administrador as $adm): ?>
            <tr>
                <!-- Células com dados do administrador -->
                <td><?php echo $adm['ADM_ID']; ?></td>
                <td><?php echo $adm['ADM_NOME']; ?></td>
                <td><?php echo $adm['ADM_EMAIL']; ?></td>
                <td><?php echo $adm['ADM_SENHA']; ?></td>
                <td><?php echo ($adm['ADM_ATIVO'] == 1 ? 'Sim' : 'Não'); ?></td>
                <td><img src="<?php echo $adm['ADM_IMAGEM']; ?>" alt="<?php echo "A imagem do Administrador " . $adm['ADM_NOME'] . " não pode ser carregada"; ?>" width="50"></td>
                <td>
                    <div class="editar">
                        <a href="editar_adm.php?id=<?php echo $adm['ADM_ID']; ?>" class="action-btn">Editar</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p></p>

    <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <?php for ($i = 0; $i < $num_paginas; $i++) : ?>
            <li class="page-item <?php echo $pagina_atual == $i + 1 ? 'active' : ''; ?>">
                <a class="page-link" href="listar_adm.php?pagina=<?php echo $i + 1; ?>"><?php echo $i + 1; ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>

    <button type="button" class="btn btn-danger">
        <a href="painel_admin.php">Voltar ao Painel do Administrador</a>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

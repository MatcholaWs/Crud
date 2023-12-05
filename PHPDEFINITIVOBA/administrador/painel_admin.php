<?php
session_start(); // Iniciar a sessão

if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Painel do Administrador</title>
    <link rel="stylesheet" href="./estilo_painel.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    
    <div class="container">
        <img src="../img/charlie-logo.png" alt="">
        <h2>Bem-vindo, Administrador!</h2>
        <div class="btn-style">
            <div class="section_produto">
                <p class="text">Produtos</p>
                <a href="cadastrar_produto.php">
                    <button type="button" class="btn btn-danger">Cadastrar Produtos</button>
                </a>
                <a href="listar_produtos.php">
                    <button type="button" class="btn btn-danger">Listar Produtos</button>
                </a>
            </div>

            <div class="section_adm">
                <p class="text">Administrador</p>
                <a href="cadastrar_admin.php">
                    <button type="button" class="btn btn-danger">Cadastrar Administrador</button>
                </a>
                <a href="listar_adm.php">
                    <button type="button" class="btn btn-danger">Listar Administrador</button>
                </a>
            </div>

            <div class="section_categoria">
                <p class="text">Categoria</p>
                <a href="cadastrar_categoria.php">
                    <button type="button" class="btn btn-danger">Cadastrar Categoria</button>
                </a>
                <a href="listar_categoria.php">
                    <button type="button" class="btn btn-danger">Listar Categoria</button>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

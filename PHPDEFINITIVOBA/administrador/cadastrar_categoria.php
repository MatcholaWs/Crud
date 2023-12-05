<?php
session_start();
require_once('../administrador/conexao.php');

// Verifica se o administrador está logado.
if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {  //Conexão com o banco de dados

    $CATEGORIA_NOME = $_POST['CATEGORIA_NOME'];
    $CATEGORIA_DESC = $_POST['CATEGORIA_DESC'];
    $CATEGORIA_ATIVO = $_POST['CATEGORIA_ATIVO'];

    try {
        $sql = "INSERT INTO CATEGORIA (CATEGORIA_NOME, CATEGORIA_DESC, CATEGORIA_ATIVO) VALUES (:CATEGORIA_NOME, :CATEGORIA_DESC, :CATEGORIA_ATIVO)";
        $stmt = $pdo->prepare($sql); // Preparação para não conter injeção de sql
        $stmt->bindParam(':CATEGORIA_NOME', $CATEGORIA_NOME, PDO::PARAM_STR);
        $stmt->bindParam(':CATEGORIA_DESC', $CATEGORIA_DESC, PDO::PARAM_STR);
        $stmt->bindParam(':CATEGORIA_ATIVO', $CATEGORIA_ATIVO, PDO::PARAM_INT);
        $stmt->execute(); //executa os comandos

        echo "<div id='messagee'>Cadastrado com sucesso</div>";
    } catch (PDOException $erro) {
        echo "<div id='messagee'>Erro ao realizar o cadastro</div>" . $erro->getMessage() . "</p>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar categoria</title>
    <link rel="stylesheet" href="estilo_cadastrarCategoria.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

    <a href="painel_admin.php"><img src="../img/charlie-logo.png" class="imagem" alt=""></a>

    <h2>Cadastrar Categoria</h2>

    <form method="post" action="">
        <label for="CATEGORIA_NOME">Nome da categoria </label>
        <input type="text" name="CATEGORIA_NOME" id="CATEGORIA_NOME" required>
  
        <label for="CATEGORIA_DESC">Descrição da categoria</label>
        <input type="text" name="CATEGORIA_DESC" id="CATEGORIA_DESC" required>
       
        <label for="CATEGORIA_ATIVO">Status</label>
        <select name="CATEGORIA_ATIVO" id="CATEGORIA_ATIVO">
            <option value="1">Ativo</option>
            <option value="0">Inativo</option>
        </select>
            <div class="botao">
                <button type="submit" value="Cadastrar" class="btn btn-danger" >Cadastrar Categoria</button>
            </div>
    </form>

    <div class="btn-voltar">
        <button type="button" class="btn btn-danger"><a href="painel_admin.php">Voltar ao Painel do Administrador<a><button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>



                        
                       

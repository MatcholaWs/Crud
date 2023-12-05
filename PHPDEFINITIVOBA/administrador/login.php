<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela Login ADM</title>
    <link rel="stylesheet" href="./estilo_login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <img src="../img/charlie-logo.png" alt="">
    <form action="processa_login.php" method="post" class="formu">
        <div class="form-content">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required>
            <p></p>
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>
            <p></p>
        </div>
        <input type="submit" value="Entrar" class="btn btn-danger">
        <?php
        if(isset($_GET['erro'])){
            echo '<p style="color:red;">Nome de usuario ou senha incorretos!</p>';
        }
        ?>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
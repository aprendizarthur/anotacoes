<?php
require("../vendor/autoload.php");
use app\classes\{Database, User, Auth, Anotacao};

//instanciando database e conectando
$database = new Database();
$database->connection("anotacoes");

//instanciando auth (iniciando sessao e redirecionando users deslogados)
$auth = new Auth();
$auth->restringirAcessoLogado();

//instanciando usuário e fazendo registro (aguardando post)
$user = new User();
try{
    $user->Register();
}catch(Exception $e){
    echo '<div class="col-12 text-center">'.$e->getMessage().'</div>';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título, Ícone, Descrição e Cor de tema p/ navegador -->
    <title>Anotações</title>
    <link rel="icon" type="image/x-icon" href="">
    <meta name="description" content="Treino POO PDO">
    <meta name="theme-color" content="#FFFFFF">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Fontawesome JS -->
    <script src="https://kit.fontawesome.com/6afdaad939.js" crossorigin="anonymous">      </script>
    <!-- Folha CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!--Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-11 col-md-7 col-lg-5 text-center p-4 box-form">
                <!--Formulário de login-->
                <form class="form text-left" method="POST">
                    <h1 class="roboto-bold">Registro</h1>
                    <hr>
                    <div class="roboto-regular form-group">
                        <label for="name">Nome</label>
                        <input required class="form-control" autocomplete="name" type="text" name="name" id="name">
                    </div>

                    <div class="roboto-regular form-group">
                        <label for="email">E-mail</label>
                        <input required class="form-control" autocomplete="email" type="text" name="email" id="email">
                    </div>

                    <div class="roboto-regular form-group">
                        <label for="pass">Senha</label>
                        <input required class="form-control" autocomplete="off" type="password" name="pass" id="pass">
                    </div>

                    <div class="roboto-regular form-group">
                        <label for="passConfirmation">Confirmar Senha</label>
                        <input required class="form-control" autocomplete="off" type="password" name="passConfirmation" id="passConfirmation">
                    </div>

                    <button class="btn btn-primary w-100 roboto-bold mt-2" type="submit" name="submit">Registrar</button>
                </form>
                <small class="roboto- d-inline-block mx-2 mt-3"><a class="blue-1" href="index.php">Já tenho uma conta</a></small>
            </div>   
        </div>
    </div>
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
<?php
require("../vendor/autoload.php");
use app\classes\{Database, User, Auth, AuthNote, Note};

//instanciando e conectando db
$database = new Database();
$database->connection('anotacoes');

//instanciando Auth e restringindo acesso usuários deslogados
$auth = new Auth();
$auth->restringirAcessoDeslogado();

//instanciando nota e adicionando ela no db (esperando post)
$note = new Note();
try{
    $note->Add();
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
            <div class="col-2 col-md-1 col-lg-1 p-3 box-panel-left">
                <!--NAV PANEL-->
                <section id="nav-panel">
                    <nav>
                        <ul class="text-center">
                            <li><a class="black-1" href="panel.php"><i class="fa-solid fa-arrow-left fa-xl"></i></a></li>
                        </ul>
                    </nav>
                </section>
            </div>
    
            <div class="col-9 col-md-10 col-lg-10 p-4 box-panel-right-note">
                <section id="form-note">
                    <form class="form roboto-regular" method="POST">
                        <h1 class="roboto-bold" style="float:left;">Nova nota</h1>
                        <button class="btn btn-in-note-green mb-3" name="submit" type="submit"><i class="fa-solid fa-check fa-lg"></i></button>
                        <input required class="p-1 mx-2 form-control roboto-bold" type="color" value="#e7e078" name="color" id="color">
                        <hr style="clear: both;">
                        <div class="form-group">
                            <input required class="form-control roboto-bold" type="text" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <textarea required spellcheck="true" class="form-control w-100" name="content" id="content" cols="30" rows="14"></textarea>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>



    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
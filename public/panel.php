<?php
require("../vendor/autoload.php");
use app\classes\{User, Auth, Database};
//instanciando auth (redireciona deslogados)
$auth = new Auth;
$auth->restringirAcessoDeslogado();

//instanciando e conectando db
$database = new Database;
$database->connection('anotacoes');

//instanciando usuario e depois fazendo logout (esperando post)
$user = new User();
try{
    $user->Logout();
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
            <div class="col-2 col-md-3 col-lg-2 p-3 box-panel-left">
                <!--NAV PANEL-->
                <section id="nav-panel">
                    <nav>
                        <ul class="text-center">
                            <li class="d-none d-md-flex"><span class="d-inline roboto-bold">Usuário</span></li>
                            <li><a class="blue-1" href="novaAnotacao.php"><i class="fa-solid fa-plus mr-2"></i><i class="fa-solid fa-note-sticky fa-xl"></i></a></li>
                            <li><form method="POST"><button class="btn-logout w-100" name="submit-logout" type="submit">Sair</button></form></li>
                        </ul>
                    </nav>
                </section>
            </div>
    
            <div class="col-9 col-md-8 col-lg-9 p-3 box-panel-right">
                <div class="row d-flex justify-content-around">
                    
                </div>
            </div>
        </div>
    </div>


    
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
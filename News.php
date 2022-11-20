<?php
include($_SERVER['DOCUMENT_ROOT'] . '/projeto-caramelo-php/vendor/autoload.php');

use App\Functions;
use App\Auth;

if (Auth::verificaSessionLogin() == false) {
    echo "<script>alert('Faça login novamente!');window.location.href = './login.php';</script>";
}


if (!isset($_GET['id'])) {
    echo "<script>window.location.href = './Main.php'</script>";
} else {
    $news = Functions::getNews($_GET['id']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="src/css/bootstrap.css" rel="stylesheet" />
    <link href="src/css/bootstrap-theme.css" rel="stylesheet" />
    <title>Notícias</title>
    <style>
        .error-img {
            object-fit: fill;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <img class="mx-auto d-block img-fluid" src="src/assets/logominha.png" width="140" height="70" alt="Logo do aplicativo: AnamnePet">
        <button class="navbar-toggler mx-4" type="button" data-bs-toggle="collapse" href="#navbarMenuOptions" aria-controls="navbarMenuOptions" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <div class="collapse text-center" id="navbarMenuOptions">
        <!--Opções de navegação do Menu de Navegação-->
        <div class="bg-dark p-4">
            <ul class="navbar-nav text-white">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="./Main.php">Menu principal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#">Meu perfil</a>
                </li>
                <li class="nav-item">
                    <button class="btn btn-danger" style="width: 60%;" onclick="logoutUser()">Sair</button>
                </li>
            </ul>
        </div>
    </div>
    <!--Opções de navegação do Menu de Navegação-->
    <div class="btn-add-pet container-fluid mt-4 mb-4" style="width: 100%;">
        <a href="./Main.php" class="btn btn-outline-secondary mt-4 mb-2">Voltar</a>
    </div>
    <div class="container mt-4" style="width: 80%;">
        <div class="container border text-center" style="height: 17em; padding:0; border-radius: 3px;">
            <img class="img-fluid" style="height: 17em; width: inherit; border-radius: 3px; object-fit: cover;" src="<?= $news['news_url_photo'] ?>" onerror="this.src='src/assets/logominha.png';this.className ='error-img';">
        </div>
        <hr>
        <h1><?= $news['title_news'] ?></h1>
        <hr>
        <div class="container mb-3">
            <p><?= $news['news_content'] ?></p>
        </div>
    </div>
    <script src="./src/js/bootstrap.bundle.min.js"></script>
    <script src="./src/js/scripts.js"></script>

</body>

</html>
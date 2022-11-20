<?php
include($_SERVER['DOCUMENT_ROOT'] . '/projeto-caramelo-php/vendor/autoload.php');
include('Uniquecode.php');

use App\Auth;

Auth::verificaSessionLogin();

if($_REQUEST) {
    $pet = getPetByCode($_POST['codigo']);
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
    <title>Vacinas</title>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <img class="mx-auto d-block img-fluid" src="src/assets/logominha.png" width="140" height="70" alt="Logo do aplicativo: AnamnePet">
        <button class="navbar-toggler mx-4" type="button" data-bs-toggle="collapse" href="#navbarMenuOptions" aria-controls="navbarMenuOptions" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <div class="collapse" id="navbarMenuOptions">
        <!--Opções de navegação do Menu de Navegação-->
        <div class="bg-dark p-4">
            <ul class="navbar-nav text-white">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#">Menu principal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#">Meu perfil</a>
                </li>
                <li class="nav-item">
                    <button class="btn btn-danger" onclick="logoutUser()">Sair</button>
                </li>
            </ul>
        </div>
    </div>
    <!--Opções de navegação do Menu de Navegação-->
    <div class="container mt-4 " style="width: 80%;">
    <form method="POST">
        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Código</span>
            <input name="codigo" type="text" class="form-control">
        </div>
    </div>
    <!--Container filtros-->
    <div class="container d-flex justify-content-end mt-2" style="width: 80%;">
        <!--Container que segura os buttons-->
        <button type="submit" class="btn btn-primary mx-2">Acessar</button>
    </div>
    </form>
    <!--Container que contem os buttons-->
    <div class="result container my-4" style="width: 80%;">
        <h2>Resultados:</h2>
        <hr>
        <?php if(@$pet) { ?>
        <div class="card">
            <div class="card-header">V3</div>
            <div class="card-body">
                <p class="card-text">Pet: Branquinho</p>
                <p class="card-text">Previne: Panleucopenia, Rinotraqueíte e outras doenças</p>
                <span class="card-text">Data de aplicação:</span>
                <span class="text-muted d-inline">06/11/2022</span>
                <button data-bs-toggle="collapse" class="btn btn-primary d-block mt-3" data-bs-target="#attachment">Ver anexo</button>
                <div id="attachment" class="collapse mt-2 border">
                    <img class="zoom" src="src/assets/logominha.png" alt="..." width="100%" height="120">
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/medium-zoom@1.0.6/dist/medium-zoom.min.js"></script>
    <script src="./src/js/bootstrap.bundle.min.js"></script>
    <script src="./src/js/scripts.js"></script>
    <script>
        mediumZoom('.zoom', {
            margin: 50
        })
    </script>
</body>

</html>
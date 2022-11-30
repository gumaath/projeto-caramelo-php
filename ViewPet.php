<?php
include($_SERVER['DOCUMENT_ROOT'] . '/projeto-caramelo-php/vendor/autoload.php');
include('Uniquecode.php');

use App\Auth;
use App\Functions;
use App\Connect;

Auth::verificaSessionLogin();

$db = new Connect();
$dbcon = $db->ConnectDB();
$_functions = new Functions($dbcon);

if($_REQUEST) {
    $pet = getPetByCode($_POST['codigo']);
    if(@$pet) {
        $race_pet = $_functions::loadRacePet($pet['race_pet']);
        $type_pet = $_functions::loadTypePet($pet['type_pet']);
    } elseif(empty(@$pet)) {
        echo "<script>alert('Código expirado ou incorreto!')</script>";
    }      
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
    <title>Consultar Pet</title>
</head>

<body>
<nav class="navbar navbar-dark bg-dark">
    <img class="mx-auto d-block img-fluid rounded" src="src/assets/logotmp.png" width="140" height="70" alt="Logo do aplicativo: AnamnePet">
    <button class="navbar-toggler mx-4" type="button" data-bs-toggle="collapse" href="#navbarMenuOptions" aria-controls="navbarMenuOptions" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </nav>
  <div class="collapse text-center" id="navbarMenuOptions">
    <div class="bg-dark p-4">
      <ul class="navbar-nav text-white">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="#">Meu perfil</a>
        </li>
        <li class="nav-item">
          <button class="btn btn-danger" style="width: 60%;" onclick="logoutUser()">Sair</button>
        </li>
      </ul>
    </div>
  </div>
    <div class="btn-add-pet container-fluid mt-4 mb-4" style="width: 100%;">
        <a href="./Main.php" class="btn btn-outline-secondary mt-4 mb-2">Voltar</a>
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
            <div class="card-header">Pet: <?=$pet['name_pet']?></div>
            <div class="card-body">
                <p class="card-text">Tipo:  <?=$type_pet['name_type']?></p>
                <p class="card-text">Raça: <?=$race_pet['name_race']?></p>
                <span class="card-text">Data de nascimento:</span>
                <span class="text-muted d-inline"><?=$pet['birth_pet']?></span>
                <br>
                <a class="btn btn-primary mt-3" href="#">Abrir perfil do pet</a>
            </div>
        </div>
        <?php } ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/medium-zoom@1.0.6/dist/medium-zoom.min.js"></script>
    <script src="./src/js/bootstrap.bundle.min.js"></script>
    <script src="./src/js/scripts.js"></script>   
</body>

</html>
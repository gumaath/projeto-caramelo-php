<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/projeto-caramelo-php/vendor/autoload.php');

use App\Connect;

$db = new Connect();
$dbcon = $db->ConnectDB();
$sth = $dbcon->query("SELECT * FROM tb_users where email_user = '{$_COOKIE['login']}'");
$user = $sth->fetch();
$sth = $dbcon->query("SELECT * FROM tb_pets where id_owner = '{$user['id_user']}'");
$pets = $sth->fetchAll();
$sth = $dbcon->query("SELECT * FROM tb_photos");
$photos = $sth->fetchAll();
foreach($photos as $id => $photo) {
  $photos_pets[$photo['id_pet']] = $photo['blob_photo'];
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
    <title>Meus pets</title>
    <style>
        .error-img {
           width: 100%;
           height: 160px;
           margin: 0 auto;        
        }

        @media only screen and (max-width: 675px) {
       
        .btn-add-pet {
            text-align: center;
        }

        .btn-success {
            width: 90%;
        }

      .main-card {
        width: 100% !important;
      }

    }        

    @media only screen and (max-width: 465px) {
      .main-card {
        width: 100% !important;
      }

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
        <div class="collapse text-center" id="navbarMenuOptions"><!--Opções de navegação do Menu de Navegação-->
          <div class="bg-dark p-4">
            <ul class="navbar-nav text-white">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="./Main.php">Menu principal</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="#">Meu perfil</a>
              </li>
              <li class="nav-item">
                <button class="btn btn-danger" style="width: 60%;">Sair</button>
              </li>
            </ul>
          </div>
        </div><!--Opções de navegação do Menu de Navegação-->
        <div class="btn-add-pet container-fluid mt-4 mb-4" style="width: 100%;">
            <a href="./Main.php" class="btn btn-outline-secondary mt-4 mb-2">Voltar</a>
            <a href="./EditPet.php" class="btn btn-success mt-4 mb-2">Cadastrar Pet</a>
        </div>
        <div class="container mt-4 mb-4 col-sm-12 col-md-12 h-50 d-flex m-auto justify-content-center align-self-center" style="width: 80%;"><!--Container principal-->
        <div class="row">
        <?php foreach ($pets as $pet) { 
          $sth = $dbcon->query("SELECT name_race FROM aux_race_pets where id_race = '{$pet['race_pet']}'");
          $race_pet = $sth->fetch();
        ?>
            <div class="main-card col p-1 d-flex">  
                <div class="card mx-auto" style="width: 18rem; height: 25rem;">
                    <div class="bg-dark rounded-top" style="max-height: 160px;">
                    <img src="<?= isset($photos_pets[$pet['id_pet']])?'data:image/jpeg;base64,'.$photos_pets[$pet['id_pet']]:'...'?>" class="card-img-top img-fluid" style="max-height:160px" onerror="this.src='src/assets/no_image.jpg';this.className='error-img';">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title mt-3"><?=$pet['name_pet']?></h5>
                        <p class="card-text mt-3">Nascimento: <?=$pet['birth_pet']?></p>
                        <p class="card-text mt-3">Raça: <?=$race_pet['name_race']?></p>
                        <a href="./EditPet.php?id=<?= $pet['id_pet']?>" class="btn btn-primary mt-3">Visualizar</a>
                    </div>
                </div>
            </div>
        <?php } ?>
          </div>
        </div><!--Container principal-->
<script src="./src/js/bootstrap.bundle.min.js"></script>    
</body>
</html>

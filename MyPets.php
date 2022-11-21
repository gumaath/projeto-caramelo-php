<?php
include($_SERVER['DOCUMENT_ROOT'] . '/projeto-caramelo-php/vendor/autoload.php');

use App\Connect;
use App\Auth;
use App\Functions;

Auth::verificaSessionLogin();

$db = new Connect();
$dbcon = $db->ConnectDB();
$_functions = new Functions($dbcon);
$_user = $_functions::getUser();
$pets = $_functions::getAllPetsOwner($_user);
$photos = $_functions::getAllPetsPhotosOwner($_user);
if ($photos) {
  foreach ($photos as $id => $photo) {
    $photos_pets[$photo['id_pet']] = $photo['blob_photo'];
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
  <link href="src/css/alertify.css" rel="stylesheet" />
  <link href="src/css/themes/bootstrap.css" rel="stylesheet" />
  <link rel="stylesheet" href="src/css/style.css">
  <title>Meus pets</title>
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
    <a href="./EditPet.php" class="btn btn-success mt-4 mb-2">Cadastrar Pet</a>
  </div>
  <div class="container mt-4 mb-4 col-sm-12 col-md-12 h-50 d-flex m-auto justify-content-center align-self-center" style="width: 80%;">
    <!--Container principal-->
    <div class="row">
      <?php if ($pets) {
        foreach ($pets as $pet) {
          $sth = $dbcon->query("SELECT name_race FROM aux_race_pets where id_race = '{$pet['race_pet']}'");
          $race_pet = $sth->fetch();
      ?>
          <div class="main-card col p-1 d-flex">
            <div class="card mx-auto" style="width: 18rem; height: 27rem;">
              <div class="bg-dark rounded-top" style="max-height: 160px;">
                <img src="<?= isset($photos_pets[$pet['id_pet']]) ? 'data:image/jpeg;base64,' . $photos_pets[$pet['id_pet']] : '...' ?>" class="card-img-top img-fluid" style="max-height:160px" onerror="this.src='src/assets/no_image.jpg';this.className='error-img';">
              </div>
              <div class="card-body">
                <h5 class="card-title mt-3"><?= $pet['name_pet'] ?></h5>
                <p class="card-text mt-3">Nascimento: <?= $pet['birth_pet'] ?></p>
                <p class="card-text mt-3">Raça: <?= $race_pet['name_race'] ?></p>
                <a href="./EditPet.php?id=<?= $pet['id_pet'] ?>" class="btn btn-primary mt-3">Visualizar</a>
                <button type="button" class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#ModalCodigo<?=$pet['name_pet']?>">Código Único</button>
              </div>
            </div>
          </div>
          <!-- Modal -->
          <div class="modal fade" id="ModalCodigo<?=$pet['name_pet']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Código única para <?=$pet['name_pet']?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body<?=$pet['id_pet']?>">
                  <button type="button" class="btn btn-success" onclick="gerarCodigo(<?=$pet['id_pet']?>) "id="codigo-unico-<?=$pet['id_pet']?>">Gerar código único</button>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                  <button type="button" class="btn btn-success" onclick="copiarValor(<?=$pet['id_pet']?>)" id="copiar<?=$pet['id_pet']?>" data-bs-dismiss="modal" disabled>Copiar</button>
                </div>
              </div>
            </div>
          </div>
        <?php }
      } else { ?>
        <div>Você não tem nenhum pet cadastrado.</div>
      <?php } ?>
    </div>
  </div>
  <!--Container principal-->
  <script src="./src/js/bootstrap.bundle.min.js"></script>
  <script src="./src/js/scripts.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="./src/js/script-unique-access.js"></script>
  <script src="./src/js/alertify.js"></script>
  <script>
    function copiarValor(id_pet) {
      var codigo = $('#copiar'+id_pet).attr("valor");
      navigator.clipboard.writeText(codigo);
      alertify.success('Código copiado! (Está no seu CTRL+V)');
    }
  </script>
</body>

</html>
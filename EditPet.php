<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/projeto-caramelo-php/vendor/autoload.php');

use App\Functions;
use App\Connect;
use App\Auth;

if (Auth::verificaSessionLogin() == false) {
  echo "<script>alert('Faça login novamente!');window.location.href = './login.php';</script>";
}

$race_pet = Functions::loadRacePet();
$type_pet = Functions::loadTypePet();

// Post
if (isset($_POST['Save']) && !isset($_GET['id']) && $_REQUEST) {
  Functions::cadastrarPet(
    $_POST['name'],
    $_POST['gender'],
    (int)$_POST['weight'],
    (int)$_POST['type'],
    (int)$_POST['race'],
    $_POST['birth'],
    Functions::getIdUser()
  );

  echo "<script>alert('Pet cadastrado com sucesso!');window.location.href = './MyPets.php';</script>";
  // Get
} elseif (isset($_POST['Save']) && isset($_GET['id'])) {
  Functions::atualizarPet(
    $_GET['id'],
    $_POST['name'],
    $_POST['gender'],
    (int)$_POST['weight'],
    (int)$_POST['type'],
    (int)$_POST['race'],
    $_POST['birth'],
    Functions::getIdUser()
  );

  echo "<script>alert('Pet atualizado com sucesso!');window.location.href = './MyPets.php';</script>";
} elseif (isset($_POST['Remover']) && isset($_GET['id'])) {
  Functions::removerPet($_GET['id']);
  echo "<script>alert('Pet deletado com sucesso');window.location.href = './MyPets.php';</script>";
}

if ($_REQUEST) {
  if (isset($_GET['id']))
    $_pet_id = $_GET['id'];
  else {

    $db = new Connect();
    $dbcon = $db->ConnectDB();
    $query = $dbcon->query("SELECT MAX(id_pet) as id_pet FROM tb_pets;");
    $_pet_id = $query->fetch();
    $_pet_id = $_pet_id['id_pet'];
  }
}

if (@$_FILES['photo']['tmp_name']) {
  if (!isset($db)) {
    $db = new Connect();
    $dbcon = $db->ConnectDB();
  }
  $tipo_arquivo = explode('/', $_FILES['photo']['type']);
  $tipo_arquivo = $tipo_arquivo[0];
  if ($tipo_arquivo != 'image') {
    echo "<script>alert('A imagem deve ser uma imagem!');</script>";
  } else {
    $arquivo = $_FILES["photo"]["tmp_name"];
    $tamanho = $_FILES["photo"]["size"];
    $tipo = $_FILES["photo"]["type"];
    $nome = $_FILES["photo"]["name"];
    $fp = fopen($arquivo, "rb");
    $conteudo = fread($fp, $tamanho);
    $conteudo = imagecreatefromstring($conteudo);
    if ($tamanho > 1000000)
      $conteudo = imagescale($conteudo, '500', '500');
    fclose($fp);
    ob_start();
    imagepng($conteudo);
    $conteudo = ob_get_contents();
    ob_end_clean();
    $_imgType = $tipo;
    $_imgData = base64_encode($conteudo);
    $sth = $dbcon->query("DELETE FROM tb_photos WHERE id_pet = {$_pet_id};");
    $sth = $dbcon->query("INSERT INTO tb_photos VALUES(null, '{$_imgData}', '{$_imgType}', {$_pet_id});");
  }
}

// Get
if (isset($_GET['id'])) {
  $db = new Connect();
  $dbcon = $db->ConnectDB();

  $sth = $dbcon->query("SELECT * FROM tb_pets WHERE id_pet = {$_GET['id']} ");
  $pet = $sth->fetch();

  $sth = $dbcon->query("SELECT * FROM tb_photos WHERE id_pet = {$_GET['id']} ");
  $photo = $sth->fetch();
  if ($photo)
    $photos = $photo['blob_photo'];
}

// Select Option Race
$_races = Functions::getSelectOption('aux_race_pets', 'race');

// Select Option Types
$_types = Functions::getSelectOption('aux_type_pets', 'type');

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="src/css/bootstrap.css" rel="stylesheet" />
  <link href="src/css/bootstrap-theme.css" rel="stylesheet" />
  link
  <title>Editar Pet</title>
  <style>
    .input-group-header {
      border-bottom-left-radius: 0 !important;
      border-bottom-right-radius: 0 !important;
    }

    .input-group-options {
      border-top-left-radius: 0 !important;
      border-top-right-radius: 0 !important;
      width: 33.33333%;
    }

    @media only screen and (min-width: 630px) {
      .error-img {
        width: 17em !important;
      }
    }

    @media only screen and (max-width: 805px) {
      .main-wrapper {
        width: 80% !important;
      }
    }

    @media only screen and (max-width: 465px) {
      .main-wrapper img {
        object-fit: fill !important;
      }

      .main-wrapper {
        width: 100% !important;
      }

    }

    .error-img {
      height: 100%;
    }


    .img-wrapper img {
      width: 100% !important;
      object-fit: cover;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    input[type=number] {
      -moz-appearance: textfield;
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
  <div class="main-wrapper container mt-4 mb-5" style="width: 52%;">
    <form method="POST" enctype=multipart/form-data>
      <a href="./MyPets.php" class="btn btn-outline-secondary mb-4">Voltar</a>
      <div class="card">
        <div class="bg-dark rounded-top img-wrapper" style="height: 18em;">
          <?php if (isset($_GET['id'])) { ?>
            <img src="data:image/jpeg;base64,<?php echo $photos ?>" style="height:100%" class="card-img-top img-fluid" onerror="this.src='src/assets/no_image.jpg';this.className='error-img';">
          <?php } else { ?>
            <img class="card-img-top img-fluid" style="height:100%" src="src/assets/no_image.jpg">
          <?php } ?>
        </div>
        <div class="card-body">
          <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Nome</span>
            <input type="text" class="form-control" aria-describedby="inputGroup-sizing-sm" name="name" required value="<?php if (isset($pet)) echo $pet['name_pet']; ?>">
          </div>
          <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Peso</span>
            <input type="number" min="0" step="0.1" class="form-control" placeholder="Kg" aria-describedby="inputGroup-sizing-sm" name="weight" required value="<?php if (isset($pet)) echo $pet['weight_pet']; ?>">
          </div>
          <div class="input-group input-group-sm mb-3">
            <label class="input-group-text" for="inputGroupSelect01">Sexo</label>
            <select class="form-select" id="inputGroupSelect02" name="gender" required>
              <option disabled value="" <?= !isset($pet['type_pet']) ? ' selected' : '' ?>>Selecione...</option>
              <option <?= (isset($pet) && $pet['gender_pet'] == "M") ? "selected" : ""; ?> value="M">Macho</option>
              <option <?= (isset($pet) && $pet['gender_pet'] == "F") ? "selected" : ""; ?> value="F">Fêmea</option>
              <option <?= (isset($pet) && $pet['gender_pet'] == "NE") ? "selected" : ""; ?> value="NE">Não específicado</option>
            </select>
          </div>
          <div class="input-group  input-group-sm mb-3">
            <label class="input-group-text" for="inputGroupSelect01">Espécie</label>
            <select class="form-select" id="inputGroupSelect02" name="type" required>
              <option disabled value="" <?= !isset($pet['race_pet']) ? ' selected' : '' ?>>Selecione...</option>
              <?php
              foreach ($_types as $_id => $_type) { ?>
                <option value="<?= $_id ?>" <?= ($_id == @$pet['type_pet']) ? 'selected' : '' ?>><?= $_type ?></option>
              <?php }
              ?>
            </select>
          </div>
          <div class="input-group  input-group-sm mb-3">
            <label class="input-group-text" for="inputGroupSelect01">Raça</label>
            <select class="form-select" id="inputGroupSelect02" name="race" required>
              <option disabled value="" <?= !isset($pet['race_pet']) ? ' selected' : '' ?>>Selecione...</option>
              <?php
              foreach ($_races as $_id => $_race) { ?>
                <option value="<?= $_id ?>" <?= ($_id == @$pet['race_pet']) ? 'selected' : '' ?>><?= $_race ?></option>
              <?php }
              ?>
            </select>
          </div>
          <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Data de nascimento</span>
            <input type="date" class="form-control" aria-describedby="inputGroup-sizing-sm" name="birth" value="<?php if (isset($pet)) echo $pet['birth_pet']; ?>">
          </div>
          <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Foto</span>
            <input type="file" class="form-control" accept="image/*" aria-describedby="inputGroup-sizing-sm" name="photo" value="<?php if (isset($pet)) echo $pet['photo_id']; ?>">
          </div>
          <input type="submit" name="Save" class="btn btn-success" value="Salvar"></input>
          <?php if (isset($_GET['id'])) { ?>
            <input type="submit" name="Remover" class="btn btn-danger" value="Remover"></input>
          <?php } ?>
        </div>
      </div>
    </form>
    <script src="./src/js/bootstrap.bundle.min.js"></script>
    <script src="./src/js/scripts.js"></script>
</body>

</html>
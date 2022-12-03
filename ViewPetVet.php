<?php
include($_SERVER['DOCUMENT_ROOT'] . '/projeto-caramelo-php/vendor/autoload.php');

use App\Auth;
use App\Functions;
use App\Connect;

Auth::verificaSessionLogin();

$db = new Connect();
$dbcon = $db->ConnectDB();
$_functions = new Functions($dbcon);

$race_pet = $_functions::loadRacePets();
$type_pet = $_functions::loadTypePets();

$pet = $_functions::getPet($_GET['id']);
$data_vaccines = Functions::returnVaccineData($pet['id_pet']);
$user = $_functions ::getUser();

if ($user) 
$vet = $_functions::getVet($user);

if($_POST) {
  $_ultimoid = $_functions::cadastrarVacina($_POST);
if (@$_FILES['photo']['tmp_name']) 
  $_functions::UpdateUploadAttachment($_FILES, $pet['id_pet'], 'vaccine', $_ultimoid);
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
                    <a class="nav-link" aria-current="page" href="#">Meu perfil</a>
                </li>
                <li class="nav-item">
                    <button class="btn btn-danger" onclick="logoutUser()">Sair</button>
                </li>
            </ul>
        </div>
    </div>
    <div class="btn-add-pet container-fluid mt-4 mb-4" style="width: 100%;">
        <a href="./Main.php" class="btn btn-outline-secondary mt-4 mb-2">Voltar</a>
    </div>
    <div class="result container my-4" style="width: 80%;">
    <h3>Dados do Pet: <?=$pet['name_pet']?></h3>
    </div>
    <div class="result container my-4" style="width: 80%;">
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#vaccines" type="button" role="tab" aria-controls="vaccines" aria-selected="true">Vacinas</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#prescriptions" type="button" role="tab" aria-controls="prescriptions" aria-selected="false">Prescrições</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#medicates" type="button" role="tab" aria-controls="medicates" aria-selected="false">Medicamentos</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#exams" type="button" role="tab" aria-controls="exams" aria-selected="false">Exames</button>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="vaccines" role="tabpanel" aria-labelledby="vaccines-tab">
  <div class="btn-add-pet container-fluid mt-4 mb-4" style="width: 100%;">
    <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#FormModalVaccine">Cadastrar nova Vacina</button>
  </div>
    <div class="container mt-4 " style="width: 80%;">
    <form method="POST">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Nome da vacina</span>
                <input type="text" class="form-control" name="vaccine">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Data de aplicação</span>
                <input type="date" class="form-control" name="date">
            </div>
    </div>
    <!--Container filtros-->
    <div class="container d-flex justify-content-end mt-2" style="width: 80%;">
        <!--Container que segura os buttons-->
        <button type="submit" class="btn btn-primary mx-2">Filtrar</button>
    </div>
    </form>
<?php foreach($data_vaccines as $_data)  { ?>
    <div class="result container my-4" style="width: 80%;">        
        <div class="card">
            <div class="card-header"><?= $_data['vacina']?></div>
            <div class="card-body">
                <p class="card-text">Pet:  <?= $_data['pet'] ?></p>
                <p class="card-text">Descrição: <?= $_data['descricao'] ?></p>
                <span class="card-text">Data de aplicação:</span>
                <span class="text-muted d-inline"><?= Functions::formatDate($_data['data_aplicacao']) ?></span>
                <p class="mt-3">Veterinário responsável: <?= $_data['vet'] ?></p>
                <button data-bs-toggle="collapse" class="btn btn-primary d-block mt-3" data-bs-target="#attachmentId<?= $_data['id_pet'].$_data['id_vacina']?>">Ver anexo</button>
                <div id="attachmentId<?= $_data['id_pet'].$_data['id_vacina']?>" class="collapse mt-2 border">
                    <img class="zoom" src="<?= './src/assets/attachments/' . $_data['id_pet'] . '/vaccines/' . $_data['url'] ?>" alt="Anexo não localizado" width="100%" height="120">
                </div>
            </div>
</div>
  </div>
<?php } ?>
        <div class="modal fade FormModal" id="FormModalVaccine" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
              <h5 class="modal-title">Cadastrar nova vacina para <?=$pet['name_pet']?></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="" id="FormVaccine" method="post" enctype="multipart/form-data">
                <input type="hidden" id="id_pet" name="id_pet" value="<?=$pet['id_pet']?>" required>
                <input type="hidden" id="id_vet" name="id_vet" value="<?=$vet['id_vet']?>" required>
                  <div class="mb-3">
                    <input type="text" class="form-control" id="formNome" name="formNome" placeholder="Nome da vacina" required>
                  </div>
                  <div class="mb-3">
                    <input type="email" class="form-control" id="formDesc" name="formDesc" placeholder="Descrição" required>
                  </div>
                  <div class="form-group row mb-3">
                    <label for="inputEmail3" class="col-5 col-form-label">Data da aplicação</label>
                    <div class="col-7">
                      <input id="startDate" required class="form-control" type="date" name="DateApplication" max="<?= date("Y-m-d") ?>" />
                    </div>
                  </div>
          <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Anexo</span>
            <input type="file" class="form-control" accept="image/*" aria-describedby="inputGroup-sizing-sm" name="photo">
          </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" id="botao" name="botao" class="btn btn-primary">Enviar</button>
              </div>
            </div>
          </div>
        </div>
</div>
  <div class="tab-pane fade" id="prescriptions" role="tabpanel" aria-labelledby="prescriptions-tab">
    <div class="container mt-4 " style="width: 80%;">
    <form method="POST">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Nome da prescrição</span>
                <input type="text" class="form-control" name="vaccine">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Data de emissão</span>
                <input type="date" class="form-control" name="date">
            </div>
    </div>
    <!--Container filtros-->
    <div class="container d-flex justify-content-end mt-2" style="width: 80%;">
        <!--Container que segura os buttons-->
        <button type="submit" class="btn btn-primary mx-2">Filtrar</button>
    </div>
    </form>
  </div>
  <div class="tab-pane fade" id="medicates" role="tabpanel" aria-labelledby="medicates-tab">
    <div class="container mt-4 " style="width: 80%;">
    <form method="POST">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Nome do medicamento</span>
                <input type="text" class="form-control" name="vaccine">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Data da receita</span>
                <input type="date" class="form-control" name="date">
            </div>
    </div>
    <!--Container filtros-->
    <div class="container d-flex justify-content-end mt-2" style="width: 80%;">
        <!--Container que segura os buttons-->
        <button type="submit" class="btn btn-primary mx-2">Filtrar</button>
    </div>
    </form>
  </div>
  <div>
  <div class="tab-pane fade" id="exams" role="tabpanel" aria-labelledby="exams-tab">
    <div class="container mt-4 " style="width: 80%;">
    <form method="POST">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Nome do exame</span>
                <input type="text" class="form-control" name="vaccine">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Data</span>
                <input type="date" class="form-control" name="date">
            </div>
    </div>
    <!--Container filtros-->
    <div class="container d-flex justify-content-end mt-2" style="width: 80%;">
        <!--Container que segura os buttons-->
        <button type="submit" class="btn btn-primary mx-2">Filtrar</button>
    </div>
    </form>
  </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/medium-zoom@1.0.6/dist/medium-zoom.min.js"></script>
    <script src="./src/js/bootstrap.bundle.min.js"></script>
    <script src="./src/js/scripts.js"></script>   
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="./src/js/bootstrap.bundle.min.js"></script>
  <script src="./src/js/jquery.mask.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

    <script>
      $('#FormModalVaccine #botao').click(function(e) {
        $('#FormVaccine').submit();
      });

        mediumZoom('.zoom', {
            margin: 50
        })
    </script>
</body>

</html>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/projeto-caramelo-php/vendor/autoload.php');

use App\Functions;
use App\Connect;

$db = new Connect();
$dbcon = $db->ConnectDB();
$_functions = new Functions($dbcon);

if ($_REQUEST)
  $_email_usado = $_functions::validarEmail($_POST['formEmailVolunteer'], true);
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Anamne Pet</title>
  <link href="./src/css/bootstrap.css" rel="stylesheet">
  <link href="./src/css/style.css" rel="stylesheet">
  <script src="./src/js/scripts.js"></script>
</head>

<body>
  <?= @$_email_usado['html'] ? $_email_usado['html'] : '' ?>
  <header class="p-3 mb-3 border-bottom text-bg-dark">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
          <img src="./src/assets/logominha.png" alt="" style="width: 150px;">
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="#" class="nav-link px-2 text-secondary">Início</a></li>
          <li><a href="#" class="nav-link px-2 text-white">Empresas parceiras</a></li>
          <li><a href="#" class="nav-link px-2 text-white">Sobre</a></li>
          <li><a href="#" class="nav-link px-2 text-white">Fale conosco</a></li>
        </ul>

        <div class="nav col-12 col-lg-auto mb-2 justify-content-center mb-md-0">
          <a href="./login.php"><button type="button" class="btn btn-outline-primary m-1">Fazer login</button></a>
          <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#FormModal" onclick="masksForm()">Cadastre-se</button>
        </div>
        <!--- Modal --->
        <div class="modal fade FormModal" id="FormModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Cadastrar-se</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="" id="FormVolunteer" method="post" novalidate>
                  <div class="row mb-3">
                    <div class="col">
                      <div class="form-check">
                        <input class="form-check-input" onclick="habilitarCMRV()" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                        <label class="form-check-label" for="flexRadioDefault1">
                          Para tutor
                        </label>
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-check">
                        <input class="form-check-input" onclick="habilitarCMRV()" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                        <label class="form-check-label" for="flexRadioDefault2">
                          Para veterinário
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="mb-3">
                    <input type="text" class="form-control" id="formNomeVolunteer" name="formNomeVolunteer" placeholder="Nome" required>
                  </div>
                  <div class="mb-3">
                    <select class="form-select" id="gender" aria-label="Letra sangue" name="gender" required>
                      <option selected value disabled>Gênero</option>
                      <option value="M">Masculino</option>
                      <option value="F">Feminino</option>
                      <option value="NE">Não Especificado</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <input type="email" class="form-control" id="formEmailVolunteer" name="formEmailVolunteer" placeholder="Email" required>
                  </div>
                  <div class="mb-3">
                    <input type="password" class="form-control" id="formPassVolunteer" name="formPassVolunteer" placeholder="Senha" required>
                  </div>
                  <div class="mb-3" id="campocmrv" style="display:none">
                    <input type="text" class="form-control" id="formCMRVVolunteer" name="formCMRVVolunteer" placeholder="CMRV" required>
                  </div>
                  <div class="mb-3">
                    <input type="text" class="form-control" id="formCPFVolunteer" name="formCPFVolunteer" placeholder="CPF" required>
                  </div>
                  <div class="mb-3">
                    <input type="text" class="form-control" id="formRGVolunteer" name="formRGVolunteer" placeholder="RG" required>
                  </div>
                  <div class="mb-3">
                    <input type="text" class="form-control" id="formTelVolunteer" name="formTelVolunteer" placeholder="Telefone" required>
                  </div>
                  <div class="form-group row mb-3">
                    <label for="inputEmail3" class="col-5 col-form-label">Data de nascimento</label>
                    <div class="col-7">
                      <input id="startDate" required class="form-control" type="date" name="BirthDateVolunteer" max="<?= date("Y-m-d") ?>" />
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" id="botaoVolunteer" name="botaoVolunteer" onclick="validarFormVoluntario()" class="btn btn-primary">Enviar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="./src/js/bootstrap.bundle.min.js"></script>
  <script src="./src/js/jquery.mask.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

</body>

</html>
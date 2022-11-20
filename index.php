<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/projeto-caramelo-php/vendor/autoload.php');

use App\Connect;

if ($_REQUEST) {
  $db = new Connect();
  $dbcon = $db->ConnectDB();
  $query = $dbcon->query("SELECT email_user FROM tb_users WHERE email_user = '{$_POST['formEmailVolunteer']}'");
  $_email_usado = $query->fetch();
  if (!empty($_email_usado)) {
    $_email_usado = true;
  } else {
    $_email_usado = false;
  }
}
?>
<?php if ($_REQUEST && (int)@$_email_usado) { ?>
  <div class="alert alert-danger" role="alert" style="border-radius: 0; margin: 0;">
    O e-mail que tentou cadastrar já está em uso.
  </div>
<?php } elseif ($_REQUEST) { ?>
  <div class="alert alert-success" role="alert" style="border-radius: 0; margin: 0;">
    Sua conta foi criada com sucesso! Você já pode acessa-lá!
  </div>
<?php } ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Anamne Pet</title>
  <link href="./src/css/bootstrap.css" rel="stylesheet">
</head>
<style>
  .modal-title,
  .col p,
  .form-check label,
  .col-form-label {
    color: black !important;
  }

  div.is-invalid {
    top: 100%;
    z-index: 5;
    display: inline;
    max-width: 100%;
    padding: 0.25rem 0.5rem;
    margin-top: 0.1rem;
    font-size: 0.875rem;
    color: #fff;
    background-color: rgba(220, 53, 69, 0.9);
    border-radius: 0.25rem;
  }

  .form-control.is-invalid {
    margin-bottom: 2px;
  }
</style>

<body>
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
          <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#FormModal">Cadastre-se</button>
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
  <script>
    // Máscara para CPF, Telefone e RG.
    $(document).ready(function() {
      $('#formCPFVolunteer').mask('000.000.000-00', {
        reverse: true
      });
      $('#formRGVolunteer').mask('00.000.000.000-0', {
        reverse: true
      });
      $('#formTelVolunteer').mask('(00) 00000-0000', {
        reverse: false
      });
    });

    function habilitarCMRV() {
      if ($('#flexRadioDefault1').is(':checked')) {
        $('#campocmrv').hide();
      } else {
        $('#campocmrv').show();
      }
    }


    $.validator.addMethod("minAge", function(value, element, min) {
      var today = new Date();
      var birthDate = new Date(value);
      var age = today.getFullYear() - birthDate.getFullYear();

      if (age > min + 1) {
        return true;
      }

      var m = today.getMonth() - birthDate.getMonth();

      if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
      }
      return age >= min;
    }, "Você não tem idade!");

    function validarFormVoluntario() {
      if ($('#flexRadioDefault1').is(':checked')) {
        idade_minima = 14
      } else {
        idade_minima = 18
      }

      $('#FormVolunteer').removeData('validator')

      if ($('#FormVolunteer').validate({
          focusInvalid: true,
          onfocusout: false,
          invalidHandler: function(form, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {
              validator.errorList[0].element.focus();
            }
          },
          errorClass: "is-invalid",
          errorElement: 'div',
          rules: {
            formNomeVolunteer: {
              required: true,
              minlength: 5
            },
            formSobrenomeVolunteer: {
              required: true,
              minlength: 5
            },
            formEmailVolunteer: {
              required: true,
              minlength: 10
            },
            formCPFVolunteer: {
              required: true,

              minlength: 11
            },
            formRGVolunteer: {
              required: true,
              minlength: 10
            },
            formTelVolunteer: {
              required: true,
              minlength: 11
            },
            BirthDateVolunteer: {
              required: true,
              minAge: idade_minima
            },
            formEstadoVolunteer: {
              required: true
            },
          },
          messages: {
            formNomeVolunteer: {
              required: "Por favor, insira seu nome!",
              minlength: "Seu nome tem que ser maior!"
            },
            formSobrenomeVolunteer: {
              required: "Por favor, insira seu sobrenome!",
              minlength: "Seu nome tem que ser maior!"
            },
            formPassVolunteer: {
              required: "Por favor, insira uma senha!",
              minlength: "Seu senha tem que ser maior!"
            },
            gender: {
              required: "Por favor, insira um gênero!",
            },
            formEmailVolunteer: {
              required: "Por favor, insira seu email!",
              minlength: "Seu email está incompleto!",
              email: "Este não é um endereço de email válido!"
            },
            formCPFVolunteer: {
              required: "Por favor, insira seu CPF!",
              minlength: "Seu CPF está incompleto!",
              number: "Coloque apenas números!"
            },
            formRGVolunteer: {
              required: "Por favor, insira seu RG!",
              minlength: "Seu RG está incompleto!",
              number: "Coloque apenas números!"
            },
            formTelVolunteer: {
              required: "Por favor, insira seu número de celular!",
              minlength: "Seu celular está incompleto!",
              number: "Coloque apenas números!"
            },
            BirthDateVolunteer: {
              required: "Por favor, insira sua data de nascimento!",
              max: "Por favor, coloque uma data de nascimento menor que a data de hoje!",
              minAge: "Por favor, você tem que ter pelo menos " + idade_minima + " anos"
            },
          },
        })); {
        if ($('#FormVolunteer').valid()) {
          $('#FormVolunteer').submit();
        }
      };
    };
  </script>
</body>

</html>
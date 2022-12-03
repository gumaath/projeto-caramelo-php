<?php
include($_SERVER['DOCUMENT_ROOT'] . '/projeto-caramelo-php/vendor/autoload.php');

use App\Functions;
use App\Connect;
use App\Auth;

$db = new Connect();
$dbcon = $db->ConnectDB();
$_functions = new Functions($dbcon);

Auth::verificaSessionLogin();

$user = $_functions ::getUser();
$pets = $_functions::getAllPetsOwner($user);

if($_REQUEST && @$_POST['Pesquisar']) {
    $data = Functions::returnVaccineData(@$_POST['id_pet'], @$_POST['vaccine'], @$_POST['date']);
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
    <form id="mainForm" method="post">
        <div class="container mt-4 " style="width: 80%;">
            <!--Container filtros-->
            <span class="text-muted">(Obrigatório)</span>
            <div class="input-group mb-3">
                <!--Dropdown-->
                <label class="input-group-text" for="inputGroupSelect01">Selecione um Pet</label>
                <select class="form-select" id="inputGroupSelect01" name="id_pet" required>
                    <option selected value="">Selecione...</option>
                    <?php 
                    foreach($pets as $_pet) { ?>
                        <option value="<?= $_pet['id_pet'] ?>" required><?= $_pet['name_pet']?></option>
                    <?php } ?>
                </select>
            </div>
            <!--Dropdown-->
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
            <input type="submit" name="Pesquisar" class="btn btn-primary mx-2" value="Pesquisar"></input>
            <input type="submit" class="btn btn-outline-secondary" name="Clear" value="Limpar filtros" onclick="clearFields()"></input>
        </div>
    </form>
    <!--Container que contem os buttons-->
    
    <?php if(isset($data) && $data != null) { ?>
        <div class="result container my-4" style="width: 80%;">        
            <h2>Resultados:</h2>
            <hr>
        </div>
    <?php
        foreach($data as $_data)  {
    ?>
    <div class="result container my-4" style="width: 80%;">        
        <div class="card">
            <div class="card-header"><?= $_data['vacina']?></div>
            <div class="card-body">
                <p class="card-text">Pet:  <?= $_data['pet'] ?></p>
                <p class="card-text">Descrição: <?= $_data['descricao'] ?></p>
                <span class="card-text">Data de aplicação:</span>
                <span class="text-muted d-inline"><?= Functions::formatDate($_data['data_aplicacao']) ?></span>
                <p class="mt-3">Veterinário responsálvel: <?= $_data['vet'] ?></p>
                <button data-bs-toggle="collapse" class="btn btn-primary d-block mt-3" data-bs-target="#attachmentId<?= $_data['id_pet'].$_data['id_vacina']?>">Ver anexo</button>
                <div id="attachmentId<?= $_data['id_pet'].$_data['id_vacina']?>" class="collapse mt-2 border">
                    <img class="zoom" src="<?= $_data['url'] ?>" alt="Anexo não localizado" width="100%" height="120">
                </div>
            </div>
            <div class="card-footer">
                <a class="mx-2 contact-btn" href="tel:<?= $_data['fone'] ?>">
                    <img src="src/assets/phone-call.png" title="Ligar para o veterinário responsável" width="36" class="img-fluid" alt="phone-icon">
                </a>          
                <a target="_blank" id="lnk_wpp" class="mx-2 contact-btn" href="https://api.whatsapp.com/send?phone=55<?=Functions::formatWhatsApp($_data['fone'])?>">
                    <img src="src/assets/whatsapp.png" title="Abrir conversa no Whatsapp" width="38" class="img-fluid" alt="zapzap-icon">
                </a> 
            </div>
        </div>
    </div>
    <?php } } ?>
    <?php if(@$data == null && $_REQUEST && !@$_POST['Clear']) { ?>
        <div class="text-center container-fluid mt-5">
            <h4 class="mt-5">Não existem vacinas aplicadas com os parâmetros selecionados!</h4>
        </div>
    <?php } ?>
    <script src="https://cdn.jsdelivr.net/npm/medium-zoom@1.0.6/dist/medium-zoom.min.js"></script>
    <script src="./src/js/bootstrap.bundle.min.js"></script>
    <script src="./src/js/scripts.js"></script>
    <script>
        mediumZoom('.zoom', {
            margin: 50
        })

        function clearFields() {
            var form = document.getElementById("mainForm");
            form.reset();
        }        

    </script>
</body>

</html>
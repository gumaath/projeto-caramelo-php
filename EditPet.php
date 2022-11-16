<?php
  require_once($_SERVER['DOCUMENT_ROOT'] . '/projeto-caramelo-php/vendor/autoload.php');    

  use App\Functions;    
  use App\Connect;

    $race_pet = Functions::loadRacePet();
    $type_pet = Functions::loadTypePet();

    if(isset($_POST['Save']) && $_REQUEST) {     
      Functions::cadastrarPet($_POST['name'], $_POST['gender'], (int)$_POST['weight'], 
      (int)$_POST['type'], (int)$_POST['race'], $_POST['birth'], Functions::getIdUser());
      
      echo "<script>alert('Pet cadastrado com sucesso!');window.location.href = './MyPets.php';</script>";
    }

    if(isset($_GET['id'])) {
      $db = new Connect();
      $dbcon = $db->ConnectDB();

      $sth = $dbcon->query("SELECT * FROM tb_pets WHERE id_pet = {$_GET['id']} ");
      $pet = $sth->fetch();
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
    <title>Editar Pet</title>
    <style>

        @media only screen and (min-width: 630px) {
        .error-img {
            width: 17em !important;                   
            }
        }

        .error-img {
           width: 70%;
           height: 80%;
        }

        .img-wrapper {
            text-align: center;
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
        <div class="collapse" id="navbarMenuOptions"><!--Opções de navegação do Menu de Navegação-->
          <div class="bg-dark p-4">
            <ul class="navbar-nav text-white">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="./Main.php">Menu principal</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="#">Meu perfil</a>
              </li>
              <li class="nav-item"> 
                <button class="btn btn-danger">Sair</button>
              </li>
            </ul>
          </div>
        </div><!--Opções de navegação do Menu de Navegação-->
        <div class="container mt-4 mb-4" style="width: 80%;">
        <form method="POST" enctype=multipart/form-data>
        <a href="./MyPets.php" class="btn btn-outline-secondary mb-4">Voltar</a>
        <div class="card">
            <div class="bg-dark rounded-top img-wrapper">
                <img src="src/assets/chule.jpeg" class="card-img-top img-fluid" height="160" onerror="this.src='src/assets/logominha.png';this.className='error-img';">
            </div>  
              <div class="card-body">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Sexo</span>
                    <div class="input-group-text">
                      <input <?php if (isset($pet) && $pet['gender_pet']=="M") echo "checked"; ?> type="radio" value="M" name="gender" required>
                      <span class="mx-1">Macho</span>
                    </div>
                    <div class="input-group-text">
                      <input <?php if (isset($pet) && $pet['gender_pet']=="F") echo "checked"; ?> type="radio" value="F" name="gender">
                      <span class="mx-1">Fêmea</span>
                    </div>
                    <div class="input-group-text">
                      <input <?php if (isset($pet) && $pet['gender_pet']=="NE") echo "checked"; ?> type="radio" value="NE" name="gender">
                      <span class="mx-1">Não específicado</span>
                    </div>
                </div>
                  <div class="input-group input-group-sm mb-3">
                      <span class="input-group-text" id="inputGroup-sizing-sm">Nome</span>
                      <input type="text" class="form-control" aria-describedby="inputGroup-sizing-sm" name="name" required value="<?php if (isset($pet)) echo $pet['name_pet']; ?>">
                  </div>
                  <div class="input-group input-group-sm mb-3">
                      <span class="input-group-text" id="inputGroup-sizing-sm">Peso</span>
                      <input type="number" min="0" step="0.1" class="form-control" aria-describedby="inputGroup-sizing-sm" name="weight" required value="<?php if (isset($pet)) echo $pet['weight_pet']; ?>">
                  </div>
                  <div class="input-group  input-group-sm mb-3">
                      <label class="input-group-text" for="inputGroupSelect01">Tipo</label>
                      <select class="form-select" id="inputGroupSelect01" name="type" required>
                        <option disabled value="" selected>Selecione...</option>
                        <?php if(isset($pet)) { ?>
                          <option selected="<?= $pet['type_pet'] ?>" value="<?= $type_pet['id_type'] ?>"><?= $type_pet['name_type'] ?></option>
                        <?php } ?>
                        <option value="<?= $type_pet['id_type'] ?>"><?= $type_pet['name_type'] ?></option>
                      </select>
                  </div>
                  <div class="input-group  input-group-sm mb-3">
                      <label class="input-group-text" for="inputGroupSelect01">Raça</label>
                      <select class="form-select" id="inputGroupSelect02" name="race" required>
                        <option disabled value="" selected>Selecione...</option>
                        <?php if(isset($pet)) { ?>
                          <option selected="<?= $pet['race_pet'] ?>" value="<?= $race_pet['id_race'] ?>"><?= $race_pet['name_race'] ?></option>  
                        <?php } ?>
                        <option value="<?= $race_pet['id_race'] ?>"><?= $race_pet['name_race'] ?></option>
                      </select>
                  </div>
                  <div class="input-group input-group-sm mb-3">
                      <span class="input-group-text" id="inputGroup-sizing-sm">Data de nascimento</span>
                      <input type="date" class="form-control" aria-describedby="inputGroup-sizing-sm" name="birth" value="<?php if (isset($pet)) echo $pet['birth_pet']; ?>">
                    </div>
                    <div class="input-group input-group-sm mb-3">
                      <span class="input-group-text" id="inputGroup-sizing-sm" >Foto</span>
                      <input type="file" class="form-control" aria-describedby="inputGroup-sizing-sm" name="photo" value="<?php if (isset($pet)) echo $pet['photo_id']; ?>">
                    </div>
                    <input type="submit" name="Save" class="btn btn-success" value="Salvar"></input>
                    <input type="submit" class="btn btn-danger" value="Remover"></input>   
              </div>
          </div>
        </form>
<script src="./src/js/bootstrap.bundle.min.js"></script>    
</body>
</html>
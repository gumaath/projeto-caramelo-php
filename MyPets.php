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

        @media only screen and (max-width: 575px) {
        .card {
            margin: 0 18% !important;
            }
        
        .btn-add-pet {
            text-align: center;
        }

        .btn-success {
            width: 90%;
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
        <div class="collapse" id="navbarMenuOptions"><!--Opções de navegação do Menu de Navegação-->
          <div class="bg-dark p-4">
            <ul class="navbar-nav text-white">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="#">Menu principal</a>
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
        <div class="btn-add-pet container-fluid mt-4 mb-4" style="width: 100%;">
            <a href="./EditPet.php" class="btn btn-success m-4">Cadastrar Pet</a>
        </div>
        <div class="container mt-4 mb-4 col-sm-12 col-md-12 d-flex justify-content-center row" style="width: 80%;"><!--Container principal-->
            <!-- <button class="btn btn-success m-4">Adicionar novo Pet</button> -->
            <div class="col-md-8 col-sm-8 p-1">
                <div class="card mx-auto" style="width: 18rem; height: 24rem;">
                    <div class="bg-dark rounded-top">
                        <img src="src/assets/chule.jpeg" class="card-img-top img-fluid" height="160" onerror="this.src='src/assets/logominha.png';this.className='error-img';">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Chulé</h5>
                        <p class="card-text">4 anos</p>
                        <p class="card-text">Raça: SDR</p>
                        <p class="card-text">Cadastrado em: 06/11/2021</p>
                        <a href="#" class="btn btn-primary">Visualizar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 p-1">
                <div class="card mx-auto" style="width: 18rem; height: 24rem;">
                    <div class="bg-dark rounded-top">
                        <img src="..." class="card-img-top img-fluid" height="160" onerror="this.src='src/assets/logominha.png';this.className='error-img';">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Nome do pet</h5>
                        <p class="card-text">Idade</p>
                        <p class="card-text">Raça</p>
                        <p class="card-text">Data de cadastro</p>
                        <a href="#" class="btn btn-primary">Visualizar</a>
                    </div>
                </div>
            </div>
        </div><!--Container principal-->
<script src="./src/js/bootstrap.bundle.min.js"></script>    
</body>
</html>
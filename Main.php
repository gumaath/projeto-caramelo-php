<?php
include($_SERVER['DOCUMENT_ROOT'] . '/projeto-caramelo-php/vendor/autoload.php');

use App\Connect;
use App\Functions;
use App\Auth;

if (Auth::verificaSessionLogin() == false) {
  echo "<script>alert('Faça login novamente!');window.location.href = './login.php';</script>";
}

$db = new Connect();
$dbcon = $db->ConnectDB();

$news = Functions::getNews();

$stmt = $dbcon->query("SELECT 
                       name_user,
                       id_user,
                       role_user
                       FROM tb_users 
                       WHERE email_user = '{$_COOKIE['login']}'");

$user = $stmt->fetch();

if ($user) {
  $stmt = $dbcon->query("SELECT *
                                FROM tb_vets
                                WHERE id_user = '{$user['id_user']}'");
  $vet = $stmt->fetch();
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
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <title>Página inicial</title>
  <style>
    @media only screen and (max-width: 938px) {
      .arrow-img {
        display: none !important;
      }

      .card-text {
        text-overflow: ellipsis !important;
        white-space: nowrap;
        overflow: hidden;
      }
    }

    .card-menu a {
      text-decoration: none;
    }

    .card-text {
      text-overflow: "..." !important;
    }

    .card-menu-box .card:hover {
      -webkit-box-shadow: 0px 5px 11px -1px rgba(0, 0, 0, 0.75);
      -moz-box-shadow: 0px 5px 11px -1px rgba(0, 0, 0, 0.75);
      box-shadow: 0px 5px 11px -1px rgba(0, 0, 0, 0.75);
      transition: 0.2s !important;
    }

    .card-menu-box {
      max-width: 1280px;
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
    <div class="bg-dark p-4">
      <ul class="navbar-nav text-white">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="#">Menu principal</a>
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
  <div class="container mt-4" style="width: 80%;">
    <h2>Bem vindo, <?= $user['name_user'] ?>!</h2>
  </div>
  <div class="container mt-5 bg-dark rounded-1" id="carrosel" style="width: 80%; height: 19em; padding: 0 !important;">
    <div id="carouselAds" class="carousel slide" data-bs-ride="carousel" class="bg-dark">
      <div class="carousel-indicators">
        <?php foreach ($news as $_id => $new) { ?>
          <button type="button" data-bs-target="#carouselAds" data-bs-slide-to="<?= $_id ?>" class="<?= $_id === array_key_first($news) ? 'active' : '' ?> mt-5" aria-current="true" aria-label="Slide <?= $new['id_news'] ?>"></button>
        <?php } ?>
      </div>
      <div class="carousel-inner" style="max-height: 19em;">
        <?php foreach ($news as $_id => $new) { ?>
          <a href="./News.php?id=<?= $new['id_news'] ?>">
            <div class="carousel-item <?= $_id === array_key_first($news) ? 'active' : '' ?>">
              <img id="image-<?= $new['id_news'] ?>" data-src="<?= $new['news_url_photo'] ?>" src="./src/assets/loader.gif" class="img-fluid mx-auto mb-5 d-block rounded-1" style="max-height: 19em; width: inherit; object-fit: cover;">
            </div>
          </a>
        <?php } ?>
      </div>
      <button class="carousel-control-prev mt-5 visually-hidden" type="button" data-bs-target="#carouselAds" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next mt-5 visually-hidden" type="button" data-bs-target="#carouselAds" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
  <!--Meus Pets-->
  <div class="card-menu">
    <a href="./MyPets.php">
      <div class="container-fluid d-flex justify-content-center card-menu-box">
        <div class="card bg-dark text-white mt-5 mb-4" style="width: 80%; height: 8em;">
          <div class="card-body mt-3">
            <div class="row g-0">
              <div class="col-md-8 col-sm-8">
                <h5 class="card-title">Meus Pets</h5>
                <p class="card-text">Adicionar, remover, ou editar os pets associados ao meu usuário.</p>
              </div>
              <div class="d-inline d-flex justify-content-end arrow-img" style="width: 30%;">
                <img src="src/assets/chevron_right.png" class="img-fluid rounded-end">
              </div>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>
  <!--Prescrição nutricional-->
  <div class="card-menu">
    <a href="">
      <div class="container-fluid d-flex justify-content-center card-menu-box">
        <div class="card bg-dark text-white mt-1 mb-4" style="width: 80%; height: 8em;">
          <div class="card-body mt-3">
            <div class="row g-0">
              <div class="col-md-8 col-sm-8">
                <h5 class="card-title">Prescrição nutricional</h5>
                <p class="card-text">Histórico das prescrições receitadas para meu pet.</p>
              </div>
              <div class="d-inline d-flex justify-content-end arrow-img" style="width: 30%;">
                <img src="src/assets/chevron_right.png" class="img-fluid rounded-end">
              </div>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>
  <!--Vacinas-->
  <div class="card-menu">
    <a href="./Vaccines.php">
      <div class="container-fluid d-flex justify-content-center card-menu-box">
        <div class="card bg-dark text-white mt-1 mb-4" style="width: 80%; height: 8em;">
          <div class="card-body mt-3">
            <div class="row g-0">
              <div class="col-md-8 col-sm-8">
                <h5 class="card-title">Vacinas</h5>
                <p class="card-text">Vacinas aplicadas em meu pet.</p>
              </div>
              <div class="d-inline d-flex justify-content-end arrow-img" style="width: 30%;">
                <img src="src/assets/chevron_right.png" class="img-fluid rounded-end">
              </div>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>
  <!--Medicamentos-->
  <div class="card-menu">
    <a href="./Medicines.php">
      <div class="container-fluid d-flex justify-content-center card-menu-box">
        <div class="card bg-dark text-white mt-1 mb-4" style="width: 80%; height: 8em;">
          <div class="card-body mt-3">
            <div class="row g-0">
              <div class="col-md-8 col-sm-8">
                <h5 class="card-title">Medicamentos</h5>
                <p class="card-text">Medicamentos aplicados em meu pet.</p>
              </div>
              <div class="d-inline d-flex justify-content-end arrow-img" style="width: 30%;">
                <img src="src/assets/chevron_right.png" class="img-fluid rounded-end">
              </div>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>
  <!--Exames-->
  <div class="card-menu">
    <a href="./Exams.php">
      <div class="container-fluid d-flex justify-content-center card-menu-box">
        <div class="card bg-dark text-white mt-1 mb-4" style="width: 80%; height: 8em;">
          <div class="card-body mt-3">
            <div class="row g-0">
              <div class="col-md-8 col-sm-8">
                <h5 class="card-title">Exames</h5>
                <p class="card-text">Histórico de exames do meu pet.</p>
              </div>
              <div class="d-inline d-flex justify-content-end arrow-img" style="width: 30%;">
                <img src="src/assets/chevron_right.png" class="img-fluid rounded-end">
              </div>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>
  <script src="./src/js/bootstrap.bundle.min.js"></script>
  <script src="./src/js/scripts.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script>
    (function($) {
      $.fn.loadImage = function(src, cb, image) {
        var self = this,
          dataSrc = $(self).attr("data-src");

        image = image || new Image();
        cb = cb || function() {};

        if (typeof src === "undefined") {
          if (dataSrc.length) {
            src = dataSrc;
          } else {
            throw new Error("You must specify the data-src on the html element or pass an image src path to loadImage()");
          }
        }
        setTimeout(function() {
          if (image.src != src)
            image.src = src;
          if (!image.complete)
            return self.loadImage(src, cb, image);
          self.attr('src', src);
          cb.call(self);
        }, 50);
      };
    })(jQuery);
  </script>
  <script>
    $(document).ready(function() {
      <?php foreach ($news as $new) { ?>
        $("#image-<?= $new['id_news'] ?>").loadImage();
      <?php } ?>
    });
  </script>
</body>

</html>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/projeto-caramelo-php/vendor/autoload.php');

use App\Auth;

if ($_REQUEST) {
    try {
        $login = $_POST['loginEmail'];
        $auth = Auth::verificaLogin($_POST['loginEmail'], $_POST['loginPassword']);
        if ($auth)
            $session = Auth::createSession($_POST['loginEmail']);
        if ($auth && $session) {
            setcookie('login', $login, 0, '/');
            header("Location: ./Main.php");
        } else {
            echo "<script>alert('Usuário ou senha incorretos, tente novamente!')</script>";
        }
    } catch (Exception $th) {
        throw new Exception($th);
    }
    if ($auth) {
        Auth::verificaSessionLogin();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="./src/css/bootstrap.css" rel="stylesheet">
</head>

<body>
    <main class="container h-50 m-auto justify-content-center align-self-center">
        <div class="d-flex align-items-center justify-content-center mb-5">
            <img style="min-width: 120px; max-width: 150px;" src="./src/assets/logominha.png" alt="">
        </div>
        <div class="justify-content-center align-self-center">
            <div class="d-flex align-items-center justify-content-center mb-3">
                <h4>Faça login</h4>
            </div>
            <div class="d-flex align-items-center justify-content-center">
                <form method="POST">
                    <div class="mb-3" style="min-width: 300px;">
                        <input type="email" class="form-control" name="loginEmail" id="InputEmail" aria-describedby="emailHelp" placeholder="Endereço de e-mail">
                    </div>
                    <div class="mb-4" style="min-width: 300px;">
                        <input type="password" class="form-control" name="loginPassword" id="exampleInputPassword1" placeholder="Senha">
                        <a href="">
                            <div id="emailHelp" class="form-text">Esqueci minha senha</div>
                        </a>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="submit" class="btn btn-primary" style="padding: 5px 50px; margin-bottom: 90px;">Logar</button>
                    </div>
                </form>
            </div>
            <div class="d-flex align-items-center justify-content-center">
                <h6>Não possui conta?</h6>
            </div>
            <div class="d-flex align-items-center justify-content-center">
                <a href="./index.php">Cadastrar</a>
            </div>
        </div>
    </main>
</body>

</html>

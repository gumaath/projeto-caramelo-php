<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                <form>
                    <div class="mb-3" style="min-width: 300px;">
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Endereço de e-mail">
                    </div>
                    <div class="mb-4" style="min-width: 300px;">
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Senha">
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
                <a href="">Cadastrar</a>
            </div>
        </div>
    </main>
</body>

</html>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/projeto-caramelo-php/vendor/autoload.php');

use App\Connect;

if($_POST) {
    $db = new Connect();
    $dbcon = $db->ConnectDB();
    $_ja_existe_codigo = $dbcon->query("SELECT * FROM tb_unique_access WHERE id_pet = {$_POST['pet']}");
    if ($_ja_existe_codigo) {
        $dbcon->query("DELETE FROM tb_unique_access WHERE id_pet = {$_POST['pet']}");
    }
    $_access = $dbcon->query("INSERT INTO tb_unique_access VALUES(null,'{$_POST['codigo']}',{$_POST['pet']}, NOW())");

    $_retorno['status'] = 1;
    $_retorno['html'] = "<div>Código gerado: <b>{$_POST['codigo']}</b></div> <br><div>O veterinário tem 15 minutos para usá-lo. </div>";
    $_retorno = json_encode($_retorno);
    echo $_retorno;
}
?>
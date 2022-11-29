
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/projeto-caramelo-php/vendor/autoload.php');

use App\Connect;

if(@$_POST['pet']) {
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

function getPetByCode($code) {
    $db = new Connect();
    $dbcon = $db->ConnectDB();
    $sth = $dbcon->query("SELECT * FROM tb_unique_access WHERE code_access = '{$code}'");
    $sth_exists = $dbcon->query("SELECT EXISTS(SELECT 1 FROM tb_unique_access WHERE code_access = '{$code}')");

    if($sth_exists->fetchColumn()) {
        $_codigo = $sth->fetch();  
        date_default_timezone_set('America/Sao_Paulo');
        $agora = strtotime(date('Y-m-d H:i:s'));
        $codigo_tempo = strtotime($_codigo['time_expiration']);
        $tempo_expirado = $agora-$codigo_tempo;
        if ($tempo_expirado >= 900)
            $tempo_expirado = true;
        else 
            $tempo_expirado = false;
        if ($_codigo && !$tempo_expirado) {
            $sth = $dbcon->query("SELECT * FROM tb_pets WHERE id_pet = {$_codigo['id_pet']}");
            $_pet = $sth->fetch();
        }
        if (@$_pet)
            return $_pet;
    }
    
    return ;
}
?>
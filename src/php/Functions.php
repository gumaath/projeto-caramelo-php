<?php
namespace App; 

include ($_SERVER['DOCUMENT_ROOT'] . '/projeto-caramelo-php/vendor/autoload.php');

use App\Connect;

class Functions {
    public static function getUrlDocument() {
        $_url = explode(DIRECTORY_SEPARATOR,dirname(__FILE__));
        $_url = implode(DIRECTORY_SEPARATOR, array_slice($_url, 0, 5));
        return $_url;
    }

    public static function cadastrarPet($name, $gender, $weight, $type, $race, $birth, $id_owner, $photo = null) {
        $db = new Connect();
        $dbconect = $db->ConnectDB();

        $stmt = $dbconect->query("INSERT INTO tb_pets (name_pet, gender_pet, weight_pet, type_pet, race_pet, birth_pet, id_owner, photo_id, time_added)
                 VALUES ('{$name}','{$gender}', {$weight}, {$type}, {$race}, '{$birth}', {$id_owner},'{$photo}', NOW())");

        $result = $stmt->fetch();   
        
        return $result;
    } 

    public static function atualizarPet($id_pet, $name, $gender, $weight, $type, $race, $birth, $id_owner, $photo = null) {
        $db = new Connect();
        $dbconect = $db->ConnectDB();

        $stmt = $dbconect->query("UPDATE tb_pets SET name_pet = '{$name}', gender_pet = '{$gender}', weight_pet = {$weight}, type_pet = {$type}, race_pet = {$race}, birth_pet = '{$birth}', 
                                id_owner = {$id_owner}, photo_id = '{$photo}', time_added = NOW() WHERE id_pet = {$id_pet}"); 

        $result = $stmt->fetch();   
        
        return $result;
    } 

    public static function loadTypePet() {
        $db = new Connect();
        $dbconect = $db->ConnectDB();

        $stmt = $dbconect->query("SELECT * FROM aux_type_pets");                   
        $result = $stmt->fetch();      

        return $result;
    }

    public static function loadRacePet() {
        $db = new Connect();
        $dbconect = $db->ConnectDB();

        $stmt = $dbconect->query("SELECT * FROM aux_race_pets");                   
        $result = $stmt->fetch();      

        return $result;
    }

    public static function getNews() {
        $db = new Connect();
        $dbconect = $db->ConnectDB();

        $stmt = $dbconect->query("SELECT * FROM tb_news ");
        $result = $stmt->fetch();

        return $result;
    }
    

    public static function getIdUser() {
        $db = new Connect();
        $dbconect = $db->ConnectDB();

        $stmt = $dbconect->query("SELECT id_user FROM tb_users WHERE email_user = '{$_COOKIE['login']}' ");

        $result = $stmt->fetch();

        return $result['id_user'];
    }
    

    public static function getSelectOption($bd, $prefix) {
        $db = new Connect();
        $dbconect = $db->ConnectDB();

        $stmt = $dbconect->query("SELECT * FROM {$bd}");

        $todos_options = $stmt->fetchAll();
        
        foreach ($todos_options as $option) {
          $retorno[$option['id_'.$prefix]] = $option['name_'.$prefix];
        }
        return $retorno;
    }

}
?>

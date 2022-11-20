<?php

namespace App;

include($_SERVER['DOCUMENT_ROOT'] . '/projeto-caramelo-php/vendor/autoload.php');

use App\Connect;

class Functions
{
    function __construct($dbcon)
    {
        $GLOBALS['db'] = $dbcon;
    }

    public static function getUrlDocument()
    {
        $_url = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
        $_url = implode(DIRECTORY_SEPARATOR, array_slice($_url, 0, 5));
        return $_url;
    }

    public static function cadastrarPet($name, $gender, $weight, $type, $race, $birth, $id_owner, $photo = null)
    {
        $stmt = $GLOBALS['db']->query("INSERT INTO tb_pets (name_pet, gender_pet, weight_pet, type_pet, race_pet, birth_pet, id_owner, photo_id, time_added)
                 VALUES ('{$name}','{$gender}', {$weight}, {$type}, {$race}, '{$birth}', {$id_owner},'{$photo}', NOW())");

        $result = $stmt->fetch();

        return $result;
    }

    public static function atualizarPet($id_pet, $name, $gender, $weight, $type, $race, $birth, $id_owner, $photo = null)
    {
        $stmt = $GLOBALS['db']->query("UPDATE tb_pets SET name_pet = '{$name}', gender_pet = '{$gender}', weight_pet = {$weight}, type_pet = {$type}, race_pet = {$race}, birth_pet = '{$birth}', 
                                id_owner = {$id_owner}, photo_id = '{$photo}', time_added = NOW() WHERE id_pet = {$id_pet}");

        $result = $stmt->fetch();

        return $result;
    }

    public static function removerPet($id_pet)
    {

        $stmt = $GLOBALS['db']->query("DELETE FROM tb_pets where id_pet = {$id_pet};");

        $result = $stmt->fetch();

        return $result;
    }

    public static function loadTypePet()
    {
        $stmt = $GLOBALS['db']->query("SELECT * FROM aux_type_pets");
        $result = $stmt->fetch();

        return $result;
    }

    public static function loadRacePet()
    {
        $stmt = $GLOBALS['db']->query("SELECT * FROM aux_race_pets");
        $result = $stmt->fetch();

        return $result;
    }

    public static function getNews($id_news = null)
    {
        if ($id_news == null) {
            $stmt = $GLOBALS['db']->query("SELECT * FROM tb_news WHERE status");
            $result = $stmt->fetchAll();
        } else {
            $stmt = $GLOBALS['db']->query("SELECT * FROM tb_news WHERE status AND id_news = {$id_news}");
            $result = $stmt->fetch();
        }

        return $result;
    }


    public static function getIdUser()
    {
        $stmt = $GLOBALS['db']->query("SELECT id_user FROM tb_users WHERE email_user = '{$_COOKIE['login']}' ");

        $result = $stmt->fetch();

        return $result['id_user'];
    }

    public static function getIdPet()
    {
        $query = $GLOBALS['db']->query("SELECT MAX(id_pet) as id_pet FROM tb_pets;");
        $_pet_id = $query->fetch();
        $_pet_id = $_pet_id['id_pet'];
        return $_pet_id;
    }

    public static function getPet($_id_pet)
    {
        $sth = $GLOBALS['db']->query("SELECT * FROM tb_pets WHERE id_pet = {$_id_pet} ");
        $pet = $sth->fetch();
        return $pet;
    }

    public static function getAllPetsOwner($user)
    {
        $sth = $GLOBALS['db']->query("SELECT * FROM tb_pets where id_owner = '{$user['id_user']}'");
        $pets = $sth->fetchAll();
        return $pets;
    }

    public static function getAllPetsPhotosOwner($user)
    {
        $user_pets = $GLOBALS['db']->query("SELECT * FROM tb_pets where id_owner = '{$user['id_user']}'");
        foreach ($user_pets as $pet) {
            $pets_id[$pet['id_pet']] = $pet['id_pet'];
        }
        unset($user_pets);
        if(@$pets_id) {
        $_pets_ids = implode(',', $pets_id);
        $sth = $GLOBALS['db']->query("SELECT * FROM tb_photos WHERE id_pet in ({$_pets_ids})");
        $photos = $sth->fetchAll();
        return $photos;
        } else {
            return false;
        }
    }

    public static function getPhoto($_id_pet)
    {
        $sth = $GLOBALS['db']->query("SELECT * FROM tb_photos WHERE id_pet = {$_id_pet} ");
        $photo = $sth->fetch();
        return $photo;
    }

    public static function UpdateUploadPhoto($_arquivo, $_pet_id)
    {
        if (@$_arquivo['photo']['tmp_name']) {
            $tipo_arquivo = explode('/', $_arquivo['photo']['type']);
            $tipo_arquivo = $tipo_arquivo[0];
            if ($tipo_arquivo != 'image') {
                echo "<script>alert('A imagem deve ser uma imagem!');</script>";
            } else {
                $arquivo = $_arquivo["photo"]["tmp_name"];
                $tamanho = $_arquivo["photo"]["size"];
                $tipo = $_arquivo["photo"]["type"];
                $nome = $_arquivo["photo"]["name"];
                $fp = fopen($arquivo, "rb");
                $conteudo = fread($fp, $tamanho);
                $conteudo = imagecreatefromstring($conteudo);
                if ($tamanho > 1000000)
                    $conteudo = imagescale($conteudo, '500', '500');
                fclose($fp);
                ob_start();
                imagepng($conteudo);
                $conteudo = ob_get_contents();
                ob_end_clean();
                $_imgType = $tipo;
                $_imgData = base64_encode($conteudo);
                $sth = $GLOBALS['db']->query("DELETE FROM tb_photos WHERE id_pet = {$_pet_id};");
                $sth = $GLOBALS['db']->query("INSERT INTO tb_photos VALUES(null, '{$_imgData}', '{$_imgType}', {$_pet_id});");
            }
        }
    }

    public static function getUser()
    {
        $stmt = $GLOBALS['db']->query("SELECT 
                       name_user,
                       id_user,
                       role_user
                       FROM tb_users 
                       WHERE email_user = '{$_COOKIE['login']}'");

        $user = $stmt->fetch();

        return $user;
    }

    public static function getVet($user)
    {
        $stmt = $GLOBALS['db']->query("SELECT *
                          FROM tb_vets
                          WHERE id_user = '{$user['id_user']}'");
        $vet = $stmt->fetch();

        return $vet;
    }


    public static function getSelectOption($bd, $prefix)
    {
        $stmt = $GLOBALS['db']->query("SELECT * FROM {$bd}");

        $todos_options = $stmt->fetchAll();

        foreach ($todos_options as $option) {
            $retorno[$option['id_' . $prefix]] = $option['name_' . $prefix];
        }
        return $retorno;
    }

    public static function validarEmail($_email, $_aviso = false)
    {
        $query = $GLOBALS['db']->query("SELECT email_user FROM tb_users WHERE email_user = '{$_email}'");
        $_email_usado = $query->fetch();
        if (!empty($_email_usado)) {
            $_email_usado['usado'] = true;
        } else {
            $_email_usado['usado'] = false;
        }

        if ($_aviso) {
            if ($_email_usado) {
                $_email_usado['html'] = '<div class="alert alert-danger" role="alert" style="border-radius: 0; margin: 0;">
                                                O e-mail que tentou cadastrar já está em uso.
                                            </div>';
            } else {
                $_email_usado['html'] = '<div class="alert alert-success" role="alert" style="border-radius: 0; margin: 0;">
                                            Sua conta foi criada com sucesso! Você já pode acessa-lá!
                                        </div>';
            }
        }
        return $_email_usado;
    }
}

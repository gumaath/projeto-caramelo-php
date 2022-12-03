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

    public static function loadTypePets()
    {
        $stmt = $GLOBALS['db']->query("SELECT * FROM aux_type_pets");
        $result = $stmt->fetch();

        return $result;
    }

    public static function loadRacePets()
    {
        $stmt = $GLOBALS['db']->query("SELECT * FROM aux_race_pets");
        $result = $stmt->fetch();

        return $result;
    }

    public static function loadTypePet($id_type)
    {
        $stmt = $GLOBALS['db']->query("SELECT * FROM aux_type_pets where id_type = {$id_type}");
        $result = $stmt->fetch();

        return $result;
    }

    public static function loadRacePet($id_race)
    {
        $stmt = $GLOBALS['db']->query("SELECT * FROM aux_race_pets where id_race = {$id_race}");
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
            $_email_usado['status'] = 0;
        } else {
            $_email_usado['usado'] = false;
            $_email_usado['status'] = 1;
        }

        if ($_aviso) {
            if ((int)$_email_usado['usado']) {
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

    public static function cadastrarUsuario($params) {
      switch ($params['tipoUsuario']) {
        case 1:
          $tipo_usuario = 'TUTOR';
          break;
        case 2:
          $tipo_usuario = 'VET';
          break;
      }
      $stmt = $GLOBALS['db']->query("INSERT INTO tb_users (name_user, cpf_user, rg_user, birth_user, role_user, email_user, tel_user, gender_user, passwd_user, active_user)
        VALUES('{$params['formNome']}', '{$params['formCPF']}', '{$params['formRG']}', '{$params['BirthDate']}', '{$tipo_usuario}', '{$params['formEmail']}', '{$params['formTel']}', '{$params['gender']}', '{$params['formPass']}', 1)");
      if($tipo_usuario == 'VET') {
        $stmt = $GLOBALS['db']->query("INSERT INTO tb_vets (crmv_vet, id_user) VALUES ({$params['formCMRV']}, {$GLOBALS['db']->lastInsertId()})");
      }
    }

    public static function returnVaccineData($id_pet, $vaccine_name = null, $vaccine_date = null) {

        $sqlExists = "SELECT EXISTS(SELECT 1 FROM tb_vaccines WHERE id_pet = {$id_pet})";
        $sth_exists = $GLOBALS['db']->query($sqlExists);
        
        if(!$sth_exists->fetchColumn()) { 
            return null;
        }

        $sql = 
        "SELECT 
            va.id_vaccine as id_vacina,
            va.name_vaccine as vacina, 
            va.description as descricao,
            va.aplication_date as data_aplicacao,   
            va.attachment_url as url,         
            p.name_pet as pet,  
            p.id_pet as id_pet,
            u.name_user as vet,
            u.tel_user as fone
        FROM tb_vaccines as va 
            INNER JOIN tb_pets p ON
                p.id_pet = va.id_pet
            INNER JOIN tb_vets v ON
                v.id_vet = va.id_vet
            INNER JOIN tb_users u ON
                u.id_user = v.id_user 
        WHERE va.id_pet = {$id_pet} ";

        if((!empty($vaccine_name) && !empty($vaccine_date)) && ($vaccine_name != null && $vaccine_date != null)) {
            $sql .= " AND name_vaccine = '{$vaccine_name}' AND aplication_date = '{$vaccine_date}' ";                       
        }

        if((!empty($vaccine_name) && $vaccine_name != null) && ($vaccine_date == null || empty($vaccine_date))) {
            $sql .= " AND name_vaccine = '{$vaccine_name}' ";
        }

        if((!empty($vaccine_date) && $vaccine_date != null) && ($vaccine_name == null || empty($vaccine_name))) {
            $sql .= " AND aplication_date = '{$vaccine_date}' ";
        }

        $stmt = $GLOBALS['db']->query($sql);

        $data = $stmt->fetchAll();
        return $data;
    }

    public static function formatDate($date) {

        $date = explode("-", $date);
        $dataRefact = $date[2]."/".$date[1]."/".$date[0];
    
        echo $dataRefact;
    }

    public static function formatWhatsApp($fone) {
        $fone = explode("-", $fone);
        $fone = trim($fone[0]).trim($fone[1]);                

        $fone = str_replace("(", "", $fone);
        $wpp = str_replace(")", "", $fone);        

        return preg_replace("/\s+/", '', $wpp);
    }

    public static function UpdateUploadAttachment($_arquivo, $_pet_id, $type, $_id)
    {
      switch ($type) {
      case 'vaccine':
        $_type = 'vaccines';
        $_tabela = 'tb_vaccines';
        $__id = 'id_vaccine';
      break;
      }
            $tipo_arquivo = explode('/', $_arquivo['photo']['type']);
            $tipo_arquivo = $tipo_arquivo[1];
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/projeto-caramelo-php/'. "src/assets/attachments/";
            if(!is_dir($target_dir . "{$_pet_id}/{$_type}/")) {
              mkdir($target_dir . "{$_pet_id}/{$_type}/", 0777, true);
            }
            $id_unico = uniqid("att_");
        $target_file = $target_dir . "{$_pet_id}/{$_type}/" . $id_unico . "." . $tipo_arquivo;
        $_target_file = $id_unico . "." . $tipo_arquivo;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
          $check = getimagesize($_arquivo["photo"]["tmp_name"]);
          if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
          } else {
            echo "File is not an image.";
            $uploadOk = 0;
          }

// Check file size
if ($_arquivo["photo"]["size"] > 500000) {
  return "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_arquivo["photo"]["tmp_name"], $target_file)) {
      $stmt = $GLOBALS['db']->query("UPDATE {$_tabela} SET attachment_url = '{$_target_file}' WHERE id_pet = {$_pet_id} AND {$__id} = {$_id}");
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}

            }

    public static function cadastrarVacina($params)
    {
        $stmt = $GLOBALS['db']->query("INSERT INTO tb_vaccines (name_vaccine, id_pet, id_vet, aplication_date, description)
                 VALUES ('{$params['formNome']}',{$params['id_pet']}, {$params['id_vet']}, '{$params['DateApplication']}', '{$params['formDesc']}')");

        $result = $GLOBALS['db']->lastInsertId();

        return $result;
    }
}

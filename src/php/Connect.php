<?php

namespace App;

include($_SERVER['DOCUMENT_ROOT'] . '/projeto-caramelo-php/vendor/autoload.php');

class Connect
{

  public static function ConnectDB()
  {
    try {
      $dbName = 'projeto_caramelo';
      $user = 'rafael';
      $pwd = 'rafael2022';

      return new \PDO("mysql:host=25.4.165.105;dbname={$dbName};charset=utf8", $user, $pwd, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC));
    } catch (\PDOException $e) {

      return $e->getMessage();
    }
  }
}

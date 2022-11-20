<?php

namespace App;

include($_SERVER['DOCUMENT_ROOT'] . '/projeto-caramelo-php/vendor/autoload.php');

use App\Connect;

class Auth
{

    public static function verificaLogin($email, $senha)
    {
        $db = new Connect();
        $dbcon = $db->ConnectDB();

        $stmt = $dbcon->query("SELECT 
                                email_user,     
                                passwd_user,  
                                active_user,
                                role_user
                                FROM tb_users 
                                WHERE email_user = '$email' 
                                AND passwd_user = '$senha' 
                                AND active_user = 1");

        $user = $stmt->fetch();

        if (!$user)
            return false;
        else
            if ($user['role_user'] === 'ADMIN')
            return "A";
        elseif ($user['role_user'] === 'TUTOR')
            return "T";
        elseif ($user['role_user'] === 'VET')
            return "V";
    }

    public static function createSession($email)
    {
        session_start();
        session_regenerate_id(true);
        $session_id = session_id();
        $db = new Connect();
        $dbcon = $db->ConnectDB();
        #print_r("INSERT INTO tb_sessions(user_email, php_session_id, datetime_session) VALUES('{$email}', '{$session_id}', NOW())");
        $session = $dbcon->query("INSERT INTO tb_sessions(user_email, php_session_id, datetime_session) VALUES('{$email}', '{$session_id}', NOW())");

        return $session;
    }

    public static function verificaSessionLogin()
    {
        $db = new Connect();
        $dbcon = $db->ConnectDB();
        $session = $dbcon->query("SELECT * FROM tb_sessions WHERE user_email = '{$_COOKIE['login']}' AND php_session_id = '" . $_COOKIE['PHPSESSID'] . "' ORDER BY datetime_session DESC")->fetch();
        if ($session) {
            $dbcon->query("DELETE FROM tb_sessions WHERE user_email = '{$_COOKIE['login']}' AND php_session_id <> '" . $_COOKIE['PHPSESSID'] . "';");
            $dbcon->query("UPDATE tb_sessions SET datetime_session = NOW() WHERE user_email = '{$_COOKIE['login']}' AND php_session_id = '" . $_COOKIE['PHPSESSID'] . "' ORDER BY datetime_session DESC");
        } else {
            echo "<script>alert('Faça login novamente!');window.location.href = './login.php';</script>";
        }
    }
}

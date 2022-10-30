<?php
namespace App; 

include ($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

class Functions {
    public static function getUrlDocument() {
        $_url = explode(DIRECTORY_SEPARATOR,dirname(__FILE__));
        $_url = implode(DIRECTORY_SEPARATOR, array_slice($_url, 0, 5));
        return $_url;
    }
}
?>
<?php

namespace functionAll;

use PDO;
use PDOException;
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'config.php';

/**
 * @param string connect функиция создает подключения в БД SQl, connect()
 */
function connect()
{
    static $connect;

    if (empty($connect)) {
        try {
            $connect = new PDO('mysql:host=' . HOST . '; dbname=' . DBNAME,
                USER, PASSWORD);
            if (!$connect->errorInfo()) {
                echo "\nPDO::errorInfo():\n";
                print_r($connect->errorInfo());
                die();
            }
        } catch (PDOException $exception) {
            echo 'нет доступа к базе данных ' . $exception->getMessage();
            exit;
        }

    }
    return $connect;
}



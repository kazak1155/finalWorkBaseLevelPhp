<?php

require_once DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'appFiles' . DIRECTORY_SEPARATOR . 'config.php';

/**
 * creating a connection to the PDO database
 */
class SQLconnectionPDO
{
    public function connect()
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
}

<?php

namespace App;

require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers.php';

/**
 * Class Config
 * @package App
 */
class Config
{
    private static $instance = null;
    private array $configurations = [];

    //ниже описанная функция проверяет есть ли экземпляр функции и если его нет, то создает
    public static function getInstance()
    {
        if (null === self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }


    private function __clone() {}
    private function __construct()
    {
        $this->load();
    }

    private function load()
    {
        foreach (glob($_SERVER['DOCUMENT_ROOT'] . '/config' . '/*.php') as $file) {
            $fileName = basename($file, '.php');
            $this->configurations[$fileName] = include $file;
        }
    }

    public function get(string $fileName, $default = null)
    {
        return array_get($this->configurations, $fileName, $default);
    }
}

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
const APP_DIR = __DIR__;
const VIEW_DIR = DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR;

spl_autoload_register(function ($class) {

    // префикс простанства имен
    $prefix = 'App';

    // базовый каталог для префикса пространства имен
    $base_dir = __DIR__ . '/src/';

    //использует ли класс префикс пространства имен
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // нет, переходим к следующему зарегистированному автоподгрузчику
        return;
    }

    // получаем относительное имя класса
    $relative_class = substr($class, $len);

    // создаем имя файла
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // если файл существует
    if (file_exists($file)) {
        require $file;
    }
});

<?php

function dd(...$params)
{
    echo '<pre>';
    var_dump($params);
    echo '</pre>';
    die;
}

function dump(...$params)
{
    echo '<pre>';
    var_dump($params);
    echo '</pre>';
}

function array_get(array $array, string $key, $default = null)
{
    $keyX = explode('.', $key);
    $keyOk = $keyX[array_key_last($keyX)];
    foreach (new RecursiveIteratorIterator(new RecursiveArrayIterator($array),
        RecursiveIteratorIterator::LEAVES_ONLY) as $key1 => $arr) {
        if ($keyOk === $key1) {
            $result = $arr;
            break;
        } else {
            $result = 'default';
        }
    }
    return $result;
}

/**
 * функиция getUser создает запрос в БД на вывод информации о пользователе
 *
 * @param string принимает параметр $email введеный пользователем
 * @return array с данными пользователя из БД
 */
function getUser($email)
{
    $sth = connect()->prepare("
    SELECT * FROM users
    WHERE users.email = :email");
    $sth->execute([':email' => $email]);

    return $sth->fetch();
}

/**
 * функиция flash берет значение $message из сессии и выводит в необходимом месте
 *
 * @return string значение переменной $message
 */
function flash()
{
    $message = $_SESSION['$message'];
    $_SESSION['$message'] = '';

    return $message;
}

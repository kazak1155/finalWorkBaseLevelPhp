<?php

namespace App\Controllers;

use App\Models\Directory;
use App\Models\File;
use App\View\Json;
use App\View\View;


/**
 * Class DirectoryController
 * @package App\Controllers
 */
class DirectoryController
{
    public function addDirectory()
    {
        if (isset($_POST['name'])) {
            $path = getcwd() . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $_POST['name'];
            if (!file_exists($path)) {
                mkdir($path);
                $message = 'папка создана';
                $result = true;
            } else {
                $message = 'такая папка уже существует';
                $result = false;
            }
        } else {
            $message = 'название папки не задано';
            $result = false;
        }


        return new Json(
            [
                'message' => $message,
                'result' => $result
            ]);
    }

    public function editDirectory()
    {
        $message = '';
        $result = '';

        return new Json(
            [
                'message' => $message,
                'result' => $result
            ]);
    }

    public function showFilesInDirectory($id)
    {
        $directory = Directory::find($id);
        $objectsJsonUser[] = [
            [
                'name' => $directory->name,
                'name_parent_folder' => $directory->name_parent_folder,
            ]
        ];

        return new Json(
            [
                'files' => json_encode($objectsJsonUser)
            ]);
    }

    public function deleteDirectory ($id)
    {
        $directory = Directory::find($id);
        if (isset($directory)) {
            $result = 'true';
//            $directory -> delete();
            $message = 'директория с именем: ' .  $directory->name . ' удалена';
        } else {
            $result = 'false';
            $message = 'такой директории нет в БД';
        }

        return new Json(
            [
                'message' => $message,
                'result' => $result
            ]);
    }
}

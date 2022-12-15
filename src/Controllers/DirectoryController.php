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
            $path = getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $_POST['name'];
            if (!file_exists($path)) {
                $newDirectory = new Directory();
                $newDirectory->name = $_POST['name'];
                $newDirectory->name_parent_folder = 'user_' . $_SESSION['userId'];
                $newDirectory->path = $path;
                $newDirectory->save();
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
        $jsonInput = file_get_contents('php://input');
        $body = json_decode($jsonInput, true);
        if (isset($body)) {
            if (isset($body['name'])) {
                if (isset($body['directory_id'])) {
                    $directory = Directory::find($body['directory_id']);
                    $oldNameDirectory = $directory->name;
                    $newNameDirectory = $body['name'];
                    rename((getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $oldNameDirectory),
                        (getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $newNameDirectory));
                    $directory->name = $body['name'];
                    $directory->save();
                    $message = 'папка переименована';
                    $result = true;
                } else {
                    $message = 'не передано какую папку переименовать';
                    $result = false;
                }
            } else {
                $message = 'имя папки не передано';
                $result = false;
            }
        } else {
            $message = 'ничего не передано';
            $result = false;
        }

        return new Json(
            [
                'message' => $message,
                'result' => $result
            ]);
    }

    public function showFilesInDirectory($id)
    {
        $files = File::where('directory_id', $id)->get();
        $arrayFiles = [];
        foreach ($files as $file){
            $arrayFiles[] = [
                [
                    'name' => $file->name
                ]
            ];
        }

        return new Json(
            [
                'files' => json_encode($arrayFiles)
            ]);
    }

    public function deleteDirectory($id)
    {
        $directory = Directory::find($id);
        if ($_SESSION['status_user'] == 'administrator' || $directory->user_create == $id){
            if (isset($directory)) {
                $result = 'true';
                $directory -> delete();
                rmdir ($directory->path);
                $message = 'директория с именем: ' .  $directory->name . ' удалена';
            } else {
                $result = 'false';
                $message = 'такой директории нет в БД';

                return new Json(
                    [
                        'message' => $message,
                        'result' => $result
                    ]);
            }
        } else {
            $result = 'false';
            $message = 'авторизированный пользователь не может удалить эту папку';

            return new Json(
                [
                    'message' => $message,
                    'result' => $result
                ]);
        }
    }
}

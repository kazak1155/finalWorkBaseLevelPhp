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
        if (isset($_SESSION['success'])) {
            if (isset($_POST['name'])) {
                $path = getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $_POST['name'];
                if (!file_exists($path)) {
                    $newDirectory = new Directory();
                    $newDirectory->name = $_POST['name'];
                    $directroryId = Directory::where('name', 'user_' . $_SESSION['userId'])->first();
                    $newDirectory->id_parent_folder = $directroryId->id;
                    $newDirectory->path = $path;
                    $newDirectory->id_user_create = $_SESSION['userId'];
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
        } else {
            $message = 'нет авторизированных пользователей';
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

        if (isset($_SESSION['success'])) {
            if ($_SESSION['status_user'] == 'administrator') {
                $jsonInput = file_get_contents('php://input');
                $body = json_decode($jsonInput, true);
                if (isset($body)) {
                    if (isset($body['name'])) {
                        if (isset($body['directory_id'])) {
                            $directoryExist = Directory::find($body['directory_id']);
                            if (isset($directoryExist)) {

                            } else {
                                $message = 'директории с таким id не существует';
                                $result = false;
                            }
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
            } elseif ($_SESSION['status_user'] == 'user') {

            }



            $jsonInput = file_get_contents('php://input');
            $body = json_decode($jsonInput, true);
            if (isset($body)) {
                if (isset($body['name'])) {
                    if (isset($body['directory_id'])) {
                        $directory = Directory::find($body['directory_id']);
                        if ($directory->id_user_create == $_SESSION['userId'] || $_SESSION['status_user'] == 'administrator') {
                            $oldNameDirectory = $directory->name;
                            $newNameDirectory = $body['name'];
                            rename((getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . 'user_' . $directory->id_user_create . DIRECTORY_SEPARATOR . $oldNameDirectory),
                                (getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . 'user_' . $directory->id_user_create . DIRECTORY_SEPARATOR . $newNameDirectory));
                            $directory->name = $body['name'];
                            $directory->save();
                            $message = 'папка переименована';
                            $result = true;
                        } else {
                            $message = 'авторизированный пользователь не может переименовать данную папку';
                            $result = false;
                        }
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
        } else {
            $message = 'нет авторизированных пользователей';
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
        if (isset($_SESSION['success'])) {
            if ($_SESSION['status_user'] == 'administrator') {
                if (isset($directory)) {
                    $files = File::where('directory_id', $id)->get();
                    if (File::where('directory_id', $id)->get()->count() > 0) {
                        $arrayFiles = [];
                        foreach ($files as $file){
                            $arrayFiles[] = [
                                [
                                    'name' => $file->name
                                ]
                            ];
                            $result = json_encode($arrayFiles);
                            $message = true;
                        }
                    } else {
                        $message = 'файлов в этой папке нет';
                        $result = true;
                    }
                } else {
                    $message = 'папки с таким id нет в БД';
                    $result = false;
                }
            } elseif ($_SESSION['status_user'] == 'user') {
                $directory = Directory::find($id);
                if (isset($directory)) {
                    if ($directory->id_user_create == $_SESSION['userId']) {
                        $files = File::where('directory_id', $id)->get();
                        if (File::where('directory_id', $id)->get()->count() > 0) {
                            $arrayFiles = [];
                            foreach ($files as $file){
                                $arrayFiles[] = [
                                    [
                                        'name' => $file->name
                                    ]
                                ];
                                $result = json_encode($arrayFiles);
                                $message = true;
                            }
                        } else {
                            $message = 'файлов в этой папке нет';
                            $result = true;
                        }
                    } else {
                        $message = 'авторизированный пользователь не может просмотреть файлы в данной папке';
                        $result = false;
                    }
                } else {
                   $message = 'папки с таким id нет в БД';
                   $result = false;
                }
            }
        } else {
            $message = 'нет авторизированных пользователей';
            $result = false;
        }

        return new Json(
            [
                'message' => $message,
                'result' => $result
            ]);
    }

    public function deleteDirectory($id)
    {
        $directory = Directory::find($id);
        if (isset($_SESSION['success'])) {
            if ($_SESSION['status_user'] == 'administrator' || $directory->id_user_create == $_SESSION['userId']) {
                if (isset($directory)) {
                    $result = 'true';
                    $directory -> delete();
                    rmdir ($directory->path);
                    $message = 'директория с именем: ' .  $directory->name . ' удалена';
                } else {
                    $result = 'false';
                    $message = 'такой директории нет в БД';
                }
            } else {
                $message = 'авторизированный пользователь не может удалить данную папку';
                $result = false;
            }
        } else {
            $message = 'нет авторизированных пользователей';
            $result = false;
        }

            return new Json(
                [
                    'message' => $message,
                    'result' => $result
                ]);

    }
}

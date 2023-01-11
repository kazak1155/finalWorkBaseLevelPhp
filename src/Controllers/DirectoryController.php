<?php

namespace App\Controllers;

use App\Models\Directory;
use App\Models\File;
use App\View\Json;


/**
 * Class DirectoryController
 * @package App\Controllers
 */
class DirectoryController
{
    public function addDirectory()
    {
        if (isset($_SESSION['success'])) {
            if ($_SESSION['status_user'] == 'administrator') {
                if (isset($_POST['name'])) {
                    if (isset($_POST['id_directory'])) {
                        $directory = Directory::find($_POST['id_directory']);
                        if (isset($directory)) {
                            if ($directory->id_parent_folder != null) {
                                $parentDirectory = Directory::find($directory->id_parent_folder);
                                $newDirectory = new Directory();
                                $newDirectory->name = $_POST['name'];
                                $path = getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . $parentDirectory->name . DIRECTORY_SEPARATOR . $directory->name . DIRECTORY_SEPARATOR . $_POST['name'];
                                $newDirectory->path = $path;
                                $newDirectory->id_user_create = $_SESSION['userId'];
                                $newDirectory->save();
                                mkdir($path);
                                $message = 'добавлена новая папка с именем ' . $_POST['name'] . '  в папку с именем ' . $parentDirectory->name . ' и затем в папку с именем ' . $directory->name;
                                $result = true;
                            } else {
                                $newDirectory = new Directory();
                                $newDirectory->name = $_POST['name'];
                                $path = getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . $_POST['name'];
                                $newDirectory->path = $path;
                                $newDirectory->id_user_create = $_SESSION['userId'];
                                $newDirectory->save();
                                mkdir($path);
                                $message = 'добавлена новая папка с именем ' . $_POST['name'] . '  в папку с именем ' . 'dataUser';
                                $result = true;
                            }
                        } else {
                            $message = 'директории с таким id не существует';
                            $result = false;
                        }
                    } else {
                        $newDirectory = new Directory();
                        $newDirectory->name = $_POST['name'];
                        $path = getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . $_POST['name'];
                        $newDirectory->path = $path;
                        $newDirectory->id_user_create = $_SESSION['userId'];
                        $newDirectory->save();
                        mkdir($path);
                        $message = 'добавлена новая папка с именем ' . $_POST['name'] . '  в папку с именем ' . 'dataUser';
                        $result = true;
                    }
                } else {
                    $message = 'название папки не задано';
                    $result = false;
                }
            } elseif ($_SESSION['status_user'] == 'user') {
                if (isset($_POST['name'])) {
                    if (isset($_POST['id_directory'])) {
                        $directory = Directory::find($_POST['id_directory']);
                        if (isset($directory)) {
                            if ($directory->id_user_create == $_SESSION['userId']) {
                                if ($directory->id_parent_folder != null) {
                                    $parentDirectory = Directory::find($directory->id_parent_folder);
                                    $newDirectory = new Directory();
                                    $newDirectory->name = $_POST['name'];
                                    $path = getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . $parentDirectory->name . DIRECTORY_SEPARATOR . $directory->name . DIRECTORY_SEPARATOR . $_POST['name'];
                                    $newDirectory->path = $path;
                                    $newDirectory->id_user_create = $_SESSION['userId'];
                                    $newDirectory->save();
                                    mkdir($path);
                                    $message = 'добавлена новая папка с именем ' . $_POST['name'] . '  в папку с именем ' . $parentDirectory->name . ' и затем в папку с именем ' . $directory->name;
                                    $result = true;
                                } else {
                                    $message = 'авторизированный пользователь не может создать папку в dataUser';
                                    $result = false;
                                }
                            } else {
                                $message = 'авторизированный пользователь не может создать папку в этой папке';
                                $result = false;
                            }
                        } else {
                            $message = 'директории с таким id не существует';
                            $result = false;
                        }
                    } else {
                        $message = 'авторизированный пользователь не может создать папку в dataUser';
                        $result = false;
                    }
                } else {
                    $message = 'название папки не задано';
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

    public function editDirectory()
    {
        if (isset($_SESSION['success'])) {
            if ($_SESSION['status_user'] == 'administrator') {
                $jsonInput = file_get_contents('php://input');
                $body = json_decode($jsonInput, true);
                if (isset($body)) {
                    if (isset($body['name'])) {
                        if (isset($body['directory_id'])) {
                            $directory = Directory::find($body['directory_id']);
                            if (isset($directory)) {
                                $pathOld = $directory->path;
                                if ($directory->id_parent_folder != null) {
                                    $parentDirectory = Directory::find($directory->id_parent_folder);
                                    $pathNew = getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . $parentDirectory->name . DIRECTORY_SEPARATOR . $body['name'];
                                    $directory->name = $body['name'];
                                    $directory->path = $pathNew;
                                    $directory->save();
                                    rename($pathOld, $pathNew);
                                    $message = 'папка с id =' . $body['directory_id'] . ' переименована';
                                    $result = true;
                                } else {
                                    $pathNew = getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . $body['name'];
                                    $directory->name = $body['name'];
                                    $directory->path = $pathNew;
                                    $directory->save();
                                    rename($pathOld, $pathNew);
                                    $message = 'папка с id =' . $body['directory_id'] . ' переименована';
                                    $result = true;
                                }
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
                $jsonInput = file_get_contents('php://input');
                $body = json_decode($jsonInput, true);
                if (isset($body)) {
                    if (isset($body['directory_id'])) {
                        $directory = Directory::find($body['directory_id']);
                        if (isset($directory)) {
                            if ($directory->id_user_create == $_SESSION['userId']) {
                                if (isset($body['name'])) {
                                    $pathOld = $directory->path;
                                    if ($directory->id_parent_folder != null) {
                                        $parentDirectory = Directory::find($directory->id_parent_folder);
                                        $pathNew = getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . $parentDirectory->name . DIRECTORY_SEPARATOR . $body['name'];
                                        $directory->name = $body['name'];
                                        $directory->path = $pathNew;
                                        $directory->save();
                                        rename($pathOld, $pathNew);
                                        $message = 'папка с id =' . $body['directory_id'] . ' переименована';
                                        $result = true;
                                    } else {
                                        $pathNew = getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . $body['name'];
                                        $directory->name = $body['name'];
                                        $directory->path = $pathNew;$directory->save();
                                        rename($pathOld, $pathNew);
                                        $message = 'папка с id =' . $body['directory_id'] . ' переименована';
                                        $result = true;
                                    }
                                } else {
                                    $message = 'имя папки не передано';
                                    $result = false;
                                }
                            } else {
                                $message = 'авторизированный пользователь не может изменить имя данной папки';
                                $result = false;
                            }
                        } else {
                            $message = 'директории с таким id не существует';
                            $result = false;
                        }
                    } else {
                        $message = 'не передано какую папку переименовать';
                        $result = false;
                    }
                } else {
                $message = 'ничего не передано';
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

    public function showFilesInDirectory($id)
    {
        if (isset($_SESSION['success'])) {
            if ($_SESSION['status_user'] == 'administrator') {
                $directory = Directory::find($id);
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
                            $result = false;
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
        if (isset($_SESSION['success'])) {
            if ($_SESSION['status_user'] == 'administrator') {
                $directory = Directory::find($id);
                if (isset($directory)) {
                    $message = 'директория с именем: ' .  $directory->name . ' удалена';
                    $result = true;
                    $directory -> delete();
                    rmdir ($directory->path);
                } else {
                    $message = 'такой директории нет в БД';
                    $result = false;
                }
            } elseif ($_SESSION['status_user'] == 'user') {
                $directory = Directory::find($id);
                if (isset($directory)) {
                    if ($directory->id_user_create == $_SESSION['userId']) {
                        $message = 'директория с именем: ' .  $directory->name . ' удалена';
                        $result = true;
                        $directory -> delete();
                        rmdir ($directory->path);
                    } else {
                        $message = 'авторизированный пользователь не может удалить данную директорию';
                        $result = false;
                    }
                } else {
                    $message = 'такой директории нет в БД';
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
}

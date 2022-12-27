<?php

namespace App\Controllers;

use App\Models\Directory;
use App\Models\File;
use App\Models\User;
use App\View\Json;

/**
 * Class FileController
 * @package App\Controllers
 */
class FileController
{
    public function showAllFiles()
    {
        if (isset($_SESSION['success'])) {
            if ($_SESSION['status_user'] == 'administrator') {
                $files = File::all();
                $objectsJsonUser = [];
                foreach ($files as $file) {
                    $objectsJsonUser[] = [
                        [
                            'name' => $file->name,
                            'path' => $file->path,
                            'user' => $file->user,
                            'directory' => $file->folder->name ?? '',
                        ]
                    ];
                }
                $files = json_encode($objectsJsonUser);
                $message = '';
            } elseif ($_SESSION['status_user'] == 'user') {
                $files = File::where('available_to_users', $_SESSION['userId'])
                    ->get();
                $objectsJsonUser = [];
                foreach ($files as $file) {
                    $objectsJsonUser[] = [
                        [
                            'name' => $file->name,
                            'path' => $file->path,
                            'user' => $file->user,
                            'directory' => $file->folder->name ?? '',
                        ]
                    ];
                }
                $files = json_encode($objectsJsonUser);
                $message = '';
            } else {
                $files = '';
                $message = 'авторизированный пользователь не администратор';
            }
        } else {
            $files = '';
            $message = 'нет авторизированных пользователей';
        }

        return new Json(
            [
                'message' => $message,
                'files' => $files
            ]);
    }

    public function addFile()
    {
        if (isset($_SESSION['success'])) {
            if ($_SESSION['status_user'] == 'administrator') {
                if (!empty($_FILES)) {
                    foreach ($_FILES as $data) {
                        if (isset($_POST['Id_directory'])) {
                            $folder = Directory::where('id', $_POST['Id_directory'])->first();
                            $directoryName = $folder->name;
                            $directoryUser = $folder->id_user_create;
                            $destianation = getcwd()  . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . 'user_' . $directoryUser . DIRECTORY_SEPARATOR . $directoryName . DIRECTORY_SEPARATOR . $data['name'];
                            move_uploaded_file($_FILES['file']['tmp_name'], $destianation);
                            $newFile = new File();
                            $newFile->name = $data['name'];
                            $newFile->user = $_SESSION['userId'];
                            $newFile->path = $destianation;
                            $newFile->directory_id = $folder->id;
                            $newFile->available_to_users = $_SESSION['userId'] . ' ';
                            $newFile->save();

                            $message = 'файл с именем ' . $data['name'] . ' загружен в БД';
                            $result = true;
                        } else {
                            $destianation = getcwd()  . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $data['name'];
                            move_uploaded_file($_FILES['file']['tmp_name'], $destianation);
                            $newFile = new File();
                            $newFile->name = $data['name'];
                            $newFile->user = $_SESSION['userId'];
                            $newFile->path = $destianation;
                            $folder = Directory::where('name', ('user_' . $_SESSION['userId']))->first();
                            $newFile->directory_id = $folder->id;
                            $newFile->available_to_users = $_SESSION['userId'] . ' ';
                            $newFile->save();

                            $message = 'файл с именем ' . $data['name'] . ' загружен в БД';
                            $result = true;
                        }
                    }
                } else {
                    $message = 'никокого файла не передано';
                    $result = false;
                }
            } elseif ($_SESSION['status_user'] == 'user') {
                $folder = Directory::where('id', $_POST['Id_directory'])->first();
                $test = $folder->id_user_create;
                if ($test == $_SESSION['userId']) {
                    if (!empty($_FILES)) {
                        foreach ($_FILES as $data) {
                            if (isset($_POST['Id_directory'])) {
                                $folder = Directory::where('id', $_POST['Id_directory'])->first();
                                $directoryName = $folder->name;

                                $destianation = getcwd()  . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $directoryName . DIRECTORY_SEPARATOR . $data['name'];
                                move_uploaded_file($_FILES['file']['tmp_name'], $destianation);
                                $newFile = new File();
                                $newFile->name = $data['name'];
                                $newFile->user = $_SESSION['userId'];
                                $newFile->path = $destianation;
                                $newFile->directory_id = $folder->id;
                                $newFile->available_to_users = $_SESSION['userId'] . ' ';
                                $newFile->save();
                                $message = 'файл с именем ' . $data['name'] . ' загружен в БД';
                                $result = true;
                            } else {
                                $destianation = getcwd()  . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $data['name'];
                                move_uploaded_file($_FILES['test']['tmp_name'], $destianation);
                                $name = 'user_' . $_SESSION['userId'];
                                $folder = Directory::where('name', $name)->first();
                                $newFile = new File();
                                $newFile->name = $data['name'];
                                $newFile->user = $_SESSION['userId'];
                                $newFile->path = $destianation;
                                $newFile->directory_id = $folder->id;
                                $newFile->available_to_users = $_SESSION['userId'] . ' ';
                                $newFile->save();
                                $message = 'файл с именем ' . $data['name'] . ' загружен в БД';
                                $result = true;
                            }
                        }
                    } else {
                        $message = 'никокого файла не передано';
                        $result = false;
                    }
                } else {
                    $message = 'авторизированный пользователь не может записать файл в данную папку';
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

    public function editFile()
    {
        $jsonInput = file_get_contents('php://input');
        $body = json_decode($jsonInput, true);

        if (isset($_SESSION['success'])) {
            if ($_SESSION['status_user'] == 'administrator') {
                if (isset($body['newName'])) {
                    $file = File::find($body['id']);
                    $directory = Directory::find($file->directory_id);
                    $directoryName = $directory->name;
                    $directoryName_parent_folder = $directory->name_parent_folder;
                    $pieces = explode(".", $file->name);
                    $oldName = $file->name;
                    $newName = $body['newName'] . '.' . end($pieces);
                    if (isset($body['id_directory'])) {
                        $directoryTo = Directory::find($body['id_directory']);
                        $directoryNameTo = $directoryTo->name;
                        $directoryParentName = $directoryTo->name_parent_folder;
                        if (!($directoryName_parent_folder == '')) {
                            rename((getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $directoryName . DIRECTORY_SEPARATOR . $oldName),
                                (getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . $directoryParentName . DIRECTORY_SEPARATOR . $directoryNameTo . DIRECTORY_SEPARATOR . $newName));
                            $file->name = $newName;
                            $file->directory_id = $body['id_directory'];
                            $file->save();

                            $message = 'файл успешно изменен';
                            $result = true;
                        } else {
                            rename((getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $directoryName . DIRECTORY_SEPARATOR . $oldName),
                                (getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $directoryName . DIRECTORY_SEPARATOR . $newName));
                            $file->name = $newName;
                            $file->directory_id = $body['id_directory'];
                            $file->save();

                            $message = 'файл переименован и сохранен в той же папке';
                            $result = true;
                        }
                    } else {
                        rename((getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $directoryName . DIRECTORY_SEPARATOR . $oldName),
                            (getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $directoryName . DIRECTORY_SEPARATOR . $newName));
                        $file->name = $newName;
                        $file->directory_id = $body['id_directory'];
                        $file->save();

                        $message = 'файл переименован и сохранен в той же папке';
                        $result = false;
                    }
                } else {
                    $message = 'ничего не передано в запросе';
                    $result =  false;
                }
            } elseif ($_SESSION['status_user'] == 'user') {
                $file = File::find($body['id']);
                if ($file->user == $_SESSION['userId']) {
                    if (isset($body['newName'])) {
                        $file = File::find($body['id']);
                        $directory = Directory::find($file->directory_id);
                        $directoryName = $directory->name;
                        $directoryName_parent_folder = $directory->name_parent_folder;
                        $pieces = explode(".", $file->name);
                        $oldName = $file->name;
                        $newName = $body['newName'] . '.' . end($pieces);
                        if ($directory->id_user_create == $_SESSION['userId']) {
                            if (isset($body['id_directory'])) {
                                $directoryTo = Directory::find($body['id_directory']);
                                $directoryNameTo = $directoryTo->name;
                                $directoryParentName = $directoryTo->name_parent_folder;
                                if (!($directoryName_parent_folder == '')) {
                                    rename((getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $directoryName . DIRECTORY_SEPARATOR . $oldName),
                                        (getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . $directoryParentName . DIRECTORY_SEPARATOR . $directoryNameTo . DIRECTORY_SEPARATOR . $newName));
                                    $file->name = $newName;
                                    $file->directory_id = $body['id_directory'];
                                    $file->save();

                                    $message = 'файл успешно изменен';
                                    $result = true;
                                } else {
                                    rename((getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $directoryName . DIRECTORY_SEPARATOR . $oldName),
                                        (getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $directoryName . DIRECTORY_SEPARATOR . $newName));
                                    $file->name = $newName;
                                    $file->directory_id = $body['id_directory'];
                                    $file->save();

                                    $message = 'файл переименован и сохранен в той же папке';
                                    $result = true;
                                }
                            } else {
                                rename((getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $directoryName . DIRECTORY_SEPARATOR . $oldName),
                                    (getcwd() . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $directoryName . DIRECTORY_SEPARATOR . $newName));
                                $file->name = $newName;
                                $file->directory_id = $body['id_directory'];
                                $file->save();

                                $message = 'файл переименован и сохранен в той же папке';
                                $result = false;
                            }
                        } else {
                            $message = 'авторизированный пользователь не может изменить файл в данной папке';
                            $result = false;
                        }
                    } else {
                        $message = 'ничего не передано в запросе';
                        $result =  false;
                    }
                } else {
                    $message = 'авторизированный пользователь не может изменить данный файл';
                    $result =  false;
                }
            }
        } else {
            $message = 'нет авторизированных пользователей';
            $result =  false;
        }

        return new Json(
            [
                'message' => $message,
                'result' => $result
            ]);
    }

    public function showFileById($id)
    {
        if (isset($_SESSION['success'])) {
            $file = File::find($id);
             $userIdCreator = $file->user;
            if ($_SESSION['userId'] == $userIdCreator || $_SESSION['status_user'] == 'administrator') {
                $objectsJsonUser[] = [
                    [
                        'name' => $file->name,
                        'path' => $file->path,
                        'user' => $file->user,
                        'directory' => $file->folder->name,
                    ]
                ];
                $files = $objectsJsonUser;
                $message = '';
            } else {
                $files = '';
                $message = 'авторизированный пользователь не может узнать данные этого файла';
            }
        } else {
            $files = '';
            $message = 'нет авторизированных пользователей';
        }

        return new Json(
            [
                'files' => $files,
                'message' => $message,
            ]);
    }

    public function deleteFile($id)
    {
        if (isset($_SESSION['success'])) {
            $file = File::find($id);
            if (isset($file)) {
                if ($_SESSION['userId'] == $file->user || $_SESSION['status_user'] == 'administrator') {
                    $filepath = $file->path;
                    unlink($filepath);
                    $message ='файл с ID= ' . $id . ' удален';
                    $result = true; $file->delete();
                } else {
                    $message = 'авторизированный пользователь не может удалить данный файл';
                    $result = false;
                }
            } else {
                $message = 'файла с таким ИД нет в БД';
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

    public function showUsersAvailableToFile($id)
    {
        $file = File::find($id);
        if (isset($_SESSION['success'])) {
            if ($file->user == $_SESSION['userId'] || $_SESSION['status_user'] == 'administrator') {
                $arrayAvailableNameUsers = [];
                $arrayAvailableUsers = explode(' ', $file->available_to_users);
                foreach ($arrayAvailableUsers as $availableUsers) {
                    $user = User::find($availableUsers);
                    $arrayAvailableNameUsers[] = $user->name;
                }
                $message = '';
                $result = 'пользователи, кому доступен файл: ' . implode(",", $arrayAvailableNameUsers);
            } else {
                $message = 'авторизированный пользователь не может посмотреть, кому доступен данный файл';
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

    public function shareAvailableToFile($idFile, $idUser)
    {
        $file = File::find($idFile);
        $user1 = User::find($idUser);
        var_dump($user1->name);
        $available_to_users = explode(' ', $file->available_to_users);
//        var_dump($available_to_users); exit;
        if (isset($_SESSION['success'])) {
            if ($file->user == $_SESSION['userId'] || $_SESSION['status_user'] == 'administrator') {
                foreach ($available_to_users as $availabl_to_user) {
                    $user = User::find($availabl_to_user);
//                    var_dump($availabl_to_user);
                    if ($availabl_to_user == $idUser) {
                        $message = 'пользователь ' . $user1->name . ' уже имеет доступ к файлу';
                        $result = false;
                        break;
                    } else {
                        $file->availabl_to_users = $file->availabl_to_users . ' ' . $idUser;
//                        $file->save();
                        $message = 'пользователю ' . $user->name .  ' дан доступ к файлу';
                        $result = true;
//                        break;
                    }
                }
            } else {
                $message = 'авторизированный пользователь не может посмотреть, кому доступен данный файл';
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

    public function deleteAvailableToFile($idFile, $idUser)
    {
        $file = File::find($idFile);
        $availabl_to_users = explode(' ', $file->availabl_to_users);
        foreach ($availabl_to_users as $availabl_to_user) {
            $user = User::find($availabl_to_user);
            if ($availabl_to_user == $idUser) {
                $message = 'пользователю ' . $user->name .  ' убран доступ к файлу';
                $stringToDelete = ' ' . $idUser;
                $file->availabl_to_users = str_replace($stringToDelete, '', $file->availabl_to_users);
                $file->save();
                $result = true;
                break;
            } else {
                $message = 'у пользователя ' . $user->name .  ' нет доступа к файлу';
                $result = false;
            }
        }

        return new Json(
            [
                'message' => $message,
                'result' => $result
            ]);
    }
}
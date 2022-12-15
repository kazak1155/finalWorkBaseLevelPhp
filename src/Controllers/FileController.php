<?php

namespace App\Controllers;

use App\Models\Directory;
use App\Models\File;
use App\Models\User;
use App\View\Json;
use App\View\View;


/**
 * Class FileController
 * @package App\Controllers
 */
class FileController
{
    public function showAllFiles()
    {
        $files = File::all();
        $objectsJsonUser = [];
        foreach ($files as $file) {
            $objectsJsonUser[] = [
                [
//                    'id' => $file->id,
                    'name' => $file->name,
                    'path' => $file->path,
                    'user' => $file->user,
                    'directory' => $file->folder->name ?? '',
//                    'created_at' => $file->created_at,
//                    'updated_at' => $file->updated_at,
                ]
            ];
        }

        return new Json(
            [
                'files' => json_encode($objectsJsonUser)
            ]);
    }

    public function addFile()
    {
        if (!empty($_FILES)) {
            foreach ($_FILES as $data) {
                if (isset($_POST['directory'])) {
                    $folder = Directory::where('id', $_POST['directory'])->first();
                    $directoryName = $folder->name;
                    $destianation = getcwd()  . DIRECTORY_SEPARATOR . 'dataUser' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $directoryName . DIRECTORY_SEPARATOR . $data['name'];
                    move_uploaded_file($_FILES['file']['tmp_name'], $destianation);
                    $newFile = new File();
                    $newFile->name = $data['name'];
                    $newFile->user = $_SESSION['userId'];
                    $newFile->path = $destianation;
                    $newFile->directory_id = $folder->id;
                    $newFile->availabl_to_users = $_SESSION['userId'] . ' ';
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
                    $newFile->save();
                    $message = 'файл с именем ' . $data['name'] . ' загружен в БД';
                    $result = true;
                }
            }
        } else {
            $message = 'никокого файла не передано';
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


        return new Json(
            [
                'message' => $message,
                'result' => $result
            ]);
    }

    public function showFileById($id)
    {
        $file = File::find($id);
        if ($_SESSION['status_user'] == 'administrator' || $file->user == $id) {
            $objectsJsonUser[] = [
                [
                    'name' => $file->name,
                    'path' => $file->path,
                    'user' => $file->user,
                    'directory' => $file->folder->name,
                ]
            ];
            $files = $objectsJsonUser;
            $message = 'сведения о файле';
        } else {
            $files = '';
            $message = 'авторизированный пользователь не может просмотреть данный файл' ;
        }


        return new Json(
            [
                'files' => $files,
                'message' => $message,
            ]);
    }

    public function deleteFile($id)
    {
        $file = File::find($id);
        if (isset($file)) {
            $filepath = $file->path;
            unlink($filepath);
            $message ='файл с ID= ' . $id . ' удален';
            $result = true;
            $file->delete();
        } else {
            $message ='файла с таким ИД нет в БД';
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
        $arrayAvailableNmaeUsers = [];
        $files = File::find($id);
        $arrayAvailableUsers = explode(' ', $files->availabl_to_users);
        foreach ($arrayAvailableUsers as $availableUsers) {
            $user = User::find($availableUsers);
            $arrayAvailableNmaeUsers[] = $user->name;
        }
        $message = 'пользователи, кому доступен файл: ' . implode(",", $arrayAvailableNmaeUsers);

        return new Json(
            [
                'message' => $message,
            ]);
    }

    public function shareAvailableToFile($idFile, $idUser)
    {
        $file = File::find($idFile);
        $availabl_to_users = explode(' ', $file->availabl_to_users);
        foreach ($availabl_to_users as $availabl_to_user) {
            $user = User::find($availabl_to_user);
            if ($availabl_to_user == $idUser) {
                $message = 'пользователь уже имеет доступ к файлу';
                $result = false;
            } else {
                $file->availabl_to_users = $file->availabl_to_users . ' ' . $idUser;
                $file->save();
                $message = 'пользователю ' . $user->name .  ' дан доступ к файлу';
                $result = true;
                break;
            }
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
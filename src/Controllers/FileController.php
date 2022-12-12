<?php

namespace App\Controllers;

use App\Models\Directory;
use App\Models\File;
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
                    $directory = $_POST['directory'];
                    $folder = Directory::where('id', $_POST['directory'])->first();
                    $directoryName = $folder->name;
                    $destianation = getcwd()  . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $directoryName . DIRECTORY_SEPARATOR . $data['name'];
                    move_uploaded_file($_FILES['file']['tmp_name'], $destianation);
                    $newFile = new File();
                    $newFile->name = $data['name'];
                    $newFile->user = $_SESSION['userId'];
                    $newFile->path = $destianation;
                    $newFile->directory_id = $folder->id;
                    $newFile->save();
                    $message = 'файл с именем ' . $data['name'] . ' загружен в БД';
                    $result = true;
                } else {
                    $destianation = getcwd()  . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $data['name'];
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
                    rename((getcwd() . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $directoryName . DIRECTORY_SEPARATOR . $oldName),
                        (getcwd() . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . $directoryParentName . DIRECTORY_SEPARATOR . $directoryNameTo . DIRECTORY_SEPARATOR . $newName));
                    $file->save();

                    $message = 'файл успешно изменен';
                    $result = true;
                } else {
                    rename((getcwd() . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $directoryName . DIRECTORY_SEPARATOR . $oldName),
                        (getcwd() . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $directoryName . DIRECTORY_SEPARATOR . $newName));
                    $file->save();

                    $message = 'файл переименован и сохранен в той же папке';
                    $result = false;
                }
            } else {
                rename((getcwd() . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $directoryName . DIRECTORY_SEPARATOR . $oldName),
                    (getcwd() . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'user_' . $_SESSION['userId'] . DIRECTORY_SEPARATOR . $directoryName . DIRECTORY_SEPARATOR . $newName));
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
//        $folderName = $file->folder->name;
//        var_dump($file->folder->name);  exit;
//        $folder = Directory::find($file->directory_id);
        $objectsJsonUser[] = [
            [
//                    'id' => $file->id,
                'name' => $file->name,
                'path' => $file->path,
                'user' => $file->user,
                'directory' => $file->folder->name,
//                    'created_at' => $file->created_at,
//                    'updated_at' => $file->updated_at,
            ]
        ];

        return new Json(
            [
                'files' => json_encode($objectsJsonUser)
            ]);
    }

    public function deleteFile($id)
    {
        $file = File::find($id);
        if (isset($file)) {
            $message ='файл с ID= ' . $id . ' удален';
            $result = true;
            $file->delete();
        } else {
            $file = '';
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
        $message ='';

        return new Json(
            [
                'message' => $message,
            ]);
    }

    public function shareAvailableToFile($idFile, $idUser)
    {
        $message ='';

        return new Json(
            [
                'message' => $message,
            ]);
    }

    public function deleteAvailableToFile($idFile, $idUser)
    {
        $message ='';

        return new Json(
            [
                'message' => $message,
            ]);
    }
}
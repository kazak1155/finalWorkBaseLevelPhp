<?php

namespace App\Controllers;

use App\Class\Files;
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
//            var_dump($file->folder->name); exit;
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
        echo '<pre>';
        var_dump($_FILES['test']['name']);
        echo '</pre>';
        exit;
        if (!empty($_FILES)) {
            foreach ($_FILES as $data) {
                move_uploaded_file($data['tmp_name'], '/files/user_1/directory_1');
                var_dump($data);
            }
            $message = 'OK';
            $result = true;
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
        $message = '';
        $result = '';

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
//            $file->delete();
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

    public function showFileForm()
    {
        $title = 'страница для загрузки файла';

        return new View('file.fileForm',
            [
                'title' => $title,
            ]);
    }
}